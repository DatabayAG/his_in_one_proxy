<?php
include_once './libs/composer/vendor/autoload.php';

use HisInOneProxy\Soap\Interactions;
use HisInOneProxy\Soap\Interactions\DataCache;
use HisInOneProxy\Soap;

require_once 'test/TestCaseExtension.php';

/**
 * Class JsonBuilderTest
 */
class JsonBuilderTest extends TestCaseExtension
{
	/**
	 * @return \HisInOneProxy\DataModel\OrgUnit
	 */
	protected function buildOrgStructure()
	{
		$org_unit = new \HisInOneProxy\DataModel\OrgUnit();
		$org_unit->setId(2);
		$org_unit->setLongText('long_text');
		$org_unit->setParentId(2);
		$sub_unit = new \HisInOneProxy\DataModel\OrgUnit();
		$sub_unit->setId(3);
		$sub_unit->setLongText('child');
		$sub_unit->setParentId(2);
		$org_unit->appendOrgUnit($sub_unit);
		$sub_unit = new \HisInOneProxy\DataModel\OrgUnit();
		$sub_unit->setId(4);
		$sub_unit->setLongText('child 2');
		$sub_unit->setParentId(2);
		$org_unit->appendOrgUnit($sub_unit);
		return $org_unit;
	}

	public function test_recursiveAppendEmptyOrgUnits_shouldReturnStdClass()
	{

		$builder = new Interactions\JsonBuilder();

		$nodes = $this->callMethod(
			$builder,
			'recursiveAppendOrgUnits',
			array(new \HisInOneProxy\DataModel\OrgUnit() , 2)
		);

		$expected = '[]';
		$this->assertEqualClearedString($expected,json_encode($nodes));
	}

	public function test_recursiveAppendOrgUnits_shouldReturnStdClass()
	{

		$org_unit = $this->buildOrgStructure();

		$builder = new Interactions\JsonBuilder();

		$nodes = $this->callMethod(
			$builder,
			'recursiveAppendOrgUnits',
			array($org_unit, 2)
		);

		$expected = '[{"id":3,"title":"child","parent":2,"nodes":[[]]},{"id":4,"title":"child 2","parent":2,"nodes":[[]]}]';
		$this->assertEqualClearedString($expected,json_encode($nodes));
	}

	public function test_convertEmptyOrgUnitsToJson_shouldReturnStdClass()
	{

		$builder = new Interactions\JsonBuilder();

		$nodes = $this->callMethod(
			$builder,
			'convertOrgUnitsToJson',
			array(new \HisInOneProxy\DataModel\OrgUnit(), 2)
		);

		$expected = '[{"rootID":null,"directoryTreeTitle":null,"parent":"","term":"","nodes":[]}]';
		$this->assertEqualClearedString($expected, json_encode($nodes));
	}

	public function test_convertOrgUnitsToJson_shouldReturnStdClass()
	{

		$org_unit = $this->buildOrgStructure();

		$builder = new Interactions\JsonBuilder();

		$nodes = $this->callMethod(
			$builder,
			'convertOrgUnitsToJson',
			array($org_unit, 2)
		);

		$expected = '[{"rootID":2,"directoryTreeTitle":"long_text","parent":"","term":"","nodes":[{"id":3,"title":"child","parent":2,"nodes":[[]]},{"id":4,"title":"child 2","parent":2,"nodes":[[]]}]}]';
		$this->assertEqualClearedString($expected,json_encode($nodes));
	}

	public function test_buildPersonContainer_shouldCreateElement()
	{

		$persons = array();
		$person = new \HisInOneProxy\DataModel\PersonPlanElement();
		$person->setPersonId(4);
		$person->setPlanElementId(44);
		$persons[] = $person;

		$builder = new Interactions\JsonBuilder();
		$plan_element = new \HisInOneProxy\DataModel\PlanElement();
		$plan_element->appendPersonPlanElement($person);

		$this->callMethod(
			$builder,
			'buildPersonContainer',
			array($plan_element, 1, 1, array())
		);
		$nodes = $builder->getPersonPlanElements();
		$expected = '[{"lectureID":1,"members":[]}]' ;

		$this->assertEqualClearedString($expected,json_encode($nodes));
	}

