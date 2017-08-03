<?php
require_once './libs/composer/vendor/autoload.php';

use  HisInOneProxy\DataModel;

class CourseCatalogChildTest extends PHPUnit\Framework\TestCase
{

	/**
	 * @var DataModel\CourseCatalogChild $instance
	 */
	protected $instance;

	protected function setUp()
	{
		$this->instance = new DataModel\CourseCatalogChild();
	}

	public function test_instantiateObject_shouldReturnInstance()
	{
		$this->assertInstanceOf('HisInOneProxy\DataModel\CourseCatalogChild', $this->instance);
	}

	public function test_getId_shouldReturnCourseCatalogId()
	{
		$this->instance->setCourseCatalogId(55);
		$this->assertEquals(55, $this->instance->getCourseCatalogId());
	}

	public function test_getType_shouldReturnType()
	{
		$this->instance->setType(322);
		$this->assertEquals(322, $this->instance->getType());
	}

	public function test_getSortOrder_shouldReturnSortOrder()
	{
		$this->instance->setSortOrder(1);
		$this->assertEquals(1, $this->instance->getSortOrder());
	}

}