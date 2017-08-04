<?php
include_once './libs/composer/vendor/autoload.php';
require_once './src/Config/GlobalSettings.php';
use  HisInOneProxy\Config;

require_once 'test/TestCaseExtension.php';

class GlobalSettingsTest extends TestCaseExtension
{

	/**
	 * @var Config\GlobalSettings
	 */
	protected $instance;
	
	protected $orig_server_url;

	protected function setUp()
	{
		$this->instance = Config\GlobalSettings::getInstance();
		$this->orig_server_url = $this->instance->getHisServerUrl();
	}

	protected function tearDown()
	{
		TestCaseExtension::callMethod(
			$this->instance,
			'setHisServerUrl',
			array($this->orig_server_url)
		);
	}

	/**
	 * @param $json
	 */
	protected function writeConfigToFile($json)
	{
		file_put_contents($json, '{
					"HIS" : {
						"username"           : "user",
						"password"           : "pass",
						"url"                : "http://his_url",
						"soap_debug"         : "false",
						"endpoint"           : {
							"register_listener"  : "false",
							"listener_url"       : "http://my_his_listener",
							"listener_port"      : "8080",
							"username"           : "user",
							"password"           : "pass"
						}
					},
					"ECS" : {
						"auth_id"            : "user2",
						"url"                : "http://super_ecs_server_url",
						"ssl_validation"     : "false"
					},
					"path_to_queue"          : "/tmp/my_path_to_queue",
					"path_to_log"          : "/tmp/phpunit.log",
					"queue_timer"            : "60"
				}');
	}

	public function test_instantiateObject_shouldReturnInstance()
	{
		$this->assertInstanceOf('HisInOneProxy\Config\GlobalSettings', $this->instance);
	}

	public function test_getLogPath_shouldReturnLogPath()
	{
		$this->instance->setLogPath('/tmp/my_log.log');
		$this->assertEquals('/tmp/my_log.log', $this->instance->getLogPath());
	}

	public function test_getLogLevel_shouldReturnLogPath()
	{
		$this->instance->setLogLevel(200);
		$this->assertEquals(200, $this->instance->getLogLevel());
	}

	public function test_getHisServerUrl_shouldReturnHisServerUrl()
	{
		TestCaseExtension::callMethod(
			$this->instance,
			'setHisServerUrl',
			array('https://my_not_secure_server')
		);

		$this->assertEquals('https://my_not_secure_server/', $this->instance->getHisServerUrl());
	}

	public function test_overWriteDefaultConfigFileName_shouldReturnOverwriteConfigName()
	{
		TestCaseExtension::callMethod(
			$this->instance,
			'overWriteDefaultConfigFileName',
			array('my_tmp_phpunit_config.json')
		);

		$con = TestCaseExtension::callMethod(
			$this->instance,
			'getConfigFileName',
			array()
		);

		$this->assertEquals('my_tmp_phpunit_config.json', $con);
	}

	public function test_readValues_shouldReturnReadValues()
	{
		TestCaseExtension::callMethod(
			$this->instance,
			'overWriteDefaultConfigFileName',
			array('my_tmp_phpunit_config.json')
		);

		$this->writeConfigToFile('my_tmp_phpunit_config.json');
		TestCaseExtension::callMethod(
			$this->instance,
			'read',
			array()
		);

		$this->assertEquals('http://his_url/', $this->instance->getHisServerUrl());
		unlink('my_tmp_phpunit_config.json');
	}

	public function test_Save_shouldReturnSave()
	{
		TestCaseExtension::callMethod(
			$this->instance,
			'overWriteDefaultConfigFileName',
			array('my_tmp_phpunit_config.json')
		);

		TestCaseExtension::callMethod(
			$this->instance,
			'save',
			array()
		);
		$this->assertEquals(true, file_exists('my_tmp_phpunit_config.json'));
		unlink('my_tmp_phpunit_config.json');
	}

	public function test_readValues2_shouldReturnReadValues()
	{
		TestCaseExtension::callMethod(
			$this->instance,
			'read',
			array()
		);

		$this->assertEquals('test/wsdl/', $this->instance->getHisServerUrl());
	}

	public function test_getHisUserName_shouldReturnHisUserName()
	{
		TestCaseExtension::callMethod(
			$this->instance,
			'setHisUserName',
			array('my_user_name')
		);

		$this->assertEquals('my_user_name', $this->instance->getHisUserName());
	}

	public function test_getHisPassword_shouldReturnLogPath()
	{
		TestCaseExtension::callMethod(
			$this->instance,
			'setHisPassword',
			array('my secure password')
		);

		$this->assertEquals('my secure password', $this->instance->getHisPassword());
	}

