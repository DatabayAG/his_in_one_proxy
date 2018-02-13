<?php
require_once './libs/composer/vendor/autoload.php';

use  HisInOneProxy\DataModel;

/**
 * Class UnitTest
 */
class UnitTest extends PHPUnit\Framework\TestCase
{

	/**
	 * @var DataModel\Unit $instance
	 */
	protected $instance;

	protected function setUp()
	{
		$this->instance = new DataModel\Unit();
	}

	public function test_instantiateObject_shouldReturnInstance()
	{
		$this->assertInstanceOf('HisInOneProxy\DataModel\Unit', $this->instance);
	}

	public function test_getId_shouldReturnId()
	{
		$this->instance->setId(1);
		$this->assertEquals(1, $this->instance->getId());
	}

	public function test_getObjGuid_shouldReturnObjGuid()
	{
		$this->instance->setObjGuid(11);
		$this->assertEquals(11, $this->instance->getObjGuid());
	}

	public function test_getLockVersion_shouldReturnLockVersion()
	{
		$this->instance->setLockVersion(12);
		$this->assertEquals(12, $this->instance->getLockVersion());
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

	public function test_getComment_shouldReturnComment()
	{
		$this->instance->setComment('My default text.');
		$this->assertEquals('My default text.', $this->instance->getComment());
	}

	public function test_getShortComment_shouldReturnShortComment()
	{
		$this->instance->setShortComment('Shorty');
		$this->assertEquals('Shorty', $this->instance->getShortComment());
	}

	public function test_getElementNr_shouldReturnElementNr()
	{
		$this->instance->setElementNr('Why is an attribute called nr when it is a string?');
		$this->assertEquals('Why is an attribute called nr when it is a string?', $this->instance->getElementNr());
	}

	public function test_getElementTypeId_shouldReturnElementTypeId()
	{
		$this->instance->setElementTypeId(77);
		$this->assertEquals(77, $this->instance->getElementTypeId());
	}

	public function test_getLid_shouldReturnLid()
	{
		$this->instance->setLid(43);
		$this->assertEquals(43, $this->instance->getLid());
	}

	public function test_getStatusId_shouldReturnStatusId()
	{
		$this->instance->setStatusId(413);
		$this->assertEquals(413, $this->instance->getStatusId());
	}

	public function test_getVersionTag_shouldReturnVersionTag()
	{
		$this->instance->setVersionTag('My tag');
		$this->assertEquals('My tag', $this->instance->getVersionTag());
	}

	public function test_getVersionComment_shouldReturnVersionComment()
	{
		$this->instance->setVersionComment('My version comment.');
		$this->assertEquals('My version comment.', $this->instance->getVersionComment());
	}


	public function test_getOrgUnitsContainer2_shouldReturnOrgUnitsContainer()
	{
		$this->instance->setOrgUnitsContainer(array(new DataModel\OrgUnit()));
		$a = $this->instance->getOrgUnitsContainer();
		$this->assertEquals(1, count($this->instance->getOrgUnitsContainer()));
	}

	/**
	 * @expectedException HisInOneProxy\Exceptions\InvalidCourse
	 */
	public function test_appendCourse_shouldThrowInvalidCourseArgumentException()
	{
		$this->instance->appendCourse(new DataModel\Allocation());
	}

	public function test_getOrgUnitContainer_shouldReturnOrgUnits()
	{
		$this->instance->appendCourse(new DataModel\Course());
		$this->instance->appendCourse(new DataModel\Course());
		$this->instance->appendCourse(new DataModel\Course());
		$this->assertEquals(3, count($this->instance->getCourseContainer()));
	}

	/**
	 * @expectedException HisInOneProxy\Exceptions\InvalidPlanElement
	 */
	public function test_appendPlanElement_shouldThrowInvalidPlanElementArgumentException()
	{
		$this->instance->appendPlanElement(new DataModel\Allocation());
	}

	public function test_getPlanElement_shouldReturnPlanElements()
	{
		$this->instance->appendPlanElement(new DataModel\PlanElement());
		$this->instance->appendPlanElement(new DataModel\PlanElement());
		$this->assertEquals(2, count($this->instance->getPlanElementContainer()));
	}

	public function test_getOrgUnitsContainer_shouldReturnOrgUnitsContainer()
	{
		$this->instance->appendOrgUnit(new DataModel\OrgUnit());
		$this->assertEquals(1, count($this->instance->getOrgUnitsContainer()));
		$this->instance->appendOrgUnit(new DataModel\OrgUnit());
		$this->assertEquals(2, $this->instance->getSizeOfOrgUnitContainer());
	}

	/**
	 * @expectedException HisInOneProxy\Exceptions\InvalidOrgUnit
	 */
	public function test_appendOrgUnit_shouldThrowInvalidOrgUnitArgumentException()
	{
		$this->instance->appendOrgUnit(new DataModel\Allocation());
	}

	public function test_getCourseMappingContainer_shouldReturnCourseMappingContainer()
	{
		$this->instance->appendCourseMappingContainer(array(new DataModel\OrgUnit()));
		$this->assertEquals(1, count($this->instance->getCourseMappingContainer()));
		$this->assertEquals(1, $this->instance->getSizeOfCourseMappingContainer());
	}

	public function test_getChildContainer_shouldReturnChildContainer()
	{
		$container = new DataModel\Container\ChildRelationContainer();
		$child = new DataModel\ChildRelation();
		$child->setChildId("2");
		$container->appendChildRelation($child);
		$child = new DataModel\ChildRelation();
		$child->setChildId("3");
		$container->appendChildRelation($child);

		$this->assertEquals(2, count($container->getChildRelationContainer()));
	}

	public function test_replaceChildInContainer_shouldReplaceChildContainer()
	{
		$child_container = new  DataModel\Container\ChildRelationContainer();
		$child = new DataModel\ChildRelation();
		$child->setChildId("2");
		$child->setParentId(3);
		$child_container->appendChildRelation($child);
		$this->instance->setChildContainer($child_container);
		$a = $this->instance->getChildContainer();
		$this->assertEquals(3, $a[2]->getParentId());
		
		$child = new DataModel\ChildRelation();
		$child->setChildId("2");
		$child->setParentId(4);
		$this->instance->replaceChildInContainer(2, $child);
		$a = $this->instance->getChildContainer();
		$this->assertEquals(4, $a[2]->getParentId());
	}
}