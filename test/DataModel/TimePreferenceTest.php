<?php
require_once './libs/composer/vendor/autoload.php';

use  HisInOneProxy\DataModel;

/**
 * Class TimePreferenceTest
 */
class TimePreferenceTest extends PHPUnit\Framework\TestCase
{

	/**
	 * @var DataModel\TimePreference $instance
	 */
	protected $instance;

	protected function setUp()
	{
		$this->instance = new DataModel\TimePreference();
	}

	public function test_instantiateObject_shouldReturnInstance()
	{
		$this->assertInstanceOf('HisInOneProxy\DataModel\TimePreference', $this->instance);
	}

	public function test_getId_shouldReturnId()
	{
		$this->instance->setId(2272);
		$this->assertEquals(2272, $this->instance->getId());
	}

	public function test_getObjGuid_shouldReturnObjGuid()
	{
		$this->instance->setObjGuid(271);
		$this->assertEquals(271, $this->instance->getObjGuid());
	}

	public function test_getLockVersion_shouldReturnLockVersion()
	{
		$this->instance->setLockVersion(12);
		$this->assertEquals(12, $this->instance->getLockVersion());
	}

	public function test_getOwnerPersonPreferenceId_shouldReturnOwnerPersonPreferenceId()
	{
		$this->instance->setOwnerPersonPreferenceId(1232372);
		$this->assertEquals(1232372, $this->instance->getOwnerPersonPreferenceId());
	}

	public function test_getOwnerPlanElementPreferenceId_shouldReturnOwnerPlanElementPreferenceId()
	{
		$this->instance->setOwnerPlanElementPreferenceId(11);
		$this->assertEquals(11, $this->instance->getOwnerPlanElementPreferenceId());
	}

	public function test_getOwnerRoomClassId_shouldReturnOwnerRoomClassId()
	{
		$this->instance->setOwnerRoomClassId(999);
		$this->assertEquals(999, $this->instance->getOwnerRoomClassId());
	}

	public function test_getTermTypeValueId_shouldReturnTermTypeValueId()
	{
		$this->instance->setTermTypeValueId(9991);
		$this->assertEquals(9991, $this->instance->getTermTypeValueId());
	}

	public function test_getWeightingFactor_shouldReturnWeightingFactor()
	{
		$this->instance->setWeightingFactor(9992);
		$this->assertEquals(9992, $this->instance->getWeightingFactor());
	}

	public function test_getYear_shouldReturnYear()
	{
		$this->instance->setYear(2099);
		$this->assertEquals(2099, $this->instance->getYear());
	}

	/**
	 * @expectedException HisInOneProxy\Exceptions\InvalidTimeSlot
	 */
	public function test_setTimeSlot_shouldThrowInvalidArgumentException()
	{
		$this->instance->appendTimeSlot('Workload');
	}

	public function test_setTimeSlot_shouldReturnTimeSlotContainer()
	{
		$this->instance->appendTimeSlot(new DataModel\TimeSlot());
		$this->assertEquals(1, count($this->instance->getTimeSlotContainer()));
	}
}