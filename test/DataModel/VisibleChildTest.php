<?php
require_once './libs/composer/vendor/autoload.php';

use  HisInOneProxy\DataModel;

/**
 * Class VisibleChildTest
 */
class VisibleChildTest extends PHPUnit\Framework\TestCase
{

	/**
	 * @var DataModel\VisibleChild $instance
	 */
	protected $instance;

	protected function setUp()
	{
		$this->instance = new DataModel\VisibleChild();
	}

	public function test_instantiateObject_shouldReturnInstance()
	{
		$this->assertInstanceOf('HisInOneProxy\DataModel\VisibleChild', $this->instance);
	}

	public function test_getParentUnitId_shouldReturnParentUnitId()
	{
		$this->instance->setParentUnitId(155);
		$this->assertEquals(155, $this->instance->getParentUnitId());
	}

	public function test_getSortOrder_shouldReturnSortOrder()
	{
		$this->instance->setSortOrder(2);
		$this->assertEquals(2, $this->instance->getSortOrder());
	}

	public function test_getChildElements_shouldReturnChildElements()
	{
		$this->instance->setChildElements(400);
		$this->assertEquals(400, $this->instance->getChildElements());
	}

	public function test_getChildDefaultText_shouldReturnChildDefaultText()
	{
		$this->instance->setChildDefaultText('text');
		$this->assertEquals('text', $this->instance->getChildDefaultText());
	}

	public function test_getRelationTypeId_shouldReturnRelationTypeId()
	{
		$this->instance->setRelationTypeId(1);
		$this->assertEquals(1, $this->instance->getRelationTypeId());
	}

	public function test_getUnitId_shouldReturnUnitId()
	{
		$this->instance->setUnitId(1111111);
		$this->assertEquals(1111111, $this->instance->getUnitId());
	}

}