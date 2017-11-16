<?php
require_once './libs/composer/vendor/autoload.php';

use  HisInOneProxy\DataModel;

/**
 * Class PlanElementPreferencePartTest
 */
class PlanElementPreferencePartTest extends PHPUnit\Framework\TestCase
{

	/**
	 * @var DataModel\PlanElementPreferencePart $instance
	 */
	protected $instance;

	protected function setUp()
	{
		$this->instance = new DataModel\PlanElementPreferencePart();
	}

	public function test_instantiateObject_shouldReturnInstance()
	{
		$this->assertInstanceOf('HisInOneProxy\DataModel\PlanElementPreferencePart', $this->instance);
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

	public function test_getBelongsToPlanElementPreferenceId_shouldBelongsToPlanElementPreferenceId()
	{
		$this->instance->setBelongsToPlanElementPreferenceId(132343242);
		$this->assertEquals(132343242, $this->instance->getBelongsToPlanElementPreferenceId());
	}

	/**
	 * @expectedException HisInOneProxy\Exceptions\InvalidPreferredInstructor
	 */
	public function test_appendPreferredInstructors_shouldThrowInvalidPreferredInstructor()
	{
		$this->instance->appendPreferredInstructors(new DataModel\Allocation());
	}

	public function test_getPreferredInstructors_shouldReturnOrgUnits()
	{
		$this->instance->appendPreferredInstructors(new DataModel\PreferredInstructor());
		$this->instance->appendPreferredInstructors(new DataModel\PreferredInstructor());
		$this->instance->appendPreferredInstructors(new DataModel\PreferredInstructor());
		$this->assertEquals(3, count($this->instance->getPreferredInstructors()));
	}

	/**
	 * @expectedException HisInOneProxy\Exceptions\InvalidRoom
	 */
	public function test_appendPreferredRooms_shouldThrowInvalidRoomArgumentException()
	{
		$this->instance->appendPreferredRooms(new DataModel\Allocation());
	}

	public function test_getPreferredRooms_shouldReturnPreferredRooms()
	{
		$this->instance->appendPreferredRooms(new DataModel\Room());
		$this->instance->appendPreferredRooms(new DataModel\Room());
		$this->assertEquals(2, count($this->instance->getPreferredRooms()));
	}
}