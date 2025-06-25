<?php

namespace HisInOneProxy\Queue;

use Exception;
use HisInOneProxy\Config\GlobalSettings;
use HisInOneProxy\Database\DbPdo;
use HisInOneProxy\Log\Log;
use HisInOneProxy\Soap\Interactions\DataCache;
use HisInOneProxy\System\Utils;
use PDO;
use PDOStatement;
use React\Stream\Util;

/**
 * Class SimpleQueueInterface
 * @package HisInOneProxy\Queue
 */
class QueueDatabase extends QueueBase
{
    private bool $keep_elements;
    private ?DbPdo $db_connection = null;
    private ?PDO $pdo = null;
    protected Log $log;
    private array $valid_queues = [QueueConstants::SERVICE_QUEUE, QueueConstants::MAINTENANCE_QUEUE];
    private ?PDOStatement $prepare_insert_service_queue = null;
    private ?PDOStatement $prepare_pop_service_queue = null;
    private ?PDOStatement $prepare_collision_service_queue = null;
    private ?PDOStatement $prepare_insert_maintenance_queue = null;
    private ?PDOStatement $prepare_update_sent_service_queue = null;
    private ?PDOStatement $prepare_remove_entry_service_queue = null;
    private ?PDOStatement $prepare_select_service_queue = null;
    private ?PDOStatement $prepare_select_participants = null;
    private ?PDOStatement $prepare_insert_link_queue = null;
    private ?PDOStatement $prepare_pop_link_queue = null;
    private ?PDOStatement $prepare_update_sent_link_queue = null;

    function __construct(bool $force_push = false)
    {
            $this->log = DataCache::getInstance(false)->getLog();
            $this->setForceWriteMessageToQueue($force_push);
            $this->createDBConnection();
            $this->validateDBQueueStructure();
            $this->prepareStatements();
    }

    /**
     * @throws Exception
     */
    private function createDBConnection() {
        $this->keep_elements = GlobalSettings::getInstance()->isKeepElementInQueue();
        $host = GlobalSettings::getInstance()->getDatabaseHost();
        $name = GlobalSettings::getInstance()->getDatabaseDbname();
        $user = GlobalSettings::getInstance()->getDatabaseUser();
        $pass = GlobalSettings::getInstance()->getDatabasePass();
        $file = GlobalSettings::getInstance()->getDatabaseSqlite();
        try{
            $this->db_connection = new DbPdo($host, $name, $user, $pass, null, $file);
            $this->pdo = $this->db_connection->getPdo();
        } catch (Exception $e) {
            $msg = sprintf('Could not initialize database, error message: "%s"', $e->getMessage());
            Utils::LogToShellAndExit($msg);
            $this->log->critical($msg);
        }
    }

