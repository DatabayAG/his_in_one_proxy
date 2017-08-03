<?php
require_once './libs/composer/vendor/autoload.php';

use  HisInOneProxy\DataModel;

class PreferredInstructorTest extends PHPUnit\Framework\TestCase
{

	/**
	 * @var DataModel\PreferredInstructor $instance
	 */
	protected $instance;

	protected function setUp()
	{
		$this->instance = new DataModel\PreferredInstructor();
	}

	public function test_instantiateObject_shouldReturnInstance()
	{
		$this->assertInstanceOf('HisInOneProxy\DataModel\PreferredInstructor', $this->instance);
	}

	public function test_getId_shouldReturnId()
	{
		$this->instance->setId(22);
		$this->assertEquals(22, $this->instance->getId());
	}

	public function test_getObjGuid_shouldReturnObjGuid()
	{
		$this->instance->setObjGuid(211);
		$this->assertEquals(211, $this->instance->getObjGuid());
	}

	public function test_getLockVersion_shouldReturnLockVersion()
	{
		$this->instance->setLockVersion(132);
		$this->assertEquals(132, $this->instance->getLockVersion());
	}

	public function test_getPreferredInstructorId_shouldReturnPreferredInstructorId()
	{
		$this->instance->setPreferredInstructorId(1432);
		$this->assertEquals(1432, $this->instance->getPreferredInstructorId());
	}

	public function test_getPreferredInstructorForPlanElementPartsId_shouldReturnPreferredInstructorForPlanElementPartsId()
	{
		$this->instance->setPreferredInstructorForPlanElementPartsId(1322222);
		$this->assertEquals(1322222, $this->instance->getPreferredInstructorForPlanElementPartsId());
	}

	public function test_getPriority_shouldReturnPriority()
	{
		$this->instance->setPriority(2);
		$this->assertEquals(2, $this->instance->getPriority());
	}

}