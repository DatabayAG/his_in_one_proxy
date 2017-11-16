<?php
require_once './libs/composer/vendor/autoload.php';

use  HisInOneProxy\DataModel;

/**
 * Class CourseCatalogLeafTest
 */
class CourseCatalogLeafTest extends PHPUnit\Framework\TestCase
{

	/**
	 * @var DataModel\CourseCatalogLeaf $instance
	 */
	protected $instance;

	protected function setUp()
	{
		$this->instance = new DataModel\CourseCatalogLeaf();
	}

	public function test_instantiateObject_shouldReturnInstance()
	{
		$this->assertInstanceOf('HisInOneProxy\DataModel\CourseCatalogLeaf', $this->instance);
	}

	public function test_getId_shouldReturnId()
	{
		$this->instance->setId(515);
		$this->assertEquals(515, $this->instance->getId());
	}

	public function test_getTitle_shouldReturnTitle()
	{
		$this->instance->setTitle('My big title.');
		$this->assertEquals('My big title.', $this->instance->getTitle());
	}

	public function test_getAssignedOrgUnits_shouldReturnAssignedOrgUnits()
	{
		$this->assertEquals(0, count($this->instance->getAssignedOrgUnits()));
		$this->instance->setAssignedOrgUnits(0);
		$this->assertEquals(1, count($this->instance->getAssignedOrgUnits()));
		$this->instance->setAssignedOrgUnits(array(1,2,3));
		$this->assertEquals(3, count($this->instance->getAssignedOrgUnits()));
	}

	public function test_getValidTo_shouldReturnValidTo()
	{
		$this->instance->setValidTo('31.03.2015');
		$this->assertEquals('31.03.2015', $this->instance->getValidTo());
	}

	public function test_getValidFrom_shouldReturnValidFrom()
	{
		$this->instance->setValidFrom('31.03.2013');
		$this->assertEquals('31.03.2013', $this->instance->getValidFrom());
	}

	public function test_getStateId_shouldReturnStateId()
	{
		$this->instance->setStateId(2);
		$this->assertEquals(2, $this->instance->getStateId());
	}

	public function test_getPrintOut_shouldReturnPrintOut()
	{
		$this->instance->setPrintOut(false);
		$this->assertEquals(false, $this->instance->getPrintOut());
	}

	public function test_getCommentary_shouldReturnCommentary()
	{
		$this->instance->setCommentary('Comment!');
		$this->assertEquals('Comment!', $this->instance->getCommentary());
	}

	public function test_getUnits_shouldReturnUnits()
	{
		$this->instance->setUnits(array(new DataModel\Unit(), new DataModel\Unit()));
		$this->assertEquals(2, count($this->instance->getUnits()));
	}
	
	public function test_replaceChildWithObject_shouldReplaceChildWithObject()
	{
		$child = new DataModel\CourseCatalogChild();
		$child->setCourseCatalogId(1);
		$this->instance->appendChild($child);
		$leaf = new DataModel\CourseCatalogLeaf();
		$leaf->setId(1);
		$leaf->setTitle('My replaced leaf');
		$this->instance->replaceChildWithObject(1, $leaf);
		$this->assertEquals('My replaced leaf', $this->instance->getChildren()[1]->getTitle());
	}
}