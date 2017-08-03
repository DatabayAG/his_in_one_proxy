<?php
require_once './libs/composer/vendor/autoload.php';

use  HisInOneProxy\DataModel;

class PersonPlanElementTest extends PHPUnit\Framework\TestCase
{

	/**
	 * @var DataModel\PersonPlanElement $instance
	 */
	protected $instance;

	protected function setUp()
	{
		$this->instance = new DataModel\PersonPlanElement();
	}

	public function test_instantiateObject_shouldReturnInstance()
	{
		$this->assertInstanceOf('HisInOneProxy\DataModel\PersonPlanElement', $this->instance);
	}

	public function test_getId_shouldReturnId()
	{
		$this->instance->setPersonId(222);
		$this->assertEquals(222, $this->instance->getPersonId());
	}

	public function test_getPersonId_shouldReturnPersonId()
	{
		$this->instance->setPersonId(14321);
		$this->assertEquals(14321, $this->instance->getPersonId());
	}

	public function test_getPlanElementId_shouldReturnPlanElementId()
	{
		$this->instance->setPlanElementId(13222224);
		$this->assertEquals(13222224, $this->instance->getPlanElementId());
	}

}