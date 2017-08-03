<?php
require_once './libs/composer/vendor/autoload.php';

use  HisInOneProxy\DataModel;

class ChildRelationContainerTest extends PHPUnit\Framework\TestCase
{

	/**
	 * @var DataModel\Container\ChildRelationContainer
	 */
	protected $instance;

	protected function setUp()
	{
		$this->instance = new DataModel\Container\ChildRelationContainer();
	}

	public function test_instantiateObject_shouldReturnInstance()
	{
		$this->assertInstanceOf('HisInOneProxy\DataModel\Container\ChildRelationContainer', $this->instance);
	}

	public function test_getChildRelationContainer_shouldReturngetChildRelationContainer()
	{
		$child = new \HisInOneProxy\DataModel\ChildRelation();
		$child->setChildId(2);
		$this->instance->appendChildRelation($child);
		$this->assertEquals(1, count($this->instance->getChildRelationContainer()));
		$child = new \HisInOneProxy\DataModel\ChildRelation();
		$child->setChildId(4);
		$this->instance->appendChildRelation($child);
		$this->assertEquals(2, count($this->instance->getChildRelationContainer()));
	}

	/**
	 * @expectedException \InvalidArgumentException
	 */
	public function test_appendWorkStatus_shouldThrowInvalidArgumentException()
	{
		$this->instance->appendChildRelation('Workload');
	}

	public function test_replaceChildInContainer_shouldReturnReplaceRelation()
	{
		$child = new \HisInOneProxy\DataModel\ChildRelation();
		$child->setChildId(2);
		$child->setParentId(25);
		$this->instance->appendChildRelation($child);
		$this->assertEquals(25, $this->instance->getChildRelationContainer()[2]->getParentId());
		$child = new \HisInOneProxy\DataModel\ChildRelation();
		$child->setChildId(2);
		$child->setParentId(21);
		$this->instance->replaceChildInContainer(2, $child);
		$this->assertEquals(21, $this->instance->getChildRelationContainer()[2]->getParentId());
	}
}