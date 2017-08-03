<?php
require_once './libs/composer/vendor/autoload.php';

use  HisInOneProxy\DataModel;

class PlanningPreferenceTest extends PHPUnit\Framework\TestCase
{

	/**
	 * @var DataModel\PlanningPreference $instance
	 */
	protected $instance;

	protected function setUp()
	{
		$this->instance = new DataModel\PlanningPreference();
	}

	public function test_instantiateObject_shouldReturnInstance()
	{
		$this->assertInstanceOf('HisInOneProxy\DataModel\PlanningPreference', $this->instance);
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
		$this->instance->setLockVersion(12);
		$this->assertEquals(12, $this->instance->getLockVersion());
	}

	public function test_getComment_shouldReturnComment()
	{
		$this->instance->setComment('My little Comment');
		$this->assertEquals('My little Comment', $this->instance->getComment());
	}

	public function test_getFixedTime_shouldReturnFixedTime()
	{
		$this->instance->setFixedTime(60);
		$this->assertEquals(60, $this->instance->getFixedTime());
	}

	public function test_getOwnerPlanElementId_shouldReturnOwnerPlanElementId()
	{
		$this->instance->setOwnerPlanElementId(2);
		$this->assertEquals(2, $this->instance->getOwnerPlanElementId());
	}

	public function test_getPartsInARow_shouldReturnPartsInARow()
	{
		$this->instance->setPartsInARow(4);
		$this->assertEquals(4, $this->instance->getPartsInARow());
	}

	public function test_getTermTypeValueId_shouldReturnTermTypeValueId()
	{
		$this->instance->setTermTypeValueId(5);
		$this->assertEquals(5, $this->instance->getTermTypeValueId());
	}

	public function test_getYear_shouldReturnYear()
	{
		$this->instance->setYear(1999);
		$this->assertEquals(1999, $this->instance->getYear());
	}

	/**
	 * @expectedException HisInOneProxy\Exceptions\InvalidPlanElementPreferencePart
	 */
	public function test_appendPlanElementPreferencePart_shouldThrowInvalidArgumentException()
	{
		$this->instance->appendPlanElementPreferencePart('Workload');
	}

	public function test_getPersonPlanElementContainer_shouldReturnPersons()
	{
		$this->instance->appendPlanElementPreferencePart(new DataModel\PlanElementPreferencePart());
		$this->instance->appendPlanElementPreferencePart(new DataModel\PlanElementPreferencePart());
		$this->instance->appendPlanElementPreferencePart(new DataModel\PlanElementPreferencePart());
		$this->assertEquals(3, count($this->instance->getPlanElementPreferenceParts()));
	}

	/**
	 * @expectedException HisInOneProxy\Exceptions\InvalidTimePreference
	 */
	public function test_appendTimePreference_shouldThrowInvalidArgumentException()
	{
		$this->instance->appendTimePreference('Workload');
	}

	public function test_getPersonPlanElementContainer_shouldReturnTimePreferences()
	{
		$this->instance->appendTimePreference(new DataModel\TimePreference());
		$this->instance->appendTimePreference(new DataModel\TimePreference());
		$this->instance->appendTimePreference(new DataModel\TimePreference());
		$this->instance->appendTimePreference(new DataModel\TimePreference());
		$this->assertEquals(4, count($this->instance->getTimePreferenceContainer()));
	}
}