	public function test_getEcsServerUrl_shouldReturnEcsServerUrl()
	{
		TestCaseExtension::callMethod(
			$this->instance,
			'setEcsServerUrl',
			array('https://ecs_server/')
		);

		$this->assertEquals('https://ecs_server/', $this->instance->getEcsServerUrl());
	}

	public function test_getQueueTimer_shouldReturnQueueTimer()
	{
		TestCaseExtension::callMethod(
			$this->instance,
			'setQueueTimer',
			array(5)
		);

		$this->assertEquals(5, $this->instance->getQueueTimer());
	}

	public function test_getPathToQueue_shouldReturnPathToQueue()
	{
		TestCaseExtension::callMethod(
			$this->instance,
			'setPathToQueue',
			array('/tmp/queue')
		);

		$this->assertEquals('/tmp/queue/', $this->instance->getPathToQueue());
	}

	public function test_getHisRegisterListener_shouldReturnHisRegisterListener()
	{
		TestCaseExtension::callMethod(
			$this->instance,
			'setHisRegisterListener',
			array('0')
		);

		$this->assertEquals(false, $this->instance->getHisRegisterListener());
		TestCaseExtension::callMethod(
			$this->instance,
			'setHisRegisterListener',
			array('true')
		);

		$this->assertEquals(true, $this->instance->getHisRegisterListener());
	}

	public function test_isSoapDebug_shouldReturnSoapDebug()
	{
		TestCaseExtension::callMethod(
			$this->instance,
			'setSoapDebug',
			array('false')
		);

		$this->assertEquals(false, $this->instance->isSoapDebug());

		TestCaseExtension::callMethod(
			$this->instance,
			'setSoapDebug',
			array('true')
		);

		$this->assertEquals(true, $this->instance->isSoapDebug());
	}

	public function test_isKeepElementInQueue_shouldReturnKeepElementInQueue()
	{
		TestCaseExtension::callMethod(
			$this->instance,
			'setKeepElementInQueue',
			array('false')
		);

		$this->assertEquals(false, $this->instance->isKeepElementInQueue());

		TestCaseExtension::callMethod(
			$this->instance,
			'setKeepElementInQueue',
			array('true')
		);

		$this->assertEquals(true, $this->instance->isKeepElementInQueue());
	}

	public function test_isPhpunitWithCoverage_shouldReturnPhpunitWithCoverage()
	{
		TestCaseExtension::callMethod(
			$this->instance,
			'setPhpunitWithCoverage',
			array('false')
		);

		$this->assertEquals(false, $this->instance->isPhpunitWithCoverage());

		TestCaseExtension::callMethod(
			$this->instance,
			'setPhpunitWithCoverage',
			array('true')
		);

		$this->assertEquals(true, $this->instance->isPhpunitWithCoverage());
	}

	public function test_isDebug_shouldReturnDebug()
	{
		TestCaseExtension::callMethod(
			$this->instance,
			'setDebug',
			array('false')
		);

		$this->assertEquals(false, $this->instance->isDebug());

		TestCaseExtension::callMethod(
			$this->instance,
			'setDebug',
			array('true')
		);

		$this->assertEquals(true, $this->instance->isDebug());
	}

	public function test_getSoapCaching_shouldReturnSoapCaching()
	{
		TestCaseExtension::callMethod(
			$this->instance,
			'setSoapCaching',
			array(0)
		);
		$this->assertEquals(0, $this->instance->isSoapCaching());
		TestCaseExtension::callMethod(
			$this->instance,
			'setSoapCaching',
			array(1)
		);
		$this->assertEquals(1, $this->instance->isSoapCaching());
	}

	public function test_readCompleteConfigJson_shouldReadConfiguration()
	{
		$json = '/tmp/test_config.json';
		$this->writeConfigToFile($json);
		$this->instance->readCustomConfig($json);
		$this->assertEquals('user', $this->instance->getHisUserName());
		$this->assertEquals('pass', $this->instance->getHisPassword());
		$this->assertEquals('http://his_url/', $this->instance->getHisServerUrl());
		$this->assertEquals(false, $this->instance->getHisRegisterListener());
		$this->assertEquals('user2', $this->instance->getEcsAuthId());
		$this->assertEquals('http://super_ecs_server_url/', $this->instance->getEcsServerUrl());
		$this->assertEquals('false', $this->instance->getValidateSsl());
		$this->assertEquals('/tmp/my_path_to_queue/', $this->instance->getPathToQueue());
		$this->assertEquals('60', $this->instance->getQueueTimer());
		$endpoint = $this->instance->getEndPoint();
		$this->assertEquals('http://my_his_listener', $endpoint->getEndPointUrl());
		$this->assertEquals('8080', $endpoint->getPort());
		$this->assertEquals('http://my_his_listener:8080/', $endpoint->getUrlWithPort());
		$this->assertEquals('user', $endpoint->getUserName());
		$this->assertEquals('pass', $endpoint->getPassword());
		unlink($json);
	}
}