<?php
require_once './libs/composer/vendor/autoload.php';

use  HisInOneProxy\DataModel;

class WorkStatusContainerTest extends PHPUnit\Framework\TestCase
{

	/**
	 * @var DataModel\Container\WorkStatusContainer
	 */
	protected $instance;

	protected function setUp()
	{
		$this->instance = new DataModel\Container\WorkStatusContainer();
	}

	public function test_instantiateObject_shouldReturnInstance()
	{
		$this->assertInstanceOf('HisInOneProxy\DataModel\Container\WorkStatusContainer', $this->instance);
	}

	public function test_appendWorkStatus_shouldReturnCourseMappingTypeContainer()
	{
		$this->instance->appendWorkStatus(new \HisInOneProxy\DataModel\WorkStatus());
		$this->assertEquals(1, count($this->instance->getWorkStatusContainer()));
	}

	/**
	 * @expectedException \InvalidArgumentException
	 */
	public function test_appendWorkStatus_shouldThrowInvalidArgumentException()
	{
		$this->instance->appendWorkStatus('Workload');
	}

	public function test_translateIdToDefaultText_shouldReturnText()
	{
		$type = new \HisInOneProxy\DataModel\WorkStatus();
		$type->setId(22);
		$type->setDefaultText('my_name');
		$this->instance->appendWorkStatus($type);
		$this->assertEquals('my_name', $this->instance->translateIdToDefaultText(22));
		$this->assertEquals(null, $this->instance->translateIdToDefaultText(12));
	}
}