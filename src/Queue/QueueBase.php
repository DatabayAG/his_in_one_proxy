<?php

namespace HisInOneProxy\Queue;

use Exception;
use HisInOneProxy\Config\GlobalSettings;
use HisInOneProxy\Log\Log;
use HisInOneProxy\Soap\Interactions\DataCache;

class QueueBase implements QueueInterface
{
    const FILE_BASED = 'file_based';
    const DB_BASED = 'db_based';
    private static QueueBase $instance;
    private bool $force_write_message_to_queue = false;

    protected Log $log;
    protected ?QueueInterface $queue_type = null;

    public static function getInstance(): self
    {
        if (null !== self::$instance) {
            return self::$instance;
        }

        return (self::$instance = new self());
    }

    /**
     * @throws Exception
     */
    public function __construct(bool $force_push = false)
    {
        if(null === $this->queue_type) {
            $this->log = DataCache::getInstance()->getLog();
            $type = GlobalSettings::getInstance()->getQueueType();

            if (in_array($type, [self::FILE_BASED, self::DB_BASED])) {
                if ($type === self::FILE_BASED) {
                    $this->queue_type = new QueueFile();
                } elseif ($type === self::DB_BASED) {
                    $this->queue_type = new QueueDatabase($force_push);
                }
            }
        }

    }

    public function pop(string $queue_name): array
    {
        return $this->queue_type->pop($queue_name);
    }

    public function queueExists(string $queue_name): bool
    {
        return $this->queue_type->queueExists($queue_name);
    }

    public function getSize(string $queue_name): int
    {
        return $this->queue_type->getSize($queue_name);
    }

    public function cleanUpStaleJobs(): void
    {
        $this->queue_type->cleanUpStaleJobs();
    }

    public function push(string $queue_name, string $data, string $function = '', string $receiver = '', int $unix_time = 0): void
    {
        $this->queue_type->push($queue_name, $data, $function, $receiver, $unix_time);
    }

    public function removeMessage(string $queue_name, string $id): void
    {
        $this->queue_type->removeMessage($queue_name, $id);
    }

    public function reAddMessageToQueue(string $queue_name, string $id): void
    {
        $this->queue_type->reAddMessageToQueue($queue_name, $id);
    }

    public function getQueueType(): QueueInterface
    {
        return $this->queue_type;
    }

    public function setForceWriteMessageToQueue(bool $force_write_message_to_queue): void
    {
        $this->force_write_message_to_queue = $force_write_message_to_queue;
    }

    public function isForceWriteMessageToQueue(): bool
    {
        return $this->force_write_message_to_queue;
    }

}
