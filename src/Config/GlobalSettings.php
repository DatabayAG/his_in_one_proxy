<?php

namespace HisInOneProxy\Config;

require_once __DIR__ . '/../Log/LogConfig.php';

use HisInOneProxy\DataModel\Endpoint;
use HisInOneProxy\DataModel\HisToEcsCourseIdMapping;
use HisInOneProxy\DataModel\HisToEcsIdMapping;
use HisInOneProxy\Queue\QueueBase;
use HisInOneProxy\System\Utils;
use Noodlehaus\Config;
use Noodlehaus\Exception\EmptyDirectoryException;
use React\Stream\Util;
use function json_decode;
use function json_last_error_msg;

class GlobalSettings
{
    use LogConfig;

    private static ?GlobalSettings $instance = null;
    private string $default_config_name = 'config.json';
    protected string $his_user_name;
    protected string $his_password;
    protected string $his_server_url;
    protected bool $his_register_listener;
    protected string $ecs_server_url;
    protected string $person_id_type;
    protected string $ecs_auth_id;
    protected string $ecs_password;
    protected HisToEcsIdMapping $his_to_ecs_system_id_mapping;
    protected HisToEcsCourseIdMapping $his_to_ecs_system_course_id_mapping;
    protected string $validate_ssl;
    protected string $queue_type;
    protected string $path_to_queue;
    protected int $queue_timer;
    protected Config $config;
    protected int $soap_caching = 0;
    protected string $path_to_log;
    protected bool $soap_debug = true;
    protected bool $keep_element_in_queue = false;
    protected Endpoint $end_point;
    protected bool $debug;
    protected bool $phpunit_with_coverage;
    protected int $soap_calls_counter = 0;
    protected string $actual_term_id;
    protected int $actual_term_year;
    protected string $login_suffix;
    protected array $blocked_ids = [];
    protected array $text_config = [];
    protected string $database_dsn;
    protected bool $use_local_ecs = false;
    protected string $ecs_community_id = "0";
    protected array $workStatusIds = [];
    protected bool $create_links = false;
    protected int $process_links_count = 5;

    private function __construct()
    {
        $this->read();
    }

    protected function read()
    {
        if (file_exists($this->getConfigFileName())) {
            $json = file_get_contents($this->getConfigFileName());
            if (json_decode($json) != null) {
                $this->config = new Config($this->getConfigFileName());
            } else {
                Utils::LogToShellAndExit(sprintf('No valid config found, content of file is not valid json structure. (%s)', json_last_error_msg()));
            }
        } elseif(file_exists('../../../' . $this->getConfigFileName())) {
            $path_to_config = '../../../' . $this->getConfigFileName();
            $json = file_get_contents($path_to_config);
            if (json_decode($json) != null) {
                $this->config = new Config($path_to_config);
            } else {
                Utils::LogToShellAndExit(sprintf('No valid config found, content of file is not valid json structure. (%s)', json_last_error_msg()));
            }
        }
        else {
            if (defined('PHPUNIT') && PHPUNIT) {
                $this->config = new Config('config.json.dist');
            } else {
                Utils::LogToShellAndExit('No valid config found, please create a valid config from the config.json.dist.');
            }
        }

        $this->setValues();
        $this->validateSettings();
    }

    protected function getConfigFileName(): string
    {
        return $this->default_config_name;
    }

