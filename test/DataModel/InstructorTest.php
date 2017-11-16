<?php
require_once './libs/composer/vendor/autoload.php';

use  HisInOneProxy\DataModel;

/**
 * Class InstructorTest
 */
class InstructorTest extends PHPUnit\Framework\TestCase
{
	/**
	 * @var DataModel\Instructor $instance
	 */
	protected $instance;

	protected function setUp()
	{
		$this->instance = new DataModel\Instructor();
	}

	public function test_instantiateObject_shouldReturnInstance()
	{
		$this->assertInstanceOf('HisInOneProxy\DataModel\Instructor', $this->instance);
	}

	public function test_getObjGuid_shouldReturnObjGuid()
	{
		$this->instance->setObjGuid(23123213);
		$this->assertEquals(23123213, $this->instance->getObjGuid());
	}

	public function test_getId_shouldReturnId()
	{
		$this->instance->setId(222);
		$this->assertEquals(222, $this->instance->getId());
	}

	public function test_getSortOrder_shouldReturnOrder()
	{
		$this->instance->setSortOrder(1);
		$this->assertEquals(1, $this->instance->getSortOrder());
	}

	public function test_getLockVersion_shouldLockVersion()
	{
		$this->instance->setLockVersion(12);
		$this->assertEquals(12, $this->instance->getLockVersion());
	}

	public function test_getExaminationSubareaId_shouldReturnExaminationSubareaId()
	{
		$this->instance->setExaminationSubareaId(13213);
		$this->assertEquals(13213, $this->instance->getExaminationSubareaId());
	}

	public function test_getInstructorTaskId_shouldReturnInstructorTaskId()
	{
		$this->instance->setInstructorTaskId(2132131);
		$this->assertEquals(2132131, $this->instance->getInstructorTaskId());
	}

	public function test_getPersonId_shouldReturnPersonId()
	{
		$this->instance->setPersonId(1234);
		$this->assertEquals(1234, $this->instance->getPersonId());
	}

	public function test_getPlanElementChangeId_shouldReturnPlanElementChangeId()
	{
		$this->instance->setPlanElementChangeId(12321433);
		$this->assertEquals(12321433, $this->instance->getPlanElementChangeId());
	}

	public function test_getPlannedDatesId_shouldReturnPlannedDatesId()
	{
		$this->instance->setPlannedDatesId(777);
		$this->assertEquals(777, $this->instance->getPlannedDatesId());
	}

	public function test_getTeachingLoadPercentage_shouldReturnTeachingLoadPercentage()
	{
		$this->instance->setTeachingLoadPercentage(12.3333);
		$this->assertEquals(12.3333, $this->instance->getTeachingLoadPercentage());
	}

	public function test_getWeight_shouldReturnWeight()
	{
		$this->instance->setWeight(2000);
		$this->assertEquals(2000, $this->instance->getWeight());
	}
}