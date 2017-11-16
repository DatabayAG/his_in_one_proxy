<?php
require_once './libs/composer/vendor/autoload.php';

use  HisInOneProxy\DataModel;

/**
 * Class PlanElementCancellationTest
 */
class PlanElementCancellationTest extends PHPUnit\Framework\TestCase
{
	/**
	 * @var DataModel\PlanElementCancellation $instance
	 */
	protected $instance;

	protected function setUp()
	{
		$this->instance = new DataModel\PlanElementCancellation();
	}

	public function test_instantiateObject_shouldReturnInstance()
	{
		$this->assertInstanceOf('HisInOneProxy\DataModel\PlanElementCancellation', $this->instance);
	}

	public function test_getId_shouldReturnId()
	{
		$this->instance->setId(23);
		$this->assertEquals(23, $this->instance->getId());
	}

	public function test_getObjGuid_shouldReturnObjGuid()
	{
		$this->instance->setObjGuid(24);
		$this->assertEquals(24, $this->instance->getObjGuid());
	}

	public function test_getLockVersion_shouldReturnLockVersion()
	{
		$this->instance->setLockVersion(111);
		$this->assertEquals(111, $this->instance->getLockVersion());
	}

	public function test_getCanceledDate_shouldReturnCanceledDate()
	{
		$this->instance->setCanceledDate('2017-03-21');
		$this->assertEquals('2017-03-21', $this->instance->getCanceledDate());
	}

	public function test_getLanguageId_shouldReturnLanguageId()
	{
		$this->instance->setLanguageId(12);
		$this->assertEquals(12, $this->instance->getLanguageId());
	}

	public function test_getPlannedDatesId_shouldReturnPlannedDatesId()
	{
		$this->instance->setPlannedDatesId(342);
		$this->assertEquals(342, $this->instance->getPlannedDatesId());
	}

	public function test_getRemark_shouldReturnRemark()
	{
		$this->instance->setRemark('My special remark.');
		$this->assertEquals('My special remark.', $this->instance->getRemark());
	}

}