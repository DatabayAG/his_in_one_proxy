<?php
require_once './libs/composer/vendor/autoload.php';

use  HisInOneProxy\DataModel;

/**
 * Class PlannedDateTest
 */
class PlannedDateTest extends PHPUnit\Framework\TestCase
{
	/**
	 * @var DataModel\PlannedDate $instance
	 */
	protected $instance;

	protected function setUp() {
		$this->instance =  new DataModel\PlannedDate();
	}

	public function test_instantiateObject_shouldReturnInstance()
	{
		$this->assertInstanceOf('HisInOneProxy\DataModel\PlannedDate', $this->instance);
	}

	public function test_getId_shouldReturnId()
	{
		$this->instance->setId(47);
		$this->assertEquals(47, $this->instance->getId());
	}

	public function test_getObjGuid_shouldReturnObjGuid()
	{
		$this->instance->setObjGuid(81);
		$this->assertEquals(81, $this->instance->getObjGuid());
	}

	public function test_getLockVersion_shouldReturnLockVersion()
	{
		$this->instance->setLockVersion(344);
		$this->assertEquals(344, $this->instance->getLockVersion());
	}

	public function test_getAcademicTimeSpecificationId_shouldReturnAcademicTimeSpecificationId()
	{
		$this->instance->setAcademicTimeSpecificationId(447);
		$this->assertEquals(447, $this->instance->getAcademicTimeSpecificationId());
	}

	public function test_getEndDate_shouldReturnEndDate()
	{
		$this->instance->setEndDate('2017-12-25');
		$this->assertEquals('2017-12-25', $this->instance->getEndDate());
	}

	public function test_getEndTime_shouldReturnEndTime()
	{
		$this->instance->setEndTime('13:43');
		$this->assertEquals('13:43', $this->instance->getEndTime());
	}

	public function test_getExpectedAttendeesCount_shouldReturnExpectedAttendeesCount()
	{
		$this->instance->setExpectedAttendeesCount(500);
		$this->assertEquals(500, $this->instance->getExpectedAttendeesCount());
	}

	public function test_getNotice_shouldReturnNotice()
	{
		$this->instance->setNotice('My special notice');
		$this->assertEquals('My special notice', $this->instance->getNotice());
	}

	public function test_getPlanElementId_shouldReturnPlanElementId()
	{
		$this->instance->setPlanElementId(2000);
		$this->assertEquals(2000, $this->instance->getPlanElementId());
	}

	public function test_getRhythmId_shouldReturnRhythmId()
	{
		$this->instance->setRhythmId(7);
		$this->assertEquals(7, $this->instance->getRhythmId());
	}

	public function test_getRoomId_shouldReturnRoomId()
	{
		$this->instance->setRoomId(123);
		$this->assertEquals(123, $this->instance->getRoomId());
	}

	public function test_getStartDate_shouldReturnStartDate()
	{
		$this->instance->setStartDate('2017-04-15');
		$this->assertEquals('2017-04-15', $this->instance->getStartDate());
	}

	public function test_getStartTime_shouldReturnStartTime()
	{
		$this->instance->setStartTime('11:43');
		$this->assertEquals('11:43', $this->instance->getStartTime());
	}

	public function test_getWeekdayId_shouldReturnWeekdayId()
	{
		$this->instance->setWeekdayId(2);
		$this->assertEquals(2, $this->instance->getWeekdayId());
	}

	/**
	 * @expectedException HisInOneProxy\Exceptions\InvalidIndividualDate
	 */
	public function test_appendIndividualDate_shouldThrowInvalidArgumentException()
	{
		$this->instance->appendIndividualDate('Workload');
	}

	public function test_appendIndividualDate_shouldReturnIndividualDates()
	{
		$this->instance->appendIndividualDate(new DataModel\IndividualDate());
		$this->instance->appendIndividualDate(new DataModel\IndividualDate());
		$this->instance->appendIndividualDate(new DataModel\IndividualDate());
		$this->instance->appendIndividualDate(new DataModel\IndividualDate());
		$this->assertEquals(4, count($this->instance->getIndividualDateContainer()));
	}

	/**
	 * @expectedException HisInOneProxy\Exceptions\InvalidInstructor
	 */
	public function test_appendInstructor_shouldThrowInvalidArgumentException()
	{
		$this->instance->appendInstructor('Workload');
	}

	public function test_getInstructor_shouldReturnInstructors()
	{
		$this->instance->appendInstructor(new DataModel\Instructor());
		$this->instance->appendInstructor(new DataModel\Instructor());
		$this->instance->appendInstructor(new DataModel\Instructor());
		$this->assertEquals(3, count($this->instance->getInstructorContainer()));
	}

	/**
	 * @expectedException HisInOneProxy\Exceptions\InvalidPlanElementCancellation
	 */
	public function test_appendPlanElementCancellation_shouldThrowInvalidArgumentException()
	{
		$this->instance->appendPlanElementCancellation('Workload');
	}

	public function test_getPlanElementCancellation_shouldReturnInstructors()
	{
		$this->instance->appendPlanElementCancellation(new DataModel\PlanElementCancellation());
		$this->instance->appendPlanElementCancellation(new DataModel\PlanElementCancellation());
		$this->instance->appendPlanElementCancellation(new DataModel\PlanElementCancellation());
		$this->instance->appendPlanElementCancellation(new DataModel\PlanElementCancellation());
		$this->instance->appendPlanElementCancellation(new DataModel\PlanElementCancellation());
		$this->assertEquals(5, count($this->instance->getPlanElementCancellationContainer()));
	}

	/**
	 * @expectedException HisInOneProxy\Exceptions\InvalidPlanElementChange
	 */
	public function test_appendPlanElementChange_shouldThrowInvalidArgumentException()
	{
		$this->instance->appendPlanElementChange('Workload');
	}

	public function test_getPlanElementChange_shouldReturnInstructors()
	{
		$this->instance->appendPlanElementChange(new DataModel\PlanElementChange());
		$this->instance->appendPlanElementChange(new DataModel\PlanElementChange());
		$this->instance->appendPlanElementChange(new DataModel\PlanElementChange());
		$this->instance->appendPlanElementChange(new DataModel\PlanElementChange());
		$this->instance->appendPlanElementChange(new DataModel\PlanElementChange());
		$this->instance->appendPlanElementChange(new DataModel\PlanElementChange());
		$this->assertEquals(6, count($this->instance->getPlanElementChangeContainer()));
	}
}