    protected function setValues(): void
    {
        $this->setHisServerUrl($this->config->get('HIS.url'));
        $this->setHisUserName($this->config->get('HIS.username'));
        $this->setHisPassword($this->config->get('HIS.password'));
        $this->setSoapDebug($this->config->get('HIS.soap_debug'));
        $this->setSoapCaching($this->config->get('HIS.soap_caching'));
        $this->setValidateSsl($this->config->get('HIS.ssl_validation'));
        $this->setActualTermId($this->config->get('HIS.actual_term_id'));
        $this->setActualTermYear($this->config->get('HIS.actual_term_year'));
        $this->setPersonIdType($this->config->get('HIS.person_id_type'));
        $this->setLoginSuffix($this->config->get('HIS.login_suffix'));
        $this->setBlockedIds($this->config->get('HIS.blocked_ids'));
        $this->setTextConfig($this->config->get('HIS.text'));
        $this->setWorkStatusIds($this->config->get('HIS.work_status_ids'));

        $this->setHisRegisterListener($this->config->get('HIS.endpoint.register_listener'));
        $this->end_point = new Endpoint();
        $this->end_point->setEndPointUrl($this->config->get('HIS.endpoint.listener_url'));
        $this->end_point->setPort($this->config->get('HIS.endpoint.listener_port'));
        $this->end_point->setUserName($this->config->get('HIS.endpoint.username'));
        $this->end_point->setPassword($this->config->get('HIS.endpoint.password'));

        $this->setUseLocalEcs($this->config->get('ECS.use_local_ecs'));
        $this->setEcsCommunityId($this->config->get('ECS.ecs_community_id'));
        $this->setEcsServerUrl($this->config->get('ECS.url'));
        $this->setEcsAuthId($this->config->get('ECS.auth_id'));
        $this->setEcsPassword($this->config->get('ECS.password'));

        $this->setDatabaseDsn($this->config->get('Database.dsn'));

        $this->setCreateLinks($this->config->get('create_links'));
        $this->setProcessLinksCount($this->config->get('process_links_count'));
        $this->setQueueType($this->config->get('queue_type'));
        $this->setPathToQueue($this->config->get('path_to_queue'));
        $this->setQueueTimer($this->config->get('queue_timer'));
        $this->setPathToLog($this->config->get('path_to_log'));
        $this->setKeepElementInQueue($this->config->get('keep_elements_in_queue'));
        $this->setDebug($this->config->get('debug'));

        $this->his_to_ecs_system_id_mapping = new HisToEcsIdMapping($this->config->get('HIStoECSMapping'));
        $this->his_to_ecs_system_course_id_mapping = new HisToEcsCourseIdMapping($this->config->get('HIStoECSCourseMapping'));
        $this->setPhpunitWithCoverage($this->config->get('PHPUnit.coverage'));
    }

    public static function getInstance(): self
    {
        if (null !== self::$instance) {
            return self::$instance;
        }

        return (self::$instance = new self());
    }

    protected function overWriteDefaultConfigFileName(string $name): void
    {
        $this->default_config_name = $name;
    }

    /**
     * @throws EmptyDirectoryException
     */
    public function readCustomConfig(string $json)
    {
        $this->config = new Config($json);
        $this->setValues();
    }

    public function returnConfig(): string
    {
        $config = array(
            "HIS.username" => $this->getHisUserName(),
            "HIS.password" => $this->getHisPassword(),
            "HIS.url" => $this->getHisServerUrl(),
            "HIS.endpoint.register_listener" => $this->getHisRegisterListener(),
            "HIS.endpoint.listener_url" => $this->end_point->getEndPointUrl(),
            "HIS.endpoint.listener_port" => $this->end_point->getPort(),
            "HIS.endpoint.username" => $this->end_point->getUserName(),
            "HIS.endpoint.password" => $this->end_point->getPassword(),
            "HIS.person_id_type" => $this->getPersonIdType(),
            "HIS.login_suffix" => $this->getLoginSuffix(),
            "HIS.soap_debug" => $this->isSoapDebug(),
            "HIS.soap_caching" => $this->isSoapCaching(),
            "HIS.ssl_validation" => $this->getValidateSsl(),
            "HIS.actual_term_id" => $this->getActualTermId(),
            "HIS.actual_term_year" => $this->getActualTermYear(),
            "HIS.blocked_ids" => $this->getBlockedIds(),
            "HIS.text" => $this->getTextConfig(),
            "HIS.work_status_ids" => $this->getWorkStatusIds(),
            "ECS.use_local_ecs" => $this->isUseLocalEcs(),
            "ECS.ecs_community_id" => $this->getEcsCommunityId(),
            "ECS.auth_id" => $this->getEcsAuthId(),
            "ECS.password" => $this->getEcsPassword(),
            "ECS.url" => $this->getEcsServerUrl(),
            "Database.dsn" => $this->getDatabaseDsn(),
            "create_links" => $this->isCreateLinks(),
            "process_links_count" => $this->getProcessLinksCount(),
            "queue_type" => $this->getQueueType(),
            "path_to_queue" => $this->getPathToQueue(),
            "queue_timer" => $this->getQueueTimer(),
            "path_to_log" => $this->getPathToLog(),
            "keep_elements_in_queue" => $this->isKeepElementInQueue(),
            "debug" => $this->isDebug(),
            "PHPUnit.coverage" => $this->isPhpunitWithCoverage()
        );

        $config = json_encode($config);
        return $config;
    }

