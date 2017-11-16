<?php
require_once './libs/composer/vendor/autoload.php';

use  HisInOneProxy\DataModel;

/**
 * Class ParallelGroupValuesContainerTest
 */
class ParallelGroupValuesContainerTest extends PHPUnit\Framework\TestCase
{
	/**
	 * @var DataModel\Container\ParallelGroupValuesContainer
	 */
	protected $instance;

	protected function setUp()
	{
		$this->instance = new DataModel\Container\ParallelGroupValuesContainer();
	}

	public function test_instantiateObject_shouldReturnInstance()
	{
		$this->assertInstanceOf('HisInOneProxy\DataModel\Container\ParallelGroupValuesContainer', $this->instance);
	}

	public function test_appendExamRelation_shouldReturnCourseMappingTypeContainer()
	{
		$this->instance->appendParallelGroupValue(new \HisInOneProxy\DataModel\ParallelGroupValue());
		$this->assertEquals(1, count($this->instance->getParallelGroupValueContainer()));
		$this->assertEquals(1, $this->instance->getSizeOfParallelGroupValueContainer());
	}

	/**
	 * @expectedException \InvalidArgumentException
	 */
	public function test_appendEventDate_shouldThrowInvalidArgumentException()
	{
		$this->instance->appendParallelGroupValue('Workload');
	}

	public function test_translateIdToDefaultText_shouldReturnText()
	{
		$type = new \HisInOneProxy\DataModel\ParallelGroupValue();
		$type->setId(22);
		$type->setDefaultText('my_name');
		$this->instance->appendParallelGroupValue($type);
		$this->assertEquals('my_name', $this->instance->getGroupValueById(22)->getDefaultText());
		$this->assertEquals(null, $this->instance->getGroupValueById(12));
	}
}