	public function test_addMappingToArray_shouldAddMapping()
	{

		$builder = new Interactions\JsonBuilder();

		$this->callMethod(
			$builder,
			'addMappingToArray',
			array(2, 4)
		);
		$node = $builder->getElearningSystemStringFromPlanElementId(2);
		$this->assertEquals(4,$node);

		$this->callMethod(
			$builder,
			'addMappingToArray',
			array(2, 3)
		);
		$node = $builder->getElearningSystemStringFromPlanElementId(2);
		$this->assertEquals(4, $node);

		$node = $builder->getElearningSystemStringFromPlanElementId(3);
		$this->assertEquals('', $node);
		$this->assertEqualClearedString('Error: No e-learning system found for plan element id (3), this should not be possible.', array_pop($this->collectedMessages));
	}

	public function test_appendMapping_shouldAppendMapping()
	{

		$builder = new Interactions\JsonBuilder();

		$mapping = array();
		$e_learning = new \HisInOneProxy\DataModel\ElearningCourseMapping();
		$e_learning->setELearningSystemId(1);
		$e_learning->setCourseMappingTypeId(2);
		$e_learning->setYear(2017);
		$mapping[] = $e_learning;
		$e_learning = new \HisInOneProxy\DataModel\ElearningCourseMapping();
		$e_learning->setELearningSystemId(2);
		$e_learning->setCourseMappingTypeId(2);
		$e_learning->setYear(2017);
		$mapping[] = $e_learning;
		
		$row = new \stdClass();
		$this->callMethod(
			$builder,
			'appendMapping',
			array($mapping, $row)
		);
	
		$this->assertEquals('2,3',$row->elearning_sys_string);
	}

	public function test_appendOrgUnits_shouldReturnOrgUnits()
	{

		$builder = new Interactions\JsonBuilder();

		$container = array();
		$org = new \HisInOneProxy\DataModel\OrgUnit();
		$org->setLid(1);
		$org->setDefaultText('My Text');
		$container[] = $org;
		$org = new \HisInOneProxy\DataModel\OrgUnit();
		$org->setLid(2);
		$org->setDefaultText('My Text 2');
		$container[] = $org;
		$org = new \HisInOneProxy\DataModel\OrgUnit();
		$org->setLid(3);
		$org->setDefaultText('My Text 3');
		$container[] = $org;

		$org_units = $this->callMethod(
			$builder,
			'addOrgUnits',
			array($container)
		);

		$this->assertEqualClearedString('[{"id":1,"title":"My Text"},{"id":2,"title":"My Text 2"},{"id":3,"title":"My Text 3"}]', json_encode($org_units));
	}

	public function test_appendLinks_shouldReturnLinks()
	{

		$builder = new Interactions\JsonBuilder();

		$container = array();
		$link = new stdClass();
		$container[] = $link;

		$links = $this->callMethod(
			$builder,
			'addLinks',
			array($container)
		);

		$this->assertEqualClearedString('[{"title":"","href":""}]', json_encode($links));
	}

	public function test_appendTargetAudience_shouldReturnTargetAudience()
	{

		$builder = new Interactions\JsonBuilder();

		$container = array();
		$aud = new stdClass();
		$container[] = $aud;

		$audience = $this->callMethod(
			$builder,
			'addTargetAudience',
			array($container)
		);

		$this->assertEqualClearedString('[]', json_encode($audience));
	}

	public function test_appendAllocations_shouldReturnAllocations()
	{

		$builder = new Interactions\JsonBuilder();

		$container = array();
		$all = new stdClass();
		$container[] = $all;

		$allocation = $this->callMethod(
			$builder,
			'addAllocations',
			array($container)
		);

		$this->assertEqualClearedString('[{"parentID":"","order":""}]', json_encode($allocation));
	}

