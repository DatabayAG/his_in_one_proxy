<?php
require_once './libs/composer/vendor/autoload.php';

use  HisInOneProxy\DataModel;

/**
 * Class ElearningPlatformContainerTest
 */
class ElearningPlatformContainerTest extends PHPUnit\Framework\TestCase
{
	/**
	 * @var DataModel\Container\ElearningPlatformContainer
	 */
	protected $instance;

	protected function setUp()
	{
		$this->instance = new DataModel\Container\ElearningPlatformContainer();
	}

	public function test_instantiateObject_shouldReturnInstance()
	{
		$this->assertInstanceOf('HisInOneProxy\DataModel\Container\ElearningPlatformContainer', $this->instance);
	}

	public function test_appendExamRelation_shouldReturnCourseMappingTypeContainer()
	{
		$this->instance->appendElearningPlatform(new \HisInOneProxy\DataModel\ElearningPlatform());
		$this->assertEquals(1, count($this->instance->getElearningPlatformContainer()));
	}

	/**
	 * @expectedException \InvalidArgumentException
	 */
	public function test_appendEventDate_shouldThrowInvalidArgumentException()
	{
		$this->instance->appendElearningPlatform('Workload');
	}

	public function test_translateIdToDefaultText_shouldReturnText()
	{
		$type = new \HisInOneProxy\DataModel\ElearningPlatform();
		$type->setId(22);
		$type->setDefaultText('my_name');
		$this->instance->appendElearningPlatform($type);
		$this->assertEquals('my_name', $this->instance->translateIdToDefaultText(22));
		$this->assertEquals(null, $this->instance->translateIdToDefaultText(12));
	}
}