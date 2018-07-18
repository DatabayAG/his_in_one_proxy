<?php

namespace HisInOneProxy\Config;

require_once __DIR__ . '/../Log/LogConfig.php';

use HisInOneProxy\DataModel\Endpoint;
use HisInOneProxy\DataModel\HisToEcsCourseIdMapping;
use HisInOneProxy\DataModel\HisToEcsIdMapping;
use HisInOneProxy\System\Utils;
use Noodlehaus\Config;

/**
 * Class GlobalSettings
 * @package HisInOneProxy\Config
 */
class GlobalSettings
{
	use LogConfig;

	private $default_config_name = 'config.json';

	/**
	 * @var self
	 */
	private static $instance;

	/**
	 * @var string
	 */
	protected $his_user_name;

	/**
	 * @var string
	 */
	protected $his_password;

	/**
	 * @var string
	 */
	protected $his_server_url;

	/**
	 * @var string
	 */
	protected $his_register_listener;

	/**
	 * @var string
	 */
	protected $ecs_server_url;

	/**
	 * @var string
	 */
	protected $person_id_type;

	/**
	 * @var string
	 */
	protected $ecs_auth_id;

	/**
	 * @var string
	 */
	protected $ecs_password;

	/**
	 * @var array
	 */
	protected $his_to_ecs_system_id_mapping;

	/**
	 * @var array
	 */
	protected $his_to_ecs_system_course_id_mapping;

	/**
	 * @var string
	 */
	protected $validate_ssl;

	/**
	 * @var string
	 */
	protected $path_to_queue;

	/**
	 * @var int
	 */
	protected $queue_timer;

	/**
	 * @var Config
	 */
	protected $config;

	/**
	 * @var int
	 */
	protected $soap_caching = 0;

	/**
	 * @var string
	 */
	protected $path_to_log;

	/**
	 * @var bool
	 */
	protected $soap_debug = true;

	/**
	 * @var bool
	 */
	protected $keep_element_in_queue = false;

	/**
	 * @var Endpoint
	 */
	protected $end_point;

	/**
	 * @var bool
	 */
	protected $debug;

	/**
	 * @var boolean
	 */
	protected $phpunit_with_coverage;

	/**
	 * @var int
	 */
	protected $soap_calls_counter = 0;

	/**
	 * @var int
	 */
	protected $actual_term_id;

	/**
	 * @var int
	 */
	protected $actual_term_year;

	/**
	 * @var string
	 */
	protected $login_suffix;

	/**
	 * @var array
	 */
	protected $blocked_ids = array();

	/**
	 * @var array
	 */
	protected $text_config = array();

	/**
	 * @param $name
	 */
	protected function overWriteDefaultConfigFileName($name)
	{
		$this->default_config_name = $name;
	}

	/**
	 * @return string
	 */
	protected function getConfigFileName()
	{
		return $this->default_config_name;
	}

	/**
	 * GlobalSettings constructor.
	 */
	private function __construct()
	{
		$this->read();
	}

	protected function read()
	{
		if(file_exists($this->getConfigFileName()))
		{
			$json = file_get_contents($this->getConfigFileName());
			if(\json_decode($json) != null)
			{
				$this->config = new Config($this->getConfigFileName());
			}
			else
			{
				Utils::LogToShellAndExit(sprintf('No valid config found, content of file is not valid json structure. (%s)', \json_last_error_msg()));
			}
		}
		else
		{
			if(defined('PHPUNIT') && PHPUNIT)
			{
				$this->config = new Config('config.json.dist');
			}
			else
			{
				Utils::LogToShellAndExit('No valid config found, please create a valid config from the config.json.dist.');
			}
		}

		$this->setValues();
	}

	protected function setValues()
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

