<?php
require_once './libs/composer/vendor/autoload.php';

use  HisInOneProxy\DataModel;

class AllocationTest extends PHPUnit\Framework\TestCase
{

	public function test_instantiateObject_shouldReturnInstance()
	{
		$instance = new DataModel\Allocation();
		$this->assertInstanceOf('HisInOneProxy\DataModel\Allocation', $instance);
	}

	public function test_getSortOrder_shouldReturnOrder()
	{
		$instance = new DataModel\Allocation();
		$instance->setSortOrder(1);
		$this->assertEquals(1, $instance->getSortOrder());
	}

	public function test_getParentId_shouldReturnParentId()
	{
		$instance = new DataModel\Allocation();
		$instance->setParentId(11111);
		$this->assertEquals(11111, $instance->getParentId());
	}
}