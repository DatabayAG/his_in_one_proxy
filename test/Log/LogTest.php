<?php
include_once './libs/composer/vendor/autoload.php';

use HisInOneProxy\Log;
use Monolog\Handler\StreamHandler;

/**
 * Class LogTest
 */
class LogTest extends PHPUnit\Framework\TestCase
{
	/**
	 * @var \HisInOneProxy\Log\Log
	 */
	protected $log;

	protected $collectedMessages = array();

	protected function setUp()
	{
		date_default_timezone_set('UTC');
		$log = new \Monolog\Logger('default');
		$log->pushHandler(new \Monolog\Handler\TestHandler());
		$this->log = new \HisInOneProxy\Log\Log('default', $log);

	}

	public function test_instantiateObject_shouldReturnInstance()
	{
		$this->assertInstanceOf('HisInOneProxy\Log\Log', $this->log);
	}

	public function test_Debug_shouldLogDebugMessage()
	{
		$this->log->debug('My debug message.');
		$msg = $this->log->getLogger()->popHandler()->getRecords();
		$this->assertEquals(count($msg), 1);
		$this->assertEquals($msg[0]['message'], 'My debug message.');
		$this->assertEquals($msg[0]['level_name'], 'DEBUG');
	}

	public function test_Info_shouldLogInfoMessage()
	{
		$this->log->info('My info message.');
		$msg = $this->log->getLogger()->popHandler()->getRecords();
		$this->assertEquals(count($msg), 1);
		$this->assertEquals($msg[0]['message'], 'My info message.');
		$this->assertEquals($msg[0]['level_name'], 'INFO');
	}

	public function test_Notice_shouldLogNoticeMessage()
	{
		$this->log->notice('My notice message.');
		$msg = $this->log->getLogger()->popHandler()->getRecords();
		$this->assertEquals(count($msg), 1);
		$this->assertEquals($msg[0]['message'], 'My notice message.');
		$this->assertEquals($msg[0]['level_name'], 'NOTICE');
	}

	public function test_Warning_shouldLogWarningMessage()
	{
		$this->log->warning('My warning message.');
		$msg = $this->log->getLogger()->popHandler()->getRecords();
		$this->assertEquals(count($msg), 1);
		$this->assertEquals($msg[0]['message'], 'My warning message.');
		$this->assertEquals($msg[0]['level_name'], 'WARNING');
	}

	public function test_Error_shouldLogErrorMessage()
	{
		$this->log->error('My error message.');
		$msg = $this->log->getLogger()->popHandler()->getRecords();
		$this->assertEquals(count($msg), 1);
		$this->assertEquals($msg[0]['message'], 'My error message.');
		$this->assertEquals($msg[0]['level_name'], 'ERROR');
	}

	public function test_Critical_shouldLogCriticalMessage()
	{
		$this->log->critical('My critical message.');
		$msg = $this->log->getLogger()->popHandler()->getRecords();
		$this->assertEquals(count($msg), 1);
		$this->assertEquals($msg[0]['message'], 'My critical message.');
		$this->assertEquals($msg[0]['level_name'], 'CRITICAL');
	}

	public function test_Alert_shouldLogAlertMessage()
	{
		$this->log->alert('My alert message.');
		$msg = $this->log->getLogger()->popHandler()->getRecords();
		$this->assertEquals(count($msg), 1);
		$this->assertEquals($msg[0]['message'], 'My alert message.');
		$this->assertEquals($msg[0]['level_name'], 'ALERT');
	}

	public function test_Emergency_shouldLogEmergencyMessage()
	{
		$this->log->emergency('My emergency message.');
		$msg = $this->log->getLogger()->popHandler()->getRecords();
		$this->assertEquals(count($msg), 1);
		$this->assertEquals($msg[0]['message'], 'My emergency message.');
		$this->assertEquals($msg[0]['level_name'], 'EMERGENCY');
	}

	public function test_isHandling_shouldReturnIsHandling()
	{
		$value = $this->log->isHandling(\Monolog\Logger::DEBUG);
		$this->assertTrue($value);
		$value = $this->log->isHandling('DEBUG');
		$this->assertFalse($value);
	}

	public function test_log_shouldWriteLog()
	{
		$this->log->log('My info message.', \Monolog\Logger::INFO);
		$msg = $this->log->getLogger()->popHandler()->getRecords();
		$this->assertEquals(count($msg), 1);
		$this->assertEquals($msg[0]['message'], 'My info message.');
		$this->assertEquals($msg[0]['level_name'], 'INFO');
	}

	public function test_dump_shouldWriteLog()
	{
		$this->log->dump(array(0 => 'A', 1 => 'B'), \Monolog\Logger::INFO);
		$msg = $this->log->getLogger()->popHandler()->getRecords();
		$this->assertEquals(count($msg), 1);
		$this->assertEquals($msg[0]['message'], 'Array
(
    [0] => A
    [1] => B
)
'
		);
		$this->assertEquals($msg[0]['level_name'], 'INFO');
	}

	public function test_constructor_initialisation()
	{
		$this->log = new \HisInOneProxy\Log\Log();
		$this->assertInstanceOf('HisInOneProxy\Log\Log', $this->log);
	}

}