    private function validateDBQueueStructure(): void
    {
        $service_queue_found = $this->db_connection->tableExists(QueueConstants::SERVICE_QUEUE);
        $maintenance_queue_found = $this->db_connection->tableExists(QueueConstants::MAINTENANCE_QUEUE);
        if (!$service_queue_found || !$maintenance_queue_found) {
           Utils::LogToShellAndExit('Queue tables not found. Please ensure to run the DBUpdate.php script!');
        }
    }
    private function prepareStatements()
    {
        if ($this->prepare_insert_service_queue === null) {
            $sql = 'INSERT INTO ' .
                QueueConstants::SERVICE_QUEUE .
                ' (data, func, receiver, unix_time, checksum, lecture_id) VALUES (?,?,?,?,?,?)';
            $this->prepare_insert_service_queue = $this->pdo->prepare($sql);
        }

        if ($this->prepare_pop_service_queue === null) {
            $sql = 'SELECT * FROM ' . QueueConstants::SERVICE_QUEUE . ' WHERE sent IS NULL ORDER BY service_id LIMIT 1';
            $this->prepare_pop_service_queue = $this->pdo->prepare($sql);
        }

        if ($this->prepare_select_participants === null) {
            $sql = 'SELECT * FROM ' . QueueConstants::PARTICIPANTS;
            $this->prepare_select_participants = $this->pdo->prepare($sql);
        }

        if ($this->prepare_select_service_queue === null) {
            $sql = 'SELECT * FROM ' . QueueConstants::SERVICE_QUEUE . '  WHERE service_id=:id';
            $this->prepare_select_service_queue = $this->pdo->prepare($sql);
        }

        if ($this->prepare_collision_service_queue === null) {
            $sql = 'SELECT service_id, checksum, lecture_id FROM ' .
                QueueConstants::SERVICE_QUEUE .
                ' WHERE checksum=:checksum AND lecture_id=:lectureId LIMIT 1';
            $this->prepare_collision_service_queue = $this->pdo->prepare($sql);
        }

        if ($this->prepare_update_sent_service_queue === null) {
            $sql = 'UPDATE ' . QueueConstants::SERVICE_QUEUE . ' SET sent=:sent WHERE service_id=:id';
            $this->prepare_update_sent_service_queue = $this->pdo->prepare($sql);
        }

        if ($this->prepare_remove_entry_service_queue === null) {
            $sql = 'DELETE FROM ' . QueueConstants::SERVICE_QUEUE . ' WHERE service_id=:id';
            $this->prepare_remove_entry_service_queue = $this->pdo->prepare($sql);
        }

        if ($this->prepare_insert_maintenance_queue === null) {
            $sql = 'INSERT INTO ' . QueueConstants::MAINTENANCE_QUEUE . ' (data, func, receiver, unix_time) VALUES (?,?,?,?)';
            $this->prepare_insert_maintenance_queue = $this->pdo->prepare($sql);
        }

        if ($this->prepare_insert_link_queue === null) {
            $sql = 'INSERT INTO ' . QueueConstants::LINK_QUEUE . ' (unit_id, term_type, term_year, description, link, ecs_course_url) VALUES (?,?,?,?,?,?)';
            $this->prepare_insert_link_queue = $this->pdo->prepare($sql);
        }

        if ($this->prepare_pop_link_queue === null) {
            $sql = 'SELECT * FROM ' . QueueConstants::LINK_QUEUE . ' WHERE sent IS NULL ORDER BY link_id LIMIT 1';
            $this->prepare_pop_link_queue = $this->pdo->prepare($sql);
        }

        if ($this->prepare_update_sent_link_queue === null) {
            $sql = 'UPDATE ' . QueueConstants::LINK_QUEUE . ' SET sent=:sent WHERE link_id=:id';
            $this->prepare_update_sent_link_queue = $this->pdo->prepare($sql);
        }
    }

    public function pop(string $queue_name, ?int $count = 0): array
    {
        $data = [];
        if($this->queueExists($queue_name) && $queue_name === QueueConstants::SERVICE_QUEUE) {
            $this->prepare_pop_service_queue->execute();
            while ($row = $this->prepare_pop_service_queue->fetch(PDO::FETCH_ASSOC)) {
                $data[] = [
                            'service_id' => $row['service_id'],
                            'data' => $row['data'],
                            'cmd' => $row['func'],
                            'receiver' => $row['receiver'],
                            'unix_time' => $row['unix_time'],
                            'checksum' => $row['checksum'],
                            'sent' => $row['sent'],
                            'lecture_id' => $row['lecture_id']
                ];
            }
        }
        return $data;
    }

    public function getParticipants(): array
    {
        $participants = [];
        $this->prepare_select_participants->execute();
        while ($row = $this->prepare_select_participants->fetch(PDO::FETCH_ASSOC)) {
            $participants[] = [
                'pid' => $row['pid'],
                'mid' => $row['mid'],
                'name' => $row['name'],
                'description' => $row['description'],
                'dns' => $row['dns'] ? : '' ,
                'email' => $row['email'],
                'org' => [
                    'name' => $row['org_name'],
                    'abbr' => $row['org_abbr']
                    ]
            ];
        }
        return $participants;
    }