	public function test_appendDegreeProgrammes_shouldReturnDegreeProgrammes()
	{

		$builder = new Interactions\JsonBuilder();

		$container = array();
		$prog = new stdClass();
		$container[] = $prog;

		$program = $this->callMethod(
			$builder,
			'addDegreeProgrammes',
			array($container)
		);

		$this->assertEqualClearedString('[{"id":"","title":"","courseUnitYearOfStudy":"","from":"","to":""}]', json_encode($program));
	}

	public function test_appendNodesWithEmptyLeaf_shouldReturnNodes()
	{

		$builder = new Interactions\JsonBuilder();

		$leaf  = new \HisInOneProxy\DataModel\CourseCatalogLeaf();
		$nodes = $this->callMethod(
			$builder,
			'appendNodes',
			array($leaf)
		);
		$this->assertEqualClearedString('[]', json_encode($nodes));

	}

	public function test_appendNodes_shouldReturnNodes()
	{
		$builder = new Interactions\JsonBuilder();

		$leaf = new \HisInOneProxy\DataModel\CourseCatalogLeaf();
		$child = new \HisInOneProxy\DataModel\CourseCatalogChild();
		$child->setCourseCatalogId(1);
		$child->setType('My type');
		$leaf->appendChild($child);
		
		$nodes = $this->callMethod(
			$builder,
			'appendNodes',
			array($leaf)
		);

		$this->assertEqualClearedString('[{"id":1,"title":"My type","nodes":[[]]}]', json_encode($nodes));
	}

	public function test_appendGroupsWithEmptyUnit_shouldReturnRow()
	{

		$builder = new Interactions\JsonBuilder();

		$unit = new \HisInOneProxy\DataModel\Unit();
		$row = new stdClass();
		$this->callMethod(
			$builder,
			'appendGroups',
			array($unit, $row, 1)
		);
		$exp = '{"groups":[]}';
		$this->assertEqualClearedString($exp, json_encode($row));
	}

	public function test_appendGroups_shouldReturnRow()
	{
		$builder = new Interactions\JsonBuilder();
		$unit = new \HisInOneProxy\DataModel\Unit();
		$plan = new \HisInOneProxy\DataModel\PlanElement();
		$plan->setId(1);
		$plan->setAttendeeMaximum(12);
		$plan->setHoursPerWeek(40);
		$plan->setLiterature('My power book.');
		$plan->setParallelGroupId(1);
		$plan->setRecommendedRequirement('You should have done this.');
		$plan->appendPersonPlanElement(new \HisInOneProxy\DataModel\PersonPlanElement());
		$unit->appendPlanElement($plan);
		$row = new stdClass();
		
		$value = new \HisInOneProxy\DataModel\ParallelGroupValue();
		$value->setId(1);
		$value->setLongText('My group value.');
		$value->setDefaultText('My group value.');
		$container = new \HisInOneProxy\DataModel\Container\ParallelGroupValuesContainer();
		$container->appendParallelGroupValue($value);
		DataCache::getInstance()->setParallelGroupValues($container);
		
		$this->callMethod(
			$builder,
			'appendGroups',
			array($unit, $row, 1)
		);

		$exp = '{"groups":[{"id":1,"title":"My group value.","maxParticipants":12,"hours":40,"lectureres":[{}],"datesAndVenues":""}],"hoursPerWeek":40,"recommendedReading":"My power book.","prerequisites":"You should have done this."}';
		$this->assertEqualClearedString($exp, json_encode($row));
	}

	public function test_convertCourseCatalogToJson_shouldReturnArray()
	{

		$builder = new Interactions\JsonBuilder();

		$cc = new \HisInOneProxy\DataModel\CourseCatalogLeaf();
		$cc->setId(1);
		$cc->setTitle('My Root node');

		$nodes = $this->callMethod(
			$builder,
			'convertCourseCatalogToArray',
			array($cc)
		);

		$this->assertEqualClearedString('[{"rootID":1,"directoryTreeTitle":"My Root node","term":"","nodes":[]}]', json_encode($nodes));
	}

