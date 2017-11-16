<?php
require_once './libs/composer/vendor/autoload.php';

use  HisInOneProxy\DataModel;

/**
 * Class ElearningCourseMappingTest
 */
class ElearningCourseMappingTest extends PHPUnit\Framework\TestCase
{
	/**
	 * @var DataModel\ElearningCourseMapping $instance
	 */
	protected $instance;

	protected function setUp()
	{
		$this->instance = new DataModel\ElearningCourseMapping();
	}

	public function test_instantiateObject_shouldReturnInstance()
	{
		$this->assertInstanceOf('HisInOneProxy\DataModel\ElearningCourseMapping', $this->instance);
	}

	public function test_getUnitId_shouldReturnOrder()
	{
		$this->instance->setUnitId(1);
		$this->assertEquals(1, $this->instance->getUnitId());
	}

	public function test_getTermTypeValueId_shouldReturnOrder()
	{
		$this->instance->setTermTypeValueId(2);
		$this->assertEquals(2, $this->instance->getTermTypeValueId());
	}

	public function test_getCourseMappingTypeId_shouldReturnOrder()
	{
		$this->instance->setCourseMappingTypeId(3);
		$this->assertEquals(3, $this->instance->getCourseMappingTypeId());
	}

	public function test_getELearningSystemId_shouldReturnOrder()
	{
		$this->instance->setELearningSystemId(4);
		$this->assertEquals(4, $this->instance->getELearningSystemId());
	}

	public function test_getYear_shouldReturnOrder()
	{
		$this->instance->setYear(1000);
		$this->assertEquals(1000, $this->instance->getYear());
	}
}