    public function getHisUserName(): string
    {
        return $this->his_user_name;
    }

    protected function setHisUserName(string $his_user_name): void
    {
        $this->his_user_name = $his_user_name;
    }

    public function getHisPassword(): string
    {
        return $this->his_password;
    }

    protected function setHisPassword(string $his_password): void
    {
        $this->his_password = $his_password;
    }

    public function getHisServerUrl(): string
    {
        return $this->his_server_url;
    }

    protected function setHisServerUrl(string $server_url): void
    {
        $this->his_server_url = Utils::ensureTrailingSlash($server_url);
    }

    public function getHisRegisterListener(): bool
    {
        return $this->his_register_listener;
    }

    protected function setHisRegisterListener(string $his_register_listener): void
    {
        $this->his_register_listener = $this->getBoolFromConfigString($his_register_listener);
    }

    public function getPersonIdType(): string
    {
        return $this->person_id_type;
    }

    /**
     * @param string $person_id_type
     */
    public function setPersonIdType(string $person_id_type): void
    {
        $this->person_id_type = $person_id_type;
    }

    public function getLoginSuffix(): string
    {
        return $this->login_suffix;
    }

    public function setLoginSuffix(string $login_suffix): void
    {
        $this->login_suffix = $login_suffix;
    }

    public function isSoapDebug(): bool
    {
        return $this->soap_debug;
    }

    protected function setSoapDebug(string $soap_debug)
    {
        $this->soap_debug = $this->getBoolFromConfigString($soap_debug);
    }

    public function isSoapCaching(): int
    {
        return $this->soap_caching;
    }

    protected function setSoapCaching(string $soap_caching): void
    {
        $this->soap_caching = (int)$soap_caching;
    }

    public function getValidateSsl(): string
    {
        return $this->validate_ssl;
    }

    public function setValidateSsl(string $validate_ssl): void
    {
        $this->validate_ssl = $validate_ssl;
    }

    public function getActualTermId(): string
    {
        return $this->actual_term_id;
    }

    public function setActualTermId(string $actual_term_id): void
    {
        $this->actual_term_id = $actual_term_id;
    }

    public function getActualTermYear(): int
    {
        return $this->actual_term_year;
    }

    public function setActualTermYear(string $actual_term_year): void
    {
        $this->actual_term_year = $actual_term_year;
    }

    public function getBlockedIds(): array
    {
        return $this->blocked_ids;
    }

    public function setBlockedIds(array $blocked_ids): void
    {
        $this->blocked_ids = $blocked_ids;
    }

    public function getTextConfig(): array
    {
        return $this->text_config;
    }

    public function setTextConfig(array $text_config): void
    {
        $this->text_config = $text_config;
    }

    public function getEcsAuthId(): string
    {
        return $this->ecs_auth_id;
    }

    protected function setEcsAuthId(string $ecs_auth_id): void
    {
        $this->ecs_auth_id = $ecs_auth_id;
    }

    public function getEcsPassword(): string
    {
        return $this->ecs_password;
    }

    public function setEcsPassword(string $ecs_password): void
    {
        $this->ecs_password = $ecs_password;
    }

    public function getEcsServerUrl(): string
    {
        return $this->ecs_server_url;
    }

    protected function setEcsServerUrl(string $ecs_server_url): void
    {
        $this->ecs_server_url = Utils::ensureTrailingSlash($ecs_server_url);
    }

    public function getPathToQueue(): string
    {
        return $this->path_to_queue;
    }

    protected function setPathToQueue(string $path_to_queue): void
    {
        $this->path_to_queue = Utils::ensureTrailingSlash($path_to_queue);
    }

    public function getQueueTimer(): int
    {
        return $this->queue_timer;
    }

    protected function setQueueTimer(string $queue_timer): void
    {
        $this->queue_timer = $queue_timer;
    }

    public function getPathToLog(): string
    {
        return $this->path_to_log;
    }