	public function test_convertUnitsToJson_shouldReturnArray()
	{

		$builder = new Interactions\JsonBuilder();

		$container = array();
		$unit = new \HisInOneProxy\DataModel\Unit();
		$unit->setLongText('My long text.');
		$unit->setDefaultText('My long text.');
		$unit->setComment('My comment for this unit.');
		$unit->setLid(4000);
		$unit->setStatusId(2);
		$unit->setElementTypeId(1);
		$unit->setShortText('My short text');
		$cour = new \HisInOneProxy\DataModel\Course();
		$cour->setWorkload(23);
		$unit->appendCourse($cour);

		$mapping = array();
		$e_learning = new \HisInOneProxy\DataModel\ElearningCourseMapping();
		$e_learning->setELearningSystemId(1);
		$e_learning->setCourseMappingTypeId(22);
		$e_learning->setYear(2017);
		$mapping[] = $e_learning;
		
		$unit->appendCourseMappingContainer($mapping);
		
		$container[] = $unit;
		$nodes = $this->callMethod(
			$builder,
			'convertUnitsToArray',
			array($container)
		);

		$exp = '[{"workload":23,"lectureID":null,"elearning_sys_string":"2","term_type":null,"term":2017,"groupScenario":0,"abstract":"Mylongtext.","comment1":"Mycommentforthisunit.","courseID":4000,"lectureAssessmentType":"","number":"","organisation":"","status":2,"study_courses":4000,"termID":"","lectureType":1,"title":"Mylongtext.","url":"","allocations":[],"degreeProgrammes":[],"organisationalUnits":[],"targetAudiences":[],"groups":[]}]';
		$this->assertEqualClearedString($exp, json_encode($nodes));
	}

	public function test_convertEmptyUnitsToJson_shouldReturnArray()
	{

		$builder = new Interactions\JsonBuilder();


		$unit = new \HisInOneProxy\DataModel\Unit();
		$course = new \HisInOneProxy\DataModel\Course();
		$unit->appendCourse($course);
		$container[] = $unit;
		$nodes = $this->callMethod(
			$builder,
			'convertUnitsToArray',
			array($container)
		);

		$exp = '[{"workload":null,"lectureID":null,"elearning_sys_string":"","abstract":null,"comment1":null,"courseID":null,"lectureAssessmentType":"","number":"","organisation":"","status":null,"study_courses":null,"termID":"","lectureType":null,"title":null,"url":"","allocations":[],"degreeProgrammes":[],"organisationalUnits":[],"targetAudiences":[],"groups":[]}]';
		$this->assertEqualClearedString($exp, json_encode($nodes));
	}

