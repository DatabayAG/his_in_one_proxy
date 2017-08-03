<?php
require_once './libs/composer/vendor/autoload.php';

use  HisInOneProxy\DataModel;

class ElearningPlatformTest extends PHPUnit\Framework\TestCase
{

	public function test_instantiateObject_shouldReturnInstance()
	{
		$instance = new DataModel\ElearningPlatform();
		$this->assertInstanceOf('HisInOneProxy\DataModel\ElearningPlatform', $instance);
	}

	public function test_getConnectionInfo_shouldReturnConnectionInfo()
	{
		$instance = new DataModel\ElearningPlatform();
		$instance->setConnectionInfo('Connection info');
		$this->assertEquals('Connection info', $instance->getConnectionInfo());
	}

	public function test_getHisKeyId_shouldReturnHisKeyId()
	{
		$instance = new DataModel\ElearningPlatform();
		$instance->setHisKeyId(11111);
		$this->assertEquals(11111, $instance->getHisKeyId());
	}
}