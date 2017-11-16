<?php
require_once './libs/composer/vendor/autoload.php';

use  HisInOneProxy\DataModel;

/**
 * Class OrgUnitTest
 */
class OrgUnitTest extends PHPUnit\Framework\TestCase
{

	/**
	 * @var DataModel\OrgUnit $instance
	 */
	protected $instance;

	protected function setUp()
	{
		$this->instance = new DataModel\OrgUnit();
	}

	public function test_instantiateObject_shouldReturnInstance()
	{
		$this->assertInstanceOf('HisInOneProxy\DataModel\OrgUnit', $this->instance);
	}

	public function test_getId_shouldReturnId()
	{
		$this->instance->setId(1);
		$this->assertEquals(1, $this->instance->getId());
	}

	public function test_getUniqueName_shouldReturnUniqueName()
	{
		$this->instance->setUniqueName('Test Title');
		$this->assertEquals('Test Title', $this->instance->getUniqueName());
	}

	public function test_getLid_shouldReturnLid()
	{
		$this->instance->setLid(1234567890);
		$this->assertEquals(1234567890, $this->instance->getLid());
	}

	public function test_getAstat_shouldReturnAstat()
	{
		$this->instance->setAstat('Status 47');
		$this->assertEquals('Status 47', $this->instance->getAstat());
	}

	public function test_getShortText_shouldReturnShortText()
	{
		$this->instance->setShortText('My totally short text.');
		$this->assertEquals('My totally short text.', $this->instance->getShortText());
	}

	public function test_getLongText_shouldReturnLongText()
	{
		$this->instance->setLongText('Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Donec velit neque, auctor sit amet aliquam vel, ullamcorper sit amet ligula. Donec sollicitudin molestie malesuada. Donec sollicitudin molestie malesuada. Mauris blandit aliquet elit, eget tincidunt nibh pulvinar a. Donec sollicitudin molestie malesuada. Donec sollicitudin molestie malesuada. Proin eget tortor risus. Donec sollicitudin molestie malesuada. Curabitur aliquet quam id dui posuere blandit. Nulla quis lorem ut libero malesuada feugiat.');
		$this->assertEquals('Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Donec velit neque, auctor sit amet aliquam vel, ullamcorper sit amet ligula. Donec sollicitudin molestie malesuada. Donec sollicitudin molestie malesuada. Mauris blandit aliquet elit, eget tincidunt nibh pulvinar a. Donec sollicitudin molestie malesuada. Donec sollicitudin molestie malesuada. Proin eget tortor risus. Donec sollicitudin molestie malesuada. Curabitur aliquet quam id dui posuere blandit. Nulla quis lorem ut libero malesuada feugiat.', $this->instance->getLongText());
	}

	public function test_getDefaultText_shouldReturnDefaultText()
	{
		$this->instance->setDefaultText('My default text.');
		$this->assertEquals('My default text.', $this->instance->getDefaultText());
	}

	public function test_getParentId_shouldReturnParentId()
	{
		$this->instance->setParentId(4711);
		$this->assertEquals(4711, $this->instance->getParentId());
	}

	public function test_getParentLongId_shouldReturnParentLongId()
	{
		$this->instance->setParentLongId(4711452222);
		$this->assertEquals(4711452222, $this->instance->getParentLongId());
	}

	public function test_getTypeId_shouldReturnTypeId()
	{
		$this->instance->setTypeId(3);
		$this->assertEquals(3, $this->instance->getTypeId());
	}

	public function test_getValidFrom_shouldReturnValidFrom()
	{
		$this->instance->setValidFrom('2017-02-31');
		$this->assertEquals('2017-02-31', $this->instance->getValidFrom());
	}

	public function test_getValidTo_shouldReturnValidTo()
	{
		$this->instance->setValidTo('2017-12-31');
		$this->assertEquals('2017-12-31', $this->instance->getValidTo());
	}

	public function test_getLanguageId_shouldReturnLanguageId()
	{
		$this->instance->setLanguageId(4);
		$this->assertEquals(4, $this->instance->getLanguageId());
	}

	public function test_getContainer_shouldReturnContainer()
	{
		$ou = new DataModel\OrgUnit();
		$ou->setId(12);
		$this->instance->appendOrgUnit($ou);
		$this->instance->appendOrgUnit($ou);
		$this->assertEquals(2, count($this->instance->getContainer()));
	}

	public function test_getAddressContainer_shouldReturnContainer()
	{
		$this->instance->appendAddress(new DataModel\Address());
		$this->assertEquals(1, count($this->instance->getAddressContainer()));
	}

	public function test_replaceContainerObjectWithNewChildren_shouldReplaceContainer()
	{
		$root = new DataModel\OrgUnit();
		$root->setId(1);
		$ou = new DataModel\OrgUnit();
		$ou->setId(22);
		$ou2 = new DataModel\OrgUnit();
		$ou2->setId(4);
		$root->appendOrgUnit($ou);
		$root->appendOrgUnit($ou2);
		$this->assertEquals(2, count($root->getContainer()));
		$ou = new DataModel\OrgUnit();
		$ou->setId(5);
		$ou2 = new DataModel\OrgUnit();
		$ou2->setId(4);
		$ou->appendOrgUnit($ou2);
		$root->replaceContainerObjectWithNewChildren($ou);
		$this->assertEquals(1, count($root->getContainer()));
	}

	public function test_getSortOrder_shouldReturnOrder()
	{
		$this->instance->setSortOrder(1);
		$this->assertEquals(1, $this->instance->getSortOrder());
	}

	public function test_getShortCut_shouldReturnShortCut()
	{
		$this->instance->setShortCut('shortcut');
		$this->assertEquals('shortcut', $this->instance->getShortCut());
	}

	public function test_getChildCount_shouldReturnChildCount()
	{
		$this->instance->setChildCount(500);
		$this->assertEquals(500, $this->instance->getChildCount());
	}
}