    public function setPathToLog(string $path_to_log): void
    {
        $this->path_to_log = $path_to_log;
    }

    public function isKeepElementInQueue(): bool
    {
        return $this->keep_element_in_queue;
    }

    protected function setKeepElementInQueue(string $keep_element_in_queue)
    {
        $this->keep_element_in_queue = $this->getBoolFromConfigString($keep_element_in_queue);
    }

    public function isDebug(): bool
    {
        return $this->debug;
    }

    public function setDebug(string $debug): void
    {
        $this->debug = $this->getBoolFromConfigString($debug);
    }

    public function isPhpunitWithCoverage(): bool
    {
        return $this->phpunit_with_coverage;
    }

    public function setPhpunitWithCoverage(string $phpunit_with_coverage): void
    {
        $this->phpunit_with_coverage = $this->getBoolFromConfigString($phpunit_with_coverage);
    }

    public function getEndPoint(): Endpoint
    {
        return $this->end_point;
    }

    public function incrementCallsCounter(): void
    {
        $this->soap_calls_counter++;
    }

    public function getCallsCounter(): int
    {
        return $this->soap_calls_counter;
    }

    public function getHisToEcsSystemIdMapping(): HisToEcsIdMapping
    {
        return $this->his_to_ecs_system_id_mapping;
    }

    public function setHisToEcsSystemIdMapping(HisToEcsIdMapping $his_to_ecs_system_id_mapping): void
    {
        $this->his_to_ecs_system_id_mapping = $his_to_ecs_system_id_mapping;
    }

    public function getHisToEcsSystemCourseIdMapping(): HisToEcsCourseIdMapping
    {
        return $this->his_to_ecs_system_course_id_mapping;
    }

    public function setHisToEcsSystemCourseIdMapping(HisToEcsCourseIdMapping $his_to_ecs_system_course_id_mapping): void
    {
        $this->his_to_ecs_system_course_id_mapping = $his_to_ecs_system_course_id_mapping;
    }

    public function getQueueType(): string
    {
        return $this->queue_type;
    }

    public function setQueueType(string $queue_type): void
    {
        if ($queue_type !== '') {
            $queue_type = strtolower($queue_type);
            if (in_array($queue_type, [QueueBase::FILE_BASED, QueueBase::DB_BASED])) {
                $this->queue_type = $queue_type;
            } else {
                Utils::LogToShellAndExit('No known queue type selected, please check/update your config with the correct value.');
            }
        } else {
            Utils::LogToShellAndExit('No valid queue type found, please check/update your config with the correct value.');
        }
    }

    protected function getBoolFromConfigString(string $value): bool
    {
        return (bool) $value;
    }

    public function getDatabaseDsn(): string
    {
        return $this->database_dsn;
    }

    public function setDatabaseDsn(string $dsn): void
    {
        $this->database_dsn = $dsn;
    }

    public function isUseLocalEcs(): bool
    {
        return $this->use_local_ecs;
    }

    public function setUseLocalEcs(string $use_local_ecs): void
    {
        $this->use_local_ecs = $this->getBoolFromConfigString($use_local_ecs);
    }

    public function getEcsCommunityId(): string
    {
        return $this->ecs_community_id;
    }

    public function setEcsCommunityId(string $ecs_community_id): void
    {
        $this->ecs_community_id = $ecs_community_id;
    }

    public function getWorkStatusIds(): array
    {
        return $this->workStatusIds;
    }

    public function setWorkStatusIds(array $workStatusIds): void
    {
        $this->workStatusIds = $workStatusIds;
    }

    private function validateSettings()
    {
        if($this->isUseLocalEcs() && $this->getQueueType() === 'file_based') {
            Utils::LogToShellAndExit('The usage of the local ecs implementation needs a "db_based" queue type, you have selected "file_base", this will not work.');
        }
    }

    public function isCreateLinks(): bool
    {
        return $this->create_links;
    }

    public function setCreateLinks(bool $create_links): void
    {
        $this->create_links = $create_links;
    }

    public function getProcessLinksCount(): int
    {
        return $this->process_links_count;
    }

    public function setProcessLinksCount(int $process_links_count): void
    {
        $this->process_links_count = $process_links_count;
    }
}
