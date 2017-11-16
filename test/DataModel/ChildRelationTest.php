<?php
require_once './libs/composer/vendor/autoload.php';

use  HisInOneProxy\DataModel;

/**
 * Class ChildRelationTest
 */
class ChildRelationTest extends PHPUnit\Framework\TestCase
{

	/**
	 * @var DataModel\ChildRelation $instance
	 */
	protected $instance;

	protected function setUp()
	{
		$this->instance = new DataModel\ChildRelation();
	}

	public function test_instantiateObject_shouldReturnInstance()
	{
		$this->assertInstanceOf('HisInOneProxy\DataModel\ChildRelation', $this->instance);
	}

	public function test_getChildId_shouldReturnValue()
	{
		$this->instance->setChildId(52146);
		$this->assertEquals(52146, $this->instance->getChildId());
	}

	public function test_getParentId_shouldReturnValue()
	{
		$this->instance->setParentId(435436576);
		$this->assertEquals(435436576, $this->instance->getParentId());
	}
}