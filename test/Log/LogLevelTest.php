<?php
include_once './libs/composer/vendor/autoload.php';

use  HisInOneProxy\Log;

/**
 * Class LogLevelTest
 */
class LogLevelTest extends PHPUnit\Framework\TestCase
{

	public function test_instantiateObject_shouldReturnInstance()
	{
		$instance = new Log\LogLevel();
		$this->assertInstanceOf('HisInOneProxy\Log\LogLevel', $instance);
	}

	public function test_getLogPath_shouldReturnLogPath()
	{
		$instance = new Log\LogLevel();
		$this->assertEquals(9, count($instance->getLevels()));
	}

}