    public function select(int $service_id)
    {
        $args = [
            'id' => $service_id,
        ];
        $data = [];

        $this->prepare_select_service_queue->execute($args);
        while ($row = $this->prepare_select_service_queue->fetch(PDO::FETCH_ASSOC)) {
            $data = [
                        'service_id' => $row['service_id'],
                        'data' => $row['data'],
                        'cmd' => $row['func'],
                        'receiver' => $row['receiver'],
                        'unix_time' => $row['unix_time'],
                        'checksum' => $row['checksum'],
                        'sent' => $row['sent'],
                        'lecture_id' => $row['lecture_id']
            ];
            if($row['data'] !== null) {
                $data = json_decode($row['data']);
            }
        }
        return $data;
    }

    public function getSize(string $queue_name): int
    {
        if ($this->queueExists($queue_name)) {
            $query = 'SELECT count(*) as c FROM ' . $queue_name . ' WHERE sent IS NULL ';
            return $this->pdo->query($query)->fetchColumn();
        }
        $this->log->warning(sprintf('Given queue "%s" does not exists', $queue_name));

        return 0;
    }

    protected function isQueueNameValid(string $queue_name): bool
    {
        if (in_array($queue_name, $this->valid_queues)) {
            return true;
        }
        return false;
    }

    public function queueExists(string $queue_name): bool
    {
        if ($this->isQueueNameValid($queue_name)) {
            if ($this->db_connection->tableExists($queue_name)) {
                return true;
            }
        }
        return false;
    }

    public function cleanUpStaleJobs(): void
    {
        //Todo: implement function
    }

    public function push(string $queue_name, string $data, string $function = '', string $receiver = '', int $unix_time = 0): void
    {
        if ($queue_name === QueueConstants::SERVICE_QUEUE) {
            $this->pushInServiceQueue($data, $function, $receiver, $unix_time);

        } elseif ($queue_name === QueueConstants::MAINTENANCE_QUEUE) {
            $this->pushInMaintenanceQueue($data, $function, $receiver, $unix_time);
        } else {
            $this->log->critical(sprintf('Something seems not to be right with the database queue, found unknown queue "%s" as queue name.', $queue_name));
        }
    }

    protected function pushInServiceQueue(string $data, string $function = '', string $receiver = '', int $unix_time = 0): void
    {
        $checksum = sha1($data);
        $raw = json_decode($data);
        $lectureId = 0;
        $write_message_in_queue = true;

        if(isset($raw->lectureID)){
            $lectureId = (int) $raw->lectureID;
        }

        if ($unix_time === 0) {
            $unix_time = time();
        }
        if($lectureId > 0 && !$this->isForceWriteMessageToQueue()) {
            $select_data = [
                'checksum' => $checksum,
                'lectureId' => $lectureId
            ];

            $this->prepare_collision_service_queue->execute($select_data);
            while ($row =  $this->prepare_collision_service_queue->fetch(PDO::FETCH_ASSOC)) {
                $write_message_in_queue = false;
                $log_message = 'Collision found for checksum %s for lectureId %s is already stored with service id %s, ignoring message.';
                $this->log->info(sprintf($log_message,
                    $checksum,
                    $lectureId,
                    $row['service_id']
                ));
                DataCache::getInstance()->incrementFoundCollisions();
            }
        } else {
            if ($lectureId === 0) {
                $this->log->warning('Collision check is ignored, since lectureId is "0".');
            } elseif ($this->isForceWriteMessageToQueue()) {
                $this->log->info('Collision check is ignored, since "force write to queue" was activated.');
            }
        }

        if($lectureId > 0) {
            if($write_message_in_queue || $this->isForceWriteMessageToQueue()) {
                $data = json_encode($raw);
                $receiver_split = explode(',', $receiver);
                if(is_array($receiver_split) && count($receiver_split) > 0) {
                    foreach($receiver_split as $receiver) {
                        $this->prepare_insert_service_queue->execute([$data, $function, $receiver, $unix_time, $checksum, $lectureId]);
                        $this->log->debug(sprintf('Data from lecture (%s), was written to database.', $lectureId));
                    }
                } else {
                    $this->prepare_insert_service_queue->execute([$data, $function, $receiver, $unix_time, $checksum, $lectureId]);
                    $this->log->debug(sprintf('Data from lecture (%s), was written to database.', $lectureId));
                }

            }
        } else {
            $this->log->warning('LectureId was not set for entry, ignoring it.');
        }
    }

