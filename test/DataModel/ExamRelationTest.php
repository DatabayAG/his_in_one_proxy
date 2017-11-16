<?php
require_once './libs/composer/vendor/autoload.php';

use  HisInOneProxy\DataModel;

/**
 * Class ExamRelationTest
 */
class ExamRelationTest extends PHPUnit\Framework\TestCase
{

	public function test_instantiateObject_shouldReturnInstance()
	{
		$instance = new DataModel\ExamRelation();
		$this->assertInstanceOf('HisInOneProxy\DataModel\ExamRelation', $instance);
	}

	public function test_getUnitId_shouldReturnUnitId()
	{
		$instance = new DataModel\ExamRelation();
		$instance->setUnitId(1);
		$this->assertEquals(1, $instance->getUnitId());
	}

	public function test_getPersonId_shouldReturnPersonId()
	{
		$instance = new DataModel\ExamRelation();
		$instance->setPersonId(11111);
		$this->assertEquals(11111, $instance->getPersonId());
	}

	public function test_getPlanElementId_shouldReturnPlanElementId()
	{
		$instance = new DataModel\ExamRelation();
		$instance->setPlanElementId(55);
		$this->assertEquals(55, $instance->getPlanElementId());
	}

	public function test_getCancellation_shouldReturnCancellation()
	{
		$instance = new DataModel\ExamRelation();
		$instance->setCancellation(true);
		$this->assertEquals(true, $instance->getCancellation());
	}

	public function test_getParentId_shouldReturnParentId()
	{
		$instance = new DataModel\ExamRelation();
		$instance->setWorkStatusId(77);
		$this->assertEquals(77, $instance->getWorkStatusId());
	}
}