	public function test_convertUnitsToJson2_shouldReturnArray()
	{

		$builder = new Interactions\JsonBuilder();

		$container = array();
		$unit = new \HisInOneProxy\DataModel\Unit();
		$unit->setComment('My comment for this unit.');
		$unit->setLongText('My long text.');
		$unit->setLid(4000);
		$unit->setStatusId(2);
		$unit->setElementTypeId(1);
		$unit->setShortText('My short text');
		$cour = new \HisInOneProxy\DataModel\Course();
		$cour->setWorkload(23);
		$unit->appendCourse($cour);

		$mapping = array();
		$e_learning = new \HisInOneProxy\DataModel\ElearningCourseMapping();
		$e_learning->setELearningSystemId(1);
		$e_learning->setCourseMappingTypeId(2);
		$e_learning->setYear(2017);
		$mapping[] = $e_learning;

		$unit->appendCourseMappingContainer($mapping);
		
		$plan = new \HisInOneProxy\DataModel\PlanElement();
		$plan->setId(3);
		$plan->setParallelGroupId(1);
		$plan->setDefaultText('My long text.');
		$unit->appendPlanElement($plan);

		$value = new \HisInOneProxy\DataModel\ParallelGroupValue();
		$value->setId(1);
		$value->setDefaultText('My group value.');
		$container2 = new \HisInOneProxy\DataModel\Container\ParallelGroupValuesContainer();
		$container2->appendParallelGroupValue($value);
		DataCache::getInstance()->setParallelGroupValues($container2);

		$row = new stdClass();
		$container[] = $unit;
		$nodes = $this->callMethod(
			$builder,
			'convertUnitsToArray',
			array($container, $row)
		);

		$exp = '[{"workload":23,"lectureID":null,"elearning_sys_string":"2","term_type":null,"term":2017,"groupScenario":"1","abstract":"Mylongtext.","comment1":"Mycommentforthisunit.","courseID":4000,"lectureAssessmentType":"","number":"","organisation":"","status":2,"study_courses":4000,"termID":"","lectureType":1,"title":"Mylongtext.","url":"","allocations":[],"degreeProgrammes":[],"organisationalUnits":[],"targetAudiences":[],"groups":[{"id":3,"title":null,"maxParticipants":null,"hours":null,"lectureres":[{}],"datesAndVenues":""}],"hoursPerWeek":null,"recommendedReading":null,"prerequisites":null}]';
		$this->assertEqualClearedString($exp, json_encode($nodes));
	}


	public function test_convertComplexObject_shouldReturnArray()
	{

		$builder = new Interactions\JsonBuilder();

		$container = array();
		$unit = new \HisInOneProxy\DataModel\Unit();
		$unit->setComment('My comment for this unit.');
		$unit->setLongText('My long text.');
		$unit->setLid(4000);
		$unit->setStatusId(2);
		$unit->setElementTypeId(1);
		$unit->setShortText('My short text');
		$cour = new \HisInOneProxy\DataModel\Course();
		$cour->setWorkload(23);
		$cour->setId(1232);
		$unit->appendCourse($cour);

		$mapping = array();
		$e_learning = new \HisInOneProxy\DataModel\ElearningCourseMapping();
		$e_learning->setELearningSystemId(1);
		$e_learning->setCourseMappingTypeId(2);
		$e_learning->setYear(2017);
		$mapping[] = $e_learning;

		$unit->appendCourseMappingContainer($mapping);

		$plan = new \HisInOneProxy\DataModel\PlanElement();
		$plan->setId(3);
		$plan->setParallelGroupId(1);
		$plan->setDefaultText('My long text.');
		$unit->appendPlanElement($plan);
		$person = new \HisInOneProxy\DataModel\PersonPlanElement();
		$person->setPersonId(22);

		$account = new \HisInOneProxy\DataModel\CompleteAccount();
		$account->setBlockedId(1);
		$account->setUserName('x2345');
		$account->setId(22);
		$plan->appendPersonPlanElement($person);
		
		$plan2 = new \HisInOneProxy\DataModel\PlanElement();
		$plan2->setId(4);
		$plan2->setParallelGroupId(1);
		$plan2->setDefaultText('My long text 2.');
		$unit->appendPlanElement($plan2);

		$value = new \HisInOneProxy\DataModel\ParallelGroupValue();
		$value->setId(1);
		$value->setDefaultText('My group value.');
		$container2 = new \HisInOneProxy\DataModel\Container\ParallelGroupValuesContainer();
		$container2->appendParallelGroupValue($value);
		DataCache::getInstance()->setParallelGroupValues($container2);

		$row = new stdClass();
		$container[] = $unit;
		$nodes = $this->callMethod(
			$builder,
			'convertUnitsToArray',
			array($container, $row)
		);

		$exp = '[{"workload":23,"lectureID":1232,"elearning_sys_string":"2","term_type":null,"term":2017,"groupScenario":"1","abstract":"Mylongtext.","comment1":"Mycommentforthisunit.","courseID":4000,"lectureAssessmentType":"","number":"","organisation":"","status":2,"study_courses":4000,"termID":"","lectureType":1,"title":null,"url":"","allocations":[],"degreeProgrammes":[],"organisationalUnits":[],"targetAudiences":[],"groups":[{"id":3,"title":null,"maxParticipants":null,"hours":null,"lectureres":[{}],"datesAndVenues":""},{"id":4,"title":null,"maxParticipants":null,"hours":null,"lectureres":[{}],"datesAndVenues":""}],"hoursPerWeek":null,"recommendedReading":null,"prerequisites":null}]';
		$this->assertEqualClearedString($exp, json_encode($nodes));
	}

