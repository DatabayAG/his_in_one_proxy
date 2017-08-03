<?php
require_once './libs/composer/vendor/autoload.php';

use  HisInOneProxy\DataModel;

class TimeSlotTest extends PHPUnit\Framework\TestCase
{

	/**
	 * @var DataModel\TimeSlot $instance
	 */
	protected $instance;

	protected function setUp()
	{
		$this->instance = new DataModel\TimeSlot();
	}

	public function test_instantiateObject_shouldReturnInstance()
	{
		$this->assertInstanceOf('HisInOneProxy\DataModel\TimeSlot', $this->instance);
	}

	public function test_getId_shouldReturnId()
	{
		$this->instance->setId(22872);
		$this->assertEquals(22872, $this->instance->getId());
	}

	public function test_getObjGuid_shouldReturnObjGuid()
	{
		$this->instance->setObjGuid(2721);
		$this->assertEquals(2721, $this->instance->getObjGuid());
	}

	public function test_getLockVersion_shouldReturnLockVersion()
	{
		$this->instance->setLockVersion(122);
		$this->assertEquals(122, $this->instance->getLockVersion());
	}

	public function test_getStartTime_shouldReturnStartTime()
	{
		$this->instance->setStartTime('17:00');
		$this->assertEquals('17:00', $this->instance->getStartTime());
	}

	public function test_getEndTime_shouldReturnEndTime()
	{
		$this->instance->setEndTime('17:40');
		$this->assertEquals('17:40', $this->instance->getEndTime());
	}

	public function test_getWeekDay_shouldReturnWeekDay()
	{
		$this->instance->setWeekDay(3);
		$this->assertEquals(3, $this->instance->getWeekDay());
	}

}