		$this->setHisRegisterListener($this->config->get('HIS.endpoint.register_listener'));
		$this->end_point = new Endpoint();
		$this->end_point->setEndPointUrl($this->config->get('HIS.endpoint.listener_url'));
		$this->end_point->setPort($this->config->get('HIS.endpoint.listener_port'));
		$this->end_point->setUserName($this->config->get('HIS.endpoint.username'));
		$this->end_point->setPassword($this->config->get('HIS.endpoint.password'));

		$this->setEcsServerUrl($this->config->get('ECS.url'));
		$this->setEcsAuthId($this->config->get('ECS.auth_id'));
		$this->setEcsPassword($this->config->get('ECS.password'));

		$this->setPathToQueue($this->config->get('path_to_queue'));
		$this->setQueueTimer($this->config->get('queue_timer'));
		$this->setPathToLog($this->config->get('path_to_log'));
		$this->setKeepElementInQueue($this->config->get('keep_elements_in_queue'));
		$this->setDebug($this->config->get('debug'));

		$this->his_to_ecs_system_id_mapping = new HisToEcsIdMapping($this->config->get('HIStoECSMapping'));
		$this->his_to_ecs_system_course_id_mapping = new HisToEcsCourseIdMapping($this->config->get('HIStoECSCourseMapping'));
		$this->setPhpunitWithCoverage($this->config->get('PHPUnit.coverage'));
	}

	/**
	 * @param string $ecs_server_url
	 */
	protected function setEcsServerUrl($ecs_server_url)
	{
		$this->ecs_server_url = Utils::ensureTrailingSlash($ecs_server_url);
	}

	/**
	 * Get singleton instance
	 * @return self
	 */
	public static function getInstance()
	{
		if(null !== self::$instance)
		{
			return self::$instance;
		}

		return (self::$instance = new self());
	}

	/**
	 * @param $json
	 * @throws \Noodlehaus\Exception\EmptyDirectoryException
	 */
	public function readCustomConfig($json)
	{
		$this->config = new Config($json);
		$this->setValues();
	}

	public function returnConfig()
	{
		$config = array(
			"HIS.username"                   => $this->getHisUserName(),
			"HIS.password"                   => $this->getHisPassword(),
			"HIS.url"                        => $this->getHisServerUrl(),
			"HIS.endpoint.register_listener" => $this->getHisRegisterListener(),
			"HIS.endpoint.listener_url"      => $this->end_point->getEndPointUrl(),
			"HIS.endpoint.listener_port"     => $this->end_point->getPort(),
			"HIS.endpoint.username"          => $this->end_point->getUserName(),
			"HIS.endpoint.password"          => $this->end_point->getPassword(),
			"HIS.person_id_type"             => $this->getPersonIdType(),
			"HIS.login_suffix"               => $this->getLoginSuffix(),
			"HIS.soap_debug"                 => $this->isSoapDebug(),
			"HIS.soap_caching"               => $this->isSoapCaching(),
			"HIS.ssl_validation"             => $this->getValidateSsl(),
			"HIS.actual_term_id"             => $this->getActualTermId(),
			"HIS.actual_term_year"           => $this->getActualTermYear(),
			"HIS.blocked_ids"                => $this->getBlockedIds(),
			"HIS.text"                       => $this->getTextConfig(),
			"ECS.auth_id"                    => $this->getEcsAuthId(),
			"ECS.password"                   => $this->getEcsPassword(),
			"ECS.url"                        => $this->getEcsServerUrl(),
			"path_to_queue"                  => $this->getPathToQueue(),
			"queue_timer"                    => $this->getQueueTimer(),
			"path_to_log"                    => $this->getPathToLog(),
			"keep_elements_in_queue"         => $this->isKeepElementInQueue(),
			"debug"                          => $this->isDebug(),
			"PHPUnit.coverage"               => $this->isPhpunitWithCoverage()
		);

		$config = json_encode($config);
		return $config;
	}

	/**
	 * @return string
	 */
	public function getHisUserName()
	{
		return $this->his_user_name;
	}

	/**
	 * @param string $his_user_name
	 */
	protected function setHisUserName($his_user_name)
	{
		$this->his_user_name = $his_user_name;
	}

	/**
	 * @return string
	 */
	public function getHisPassword()
	{
		return $this->his_password;
	}

	/**
	 * @param string $his_password
	 */
	protected function setHisPassword($his_password)
	{
		$this->his_password = $his_password;
	}

	/**
	 * @return string
	 */
	public function getHisServerUrl()
	{
		return $this->his_server_url;
	}

	/**
	 * @param $server_url
	 */
	protected function setHisServerUrl($server_url)
	{
		$this->his_server_url = Utils::ensureTrailingSlash($server_url);
	}

	/**
	 * @return string
	 */
	public function getHisRegisterListener()
	{
		if($this->his_register_listener === 'true' || $this->his_register_listener === true)
		{
			return true;
		}
		return false;
	}

	/**
	 * @param $his_start_listener
	 */
	protected function setHisRegisterListener($his_start_listener)
	{
		$this->his_register_listener = $his_start_listener;
	}

	/**
	 * @return string
	 */
	public function getEcsAuthId()
	{
		return $this->ecs_auth_id;
	}

	/**
	 * @param string $ecs_auth_id
	 */
	protected function setEcsAuthId($ecs_auth_id)
	{
		$this->ecs_auth_id = $ecs_auth_id;
	}

	/**
	 * @return string
	 */
	public function getEcsPassword()
	{
		return $this->ecs_password;
	}

	/**
	 * @param string $ecs_password
	 */
	public function setEcsPassword($ecs_password)
	{
		$this->ecs_password = $ecs_password;
	}

	/**
	 * @return string
	 */
	public function getEcsServerUrl()
	{
		return $this->ecs_server_url;
	}

	/**
	 * @return string
	 */
	public function getValidateSsl()
	{
		return $this->validate_ssl;
	}

	/**
	 * @param string $validate_ssl
	 */
	public function setValidateSsl($validate_ssl)
	{
		$this->validate_ssl = $validate_ssl;
	}

	/**
	 * @return string
	 */
	public function getPathToQueue()
	{
		return $this->path_to_queue;
	}

	/**
	 * @param string $path_to_queue
	 */
	protected function setPathToQueue($path_to_queue)
	{
		$this->path_to_queue = Utils::ensureTrailingSlash($path_to_queue);
	}

	/**
	 * @return int
	 */
	public function getQueueTimer()
	{
		return $this->queue_timer;
	}

	/**
	 * @param int $queue_timer
	 */
	protected function setQueueTimer($queue_timer)
	{
		$this->queue_timer = $queue_timer;
	}

	/**
	 * @return int
	 */
	public function isSoapCaching()
	{
		if($this->soap_caching === '1' || $this->soap_caching === 1)
		{
			return 1;
		}
		return 0;
	}

	/**
	 * @param int $soap_caching
	 */
	protected function setSoapCaching($soap_caching)
	{
		$this->soap_caching = $soap_caching;
	}

	/**
	 * @return bool
	 */
	public function isSoapDebug()
	{
		if($this->soap_debug === 'true' || $this->soap_debug === true)
		{
			return true;
		}
		return false;
	}

	/**
	 * @param bool $soap_debug
	 */
	protected function setSoapDebug($soap_debug)
	{
		$this->soap_debug = $soap_debug;
	}

	/**
	 * @return string
	 */
	public function getPathToLog()
	{
		return $this->path_to_log;
	}

	/**
	 * @param string $path_to_log
	 */
	public function setPathToLog($path_to_log)
	{
		$this->path_to_log = $path_to_log;
	}

	/**
	 * @return bool
	 */
	public function isKeepElementInQueue()
	{
		if($this->keep_element_in_queue === 'true' || $this->keep_element_in_queue === true)
		{
			return true;
		}
		return false;
	}

	/**
	 * @param bool $keep_element_in_queue
	 */
	protected function setKeepElementInQueue($keep_element_in_queue)
	{
		$this->keep_element_in_queue = $keep_element_in_queue;
	}

	/**
	 * @return Endpoint
	 */
	public function getEndPoint()
	{
		return $this->end_point;
	}

	/**
	 * @return bool
	 */
	public function isDebug()
	{
		if($this->debug === 'true' || $this->debug === true)
		{
			return true;
		}
		return false;
	}

	/**
	 * @param bool $debug
	 */
	public function setDebug($debug)
	{
		$this->debug = $debug;
	}

	/**
	 * @return bool
	 */
	public function isPhpunitWithCoverage()
	{
		if($this->phpunit_with_coverage === 'true' || $this->phpunit_with_coverage === true)
		{
			return true;
		}
		return false;
	}

	/**
	 * @param bool $phpunit_with_coverage
	 */
	public function setPhpunitWithCoverage($phpunit_with_coverage)
	{
		$this->phpunit_with_coverage = $phpunit_with_coverage;
	}

	public function incrementCallsCounter()
	{
		$this->soap_calls_counter++;
	}

	/**
	 * @return int
	 */
	public function getCallsCounter()
	{
		return $this->soap_calls_counter;
	}

	/**
	 * @return int
	 */
	public function getActualTermId()
	{
		return $this->actual_term_id;
	}

	/**
	 * @param int $actual_term_id
	 */
	public function setActualTermId($actual_term_id)
	{
		$this->actual_term_id = $actual_term_id;
	}

	/**
	 * @return int
	 */
	public function getActualTermYear()
	{
		return $this->actual_term_year;
	}

	/**
	 * @param int $actual_term_year
	 */
	public function setActualTermYear($actual_term_year)
	{
		$this->actual_term_year = $actual_term_year;
	}

	/**
	 * @return string
	 */
	public function getPersonIdType()
	{
		return $this->person_id_type;
	}

	/**
	 * @param string $person_id_type
	 */
	public function setPersonIdType($person_id_type)
	{
		$this->person_id_type = $person_id_type;
	}

	/**
	 * @return string
	 */
	public function getLoginSuffix()
	{
		return $this->login_suffix;
	}

	/**
	 * @param string $login_suffix
	 */
	public function setLoginSuffix($login_suffix)
	{
		$this->login_suffix = $login_suffix;
	}

	/**
	 * @return array
	 */
	public function getBlockedIds()
	{
		return $this->blocked_ids;
	}

	/**
	 * @param array $blocked_ids
	 */
	public function setBlockedIds($blocked_ids)
	{
		$this->blocked_ids = $blocked_ids;
	}

	/**
	 * @return array
	 */
	public function getHisToEcsSystemIdMapping()
	{
		return $this->his_to_ecs_system_id_mapping;
	}

	/**
	 * @param array $his_to_ecs_system_id_mapping
	 */
	public function setHisToEcsSystemIdMapping($his_to_ecs_system_id_mapping)
	{
		$this->his_to_ecs_system_id_mapping = $his_to_ecs_system_id_mapping;
	}

	/**
	 * @return array
	 */
	public function getHisToEcsSystemCourseIdMapping()
	{
		return $this->his_to_ecs_system_course_id_mapping;
	}

	/**
	 * @param array $his_to_ecs_system_course_id_mapping
	 */
	public function setHisToEcsSystemCourseIdMapping($his_to_ecs_system_course_id_mapping)
	{
		$this->his_to_ecs_system_course_id_mapping = $his_to_ecs_system_course_id_mapping;
	}

	/**
	 * @return array
	 */
	public function getTextConfig()
	{
		return $this->text_config;
	}

	/**
	 * @param array $text_config
	 */
	public function setTextConfig( $text_config)
	{
		$this->text_config = $text_config;
	}
}