	public function test_convertComplexMembersObject_shouldReturnArray()
	{

		$builder = new Interactions\JsonBuilder();

		list($container, $unit) = $this->initializeUnitObject();
		$builder::resetPersonPlanElement();
		$row = new stdClass();
		$container[] = $unit;

		$this->callMethod(
			$builder,
			'convertUnitsToArray',
			array($container, $row)
		);
		$nodes = $builder->getPersonPlanElements();
		$exp = '[{"lectureID":1232,"members":[{"role":0,"personID":"x2345","personIDtype":"ecs_loginUID","groups":[{"num":3,"role":0},{"num":9,"role":0},{"num":4,"role":0},{"num":13,"role":0}]}]}]';
		$this->assertEqualClearedString($exp, json_encode($nodes));
	}

	/**
	 * @return array
	 */
	protected function initializeUnitObject()
	{
		$container = array();
		$unit      = new \HisInOneProxy\DataModel\Unit();
		$cour = new \HisInOneProxy\DataModel\Course();
		$cour->setId(1232);
		$unit->appendCourse($cour);

		$mapping    = array();
		$e_learning = new \HisInOneProxy\DataModel\ElearningCourseMapping();
		$e_learning->setELearningSystemId(1);
		$e_learning->setCourseMappingTypeId(2);
		$e_learning->setYear(2017);
		$mapping[] = $e_learning;

		$unit->appendCourseMappingContainer($mapping);

		$plan = new \HisInOneProxy\DataModel\PlanElement();
		$plan->setId(3);
		$plan->setParallelGroupId(56);
		$unit->appendPlanElement($plan);
		$person = new \HisInOneProxy\DataModel\Person();
		$person->setId(22);
		$person_plan = new \HisInOneProxy\DataModel\PersonPlanElement();
		$person_plan->setPersonId(22);
		$person_plan->setPlanElementId(3);
		$account = new \HisInOneProxy\DataModel\CompleteAccount();
		$account->setBlockedId(1);
		$account->setUserName('x2345');
		$account->setId(22);
		$plan->appendPersonPlanElement($person_plan);

		DataCache::getInstance()->addPersonDetailsToCache($person);
		DataCache::getInstance()->addAccountsForPerson($person, array($account));

		$plan = new \HisInOneProxy\DataModel\PlanElement();
		$plan->setId(9);
		$plan->setParallelGroupId(56);
		$unit->appendPlanElement($plan);
		$plan2 = new \HisInOneProxy\DataModel\PlanElement();
		$plan2->setId(4);
		$plan2->setParallelGroupId(56);
		$unit->appendPlanElement($plan2);
		$plan3 = new \HisInOneProxy\DataModel\PlanElement();
		$plan3->setId(13);
		$plan3->setParallelGroupId(56);
		$unit->appendPlanElement($plan3);

		$value = new \HisInOneProxy\DataModel\ParallelGroupValue();
		$value->setId(56);
		$value->setDefaultText('My group value.');
		$container2 = new \HisInOneProxy\DataModel\Container\ParallelGroupValuesContainer();
		$container2->appendParallelGroupValue($value);
		DataCache::getInstance()->setParallelGroupValues($container2);

		return array($container, $unit);
	}

}