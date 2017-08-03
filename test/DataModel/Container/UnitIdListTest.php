<?php
require_once './libs/composer/vendor/autoload.php';

use  HisInOneProxy\DataModel;

class UnitIdListTest extends PHPUnit\Framework\TestCase
{

	/**
	 * @var DataModel\Container\UnitIdList $instance
	 */
	protected $instance;

	protected function setUp()
	{
		$this->instance = new DataModel\Container\UnitIdList();
	}

	public function test_instantiateObject_shouldReturnInstance()
	{
		$this->assertInstanceOf('HisInOneProxy\DataModel\Container\UnitIdList', $this->instance);
	}

	public function test_append_shouldReturnId()
	{
		$this->assertEquals(0, $this->instance->getSizeOfContainer());
		$this->instance->appendUnitId(2);
		$this->assertEquals(1, $this->instance->getSizeOfContainer());
		$this->instance->appendUnitId(32);
		$this->assertEquals(2, $this->instance->getSizeOfContainer());
		$this->instance->appendUnitId(2);
		$this->assertEquals(2, $this->instance->getSizeOfContainer());
		$this->instance->appendUnitId(PHP_INT_MAX);
		$this->assertEquals(3, $this->instance->getSizeOfContainer());
	}

	public function test_generatorTest_shouldReturnInstance()
	{
		$values = array(2,1, 500050, 321423, 53454354);
		$this->instance->appendUnitId(2);
		$this->instance->appendUnitId(1);
		$this->instance->appendUnitId(500050);
		$this->instance->appendUnitId(321423);
		$this->instance->appendUnitId(53454354);
		$counter = 0 ;
		foreach($this->instance->getUnitId() as $unit_id)
		{
			$this->assertEquals($values[$counter], $unit_id);
			$counter++;
		}

	}
}