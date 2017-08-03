<?php
require_once './libs/composer/vendor/autoload.php';

use  HisInOneProxy\DataModel;

class CourseMappingTypeContainerTest extends PHPUnit\Framework\TestCase
{
	
	protected $instance;

	protected function setUp()
	{
		$this->instance = new DataModel\Container\CourseMappingTypeContainer();
	}

	public function test_instantiateObject_shouldReturnInstance()
	{
		$this->assertInstanceOf('HisInOneProxy\DataModel\Container\CourseMappingTypeContainer', $this->instance);
	}

	public function test_appendExamRelation_shouldReturnCourseMappingTypeContainer()
	{
		$this->instance->appendCourseMappingType(new \HisInOneProxy\DataModel\CourseMappingType());
		$this->assertEquals(1, count($this->instance->getCourseMappingTypeContainer()));
	}

	/**
	 * @expectedException \InvalidArgumentException
	 */
	public function test_appendEventDate_shouldThrowInvalidArgumentException()
	{
		$this->instance->appendCourseMappingType('Workload');
	}

	public function test_translateIdToDefaultText_shouldReturnText()
	{
		$type = new \HisInOneProxy\DataModel\CourseMappingType();
		$type->setId(22);
		$type->setUniqueName('my_name');
		$this->instance->appendCourseMappingType($type);
		$this->assertEquals('my_name', $this->instance->translateIdToDefaultText(22));
		$this->assertEquals(null, $this->instance->translateIdToDefaultText(12));
	}
}