<?php
require_once './libs/composer/vendor/autoload.php';

use  HisInOneProxy\DataModel;

class CourseCatalogElementIdListTest extends PHPUnit\Framework\TestCase
{

	/**
	 * @var DataModel\Container\CourseCatalogElementIdList $instance
	 */
	protected $instance;

	protected function setUp()
	{
		$this->instance = new DataModel\Container\CourseCatalogElementIdList();
	}

	public function test_instantiateObject_shouldReturnInstance()
	{
		$this->assertInstanceOf('HisInOneProxy\DataModel\Container\CourseCatalogElementIdList', $this->instance);
	}

	public function test_append_shouldReturnId()
	{
		$this->assertEquals(0, $this->instance->getSizeOfContainer());
		$this->instance->appendCourseCatalogElementId(2);
		$this->assertEquals(1, $this->instance->getSizeOfContainer());
		$this->instance->appendCourseCatalogElementId(32);
		$this->assertEquals(2, $this->instance->getSizeOfContainer());
		$this->instance->appendCourseCatalogElementId(2);
		$this->assertEquals(2, $this->instance->getSizeOfContainer());
		$this->instance->appendCourseCatalogElementId(PHP_INT_MAX);
		$this->assertEquals(3, $this->instance->getSizeOfContainer());
	}
}