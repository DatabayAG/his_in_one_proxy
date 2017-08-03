<?php
require_once './libs/composer/vendor/autoload.php';

use  HisInOneProxy\DataModel;

class PlanElementChangeTest extends PHPUnit\Framework\TestCase
{
	/**
	 * @var DataModel\PlanElementChange $instance
	 */
	protected $instance;

	protected function setUp()
	{
		$this->instance = new DataModel\PlanElementChange();
	}

	public function test_instantiateObject_shouldReturnInstance()
	{
		$this->assertInstanceOf('HisInOneProxy\DataModel\PlanElementChange', $this->instance);
	}

	public function test_getId_shouldReturnId()
	{
		$this->instance->setId(45);
		$this->assertEquals(45, $this->instance->getId());
	}

	public function test_getObjGuid_shouldReturnObjGuid()
	{
		$this->instance->setObjGuid(222);
		$this->assertEquals(222, $this->instance->getObjGuid());
	}

	public function test_getLockVersion_shouldReturnLockVersion()
	{
		$this->instance->setLockVersion(754);
		$this->assertEquals(754, $this->instance->getLockVersion());
	}

	public function test_getAcademicTimeSpecificationId_shouldReturnAcademicTimeSpecificationId()
	{
		$this->instance->setAcademicTimeSpecificationId(1233);
		$this->assertEquals(1233, $this->instance->getAcademicTimeSpecificationId());
	}

	public function test_getLanguageId_shouldReturnLanguageId()
	{
		$this->instance->setLanguageId(434);
		$this->assertEquals(434, $this->instance->getLanguageId());
	}

	public function test_getNewDate_shouldReturnNewDate()
	{
		$this->instance->setNewDate('2017-12-23');
		$this->assertEquals('2017-12-23', $this->instance->getNewDate());
	}

	public function test_getOldDate_shouldReturnOldDate()
	{
		$this->instance->setOldDate('2017-12-22');
		$this->assertEquals('2017-12-22', $this->instance->getOldDate());
	}

	public function test_getPlannedDatesId_shouldReturnPlannedDatesId()
	{
		$this->instance->setPlannedDatesId(767);
		$this->assertEquals(767, $this->instance->getPlannedDatesId());
	}

	public function test_getRemark_shouldReturnRemark()
	{
		$this->instance->setRemark('My remark.');
		$this->assertEquals('My remark.', $this->instance->getRemark());
	}

	public function test_getRoomId_shouldReturnRoomId()
	{
		$this->instance->setRoomId(999);
		$this->assertEquals(999, $this->instance->getRoomId());
	}

	public function test_getStartTime_shouldReturnStartTime()
	{
		$this->instance->setStartTime('15:00');
		$this->assertEquals('15:00', $this->instance->getStartTime());
	}

	public function test_getEndTime_shouldReturnEndTime()
	{
		$this->instance->setEndTime('18:00');
		$this->assertEquals('18:00', $this->instance->getEndTime());
	}

	/**
	 * @expectedException HisInOneProxy\Exceptions\InvalidInstructor
	 */
	public function test_appendInstructor_shouldThrowInvalidArgumentException()
	{
		$this->instance->appendInstructor('Workload');
	}

	public function test_appendInstructor_shouldReturnInstructors()
	{
		$this->instance->appendInstructor(new \HisInOneProxy\DataModel\Instructor());
		$this->instance->appendInstructor(new \HisInOneProxy\DataModel\Instructor());
		$this->instance->appendInstructor(new \HisInOneProxy\DataModel\Instructor());
		$this->assertEquals(3, count($this->instance->getInstructorContainer()));
	}

}