    protected function pushInMaintenanceQueue(string $data, string $function = '', string $receiver = '', int $unix_time = 0): void
    {
        $this->prepare_insert_maintenance_queue->execute([$data, $function, $receiver, $unix_time]);
    }

    public function removeMessage(string $queue_name, string $id): void
    {
        if ($this->queueExists($queue_name) && $queue_name === QueueConstants::SERVICE_QUEUE) {
            $this->updateSentField($id);
            if (!$this->keep_elements) {
                $this->removeEntryFromServiceQueue($id);
            }
        }
    }

    public function updateSentField(string $id, bool $reset_sent_state = false): void
    {
        $unix_time = time();

        if ($reset_sent_state) {
            $unix_time = null;
        }

        $data = [
            'sent' => $unix_time,
            'id' => $id,
        ];

        $this->prepare_update_sent_service_queue->execute($data);
        $this->log->debug(sprintf('Acknowledged entry %s from queue %s, removing it.', $id, QueueConstants::SERVICE_QUEUE));
    }

    private function removeEntryFromServiceQueue(string $id): void
    {
        $data = [
            'id' => $id
        ];

        $this->prepare_remove_entry_service_queue->execute($data);
        $this->log->debug(sprintf('Removed entry %s from queue %s.', $id, QueueConstants::SERVICE_QUEUE));
    }

    public function reAddMessageToQueue(string $queue_name, string $id): void
    {
        if ($this->queueExists($queue_name) && $queue_name === QueueConstants::SERVICE_QUEUE) {
            $this->updateSentField($id, true);
        }
    }

    /**
     * @return list<array{
     *     id: string,
     *     checksum: string,
     *     lectureID: string
     *     }>
     */
    public function listLectureIds(): array
    {
        $query = 'SELECT service_id, checksum, lecture_id
            FROM ' . QueueConstants::SERVICE_QUEUE;

        $data = [];
        while ($row = $this->pdo->query($query)->fetch()) {
            $data[] = [
                'id' => $row['service_id'],
                'checksum' => $row['checksum'],
                'lectureID' => $row['lecture_id']
            ];
        }
        return $data;
    }

    public function popLink() : array {
        $data = [];
        $this->prepare_pop_link_queue->execute();
        while ($row = $this->prepare_pop_link_queue->fetch(PDO::FETCH_ASSOC)) {
            $data[] = $row;
        }

        return $data;
    }

    public function insertLink($unit_id, $term_type, $term_year, $description, $link, $ecs_course_url, $logging) {
        $this->prepare_insert_link_queue->execute([$unit_id, $term_type, $term_year, $description, $link, $ecs_course_url]);
        $this->log->info(sprintf('Link for unit (%s), was written to database.', $unit_id));
    }

    public function markSentLink(int $link_id, int $unit_id = 0) {
        $unix_time = time();

        $data = [
            'sent' => $unix_time,
            'link_id' => $link_id,
        ];

        $this->prepare_update_sent_link_queue->execute($data);
        $this->log->debug(sprintf('Acknowledged entry %s from queue %s, removing it.', $link_id, QueueConstants::LINK_QUEUE));
    }

}
