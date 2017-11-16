<?php
require_once './libs/composer/vendor/autoload.php';

use  HisInOneProxy\DataModel;

/**
 * Class HisSystemResponseTest
 */
class HisSystemResponseTest extends PHPUnit\Framework\TestCase
{

	public function test_instantiateObject_shouldReturnInstance()
	{
		$instance = new DataModel\HisSystemResponse();
		$this->assertInstanceOf('HisInOneProxy\DataModel\HisSystemResponse', $instance);
	}

	public function test_getObjectType_shouldReturnOrder()
	{
		$instance = new DataModel\HisSystemResponse();
		$instance->setObjectType('crs');
		$this->assertEquals('crs', $instance->getObjectType());
	}

	public function test_getObjectId_shouldReturnObjectId()
	{
		$instance = new DataModel\HisSystemResponse();
		$instance->setObjectId(44);
		$this->assertEquals(44, $instance->getObjectId());
	}

	public function test_getEventType_shouldReturnObjectId()
	{
		$instance = new DataModel\HisSystemResponse();
		$instance->setEventType('create');
		$this->assertEquals('create', $instance->getEventType());
	}

	public function test_getEventType2_shouldReturnObjectId()
	{
		$instance = new DataModel\HisSystemResponse();
		$instance->setEventType('cancel');
		$this->assertEquals(null, $instance->getEventType());
	}
}