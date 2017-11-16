<?php
require_once './libs/composer/vendor/autoload.php';

use  HisInOneProxy\DataModel;

/**
 * Class IndividualDateTest
 */
class IndividualDateTest extends PHPUnit\Framework\TestCase
{

	/**
	 * @var DataModel\IndividualDate $instance
	 */
	protected $instance;

	protected function setUp()
	{
		$this->instance = new DataModel\IndividualDate();
	}

	public function test_instantiateObject_shouldReturnInstance()
	{
		$this->assertInstanceOf('HisInOneProxy\DataModel\IndividualDate', $this->instance);
	}

	public function test_getId_shouldReturnId()
	{
		$this->instance->setId(1);
		$this->assertEquals(1, $this->instance->getId());
	}

	public function test_getObjGuid_shouldReturnObjGuid()
	{
		$this->instance->setObjGuid(11);
		$this->assertEquals(11, $this->instance->getObjGuid());
	}

	public function test_getLockVersion_shouldReturnLockVersion()
	{
		$this->instance->setLockVersion(112);
		$this->assertEquals(112, $this->instance->getLockVersion());
	}

	public function test_getExecutionDate_shouldReturnExecutionDate()
	{
		$this->instance->setExecutionDate('2017-12-31');
		$this->assertEquals('2017-12-31', $this->instance->getExecutionDate());
	}

	public function test_getPlannedDatesId_shouldReturnPlannedDatesId()
	{
		$this->instance->setPlannedDatesId(777);
		$this->assertEquals(777, $this->instance->getPlannedDatesId());
	}

	public function test_getStartTime_shouldReturnStartTime()
	{
		$this->instance->setStartTime('11:00');
		$this->assertEquals('11:00', $this->instance->getStartTime());
	}

	public function test_getEndTime_shouldReturnEndTime()
	{
		$this->instance->setEndTime('14:00');
		$this->assertEquals('14:00', $this->instance->getEndTime());
	}

	public function test_getWeekDay_shouldReturnWeekDay()
	{
		$this->instance->setWeekDay(5);
		$this->assertEquals(5, $this->instance->getWeekDay());
	}

	public function test_getRoomId_shouldReturnRoomId()
	{
		$this->instance->setRoomId(2453);
		$this->assertEquals(2453, $this->instance->getRoomId());
	}
}