<?php

require_once 'test/TestCaseExtension.php';

use HisInOneProxy\Soap\Interactions\DataPrinter;
use HisInOneProxy\Soap\Interactions\DataCache;

class DataPrinterTest extends TestCaseExtension
{
	/**
	 * @var DataPrinter
	 */
	protected $instance;

	protected function setUp()
	{
		parent::setUp();
		DataCache::getInstance()->setLog($this->log);
		$this->instance = new DataPrinter();
	}
	
	protected function tearDown()
	{
		DataCache::getInstance()->setWorkStatus(null);
		DataCache::getInstance()->setParallelGroupValues(null);
		DataCache::getInstance()->setElearningPlatformContainer(null);
	}

	/**
	 * @return array
	 */
	protected function buildUnit()
	{
		$this->readWorkStatus();
		$this->readElearningPlatformContainer();
		$unit = new \HisInOneProxy\DataModel\Unit();
		$unit->setId(444);
		$unit->appendCourse(new \HisInOneProxy\DataModel\Course());
		$org_unit = new \HisInOneProxy\DataModel\OrgUnit();
		$org_unit->setLongText('bla');
		$unit->appendOrgUnit($org_unit);
		$type = new \HisInOneProxy\DataModel\ElearningCourseMapping();
		$type->setTermTypeValueId(2);
		$type->setYear(2000);
		$type->setCourseMappingTypeId(2);
		$unit->appendCourseMappingContainer(array($type));
		$units = array($unit, $unit);
		return $units;
	}
	
	protected function readWorkStatus()
	{
		$status = new \HisInOneProxy\DataModel\WorkStatus();
		$status->setId(1);
		$status->setDefaultText('Test');
		$container = new \HisInOneProxy\DataModel\Container\WorkStatusContainer();
		$container->appendWorkStatus($status);
		DataCache::getInstance()->setWorkStatus($container);
	}

	protected function readPersonDetails()
	{
		$per = new \HisInOneProxy\DataModel\Person();
		$per->setId(13423);
		$per->setFirstName('Hulla');
		$per->setSurName('Sure');
		$per->setTitleId(23);
		DataCache::getInstance()->addPersonDetails($per);
	}
	
	protected function readElearningPlatformContainer()
	{
		$platform = new \HisInOneProxy\DataModel\ElearningPlatform();
		$platform->setId(1);
		$platform->setDefaultText('Test');
		$container = new \HisInOneProxy\DataModel\Container\ElearningPlatformContainer();
		$container->appendElearningPlatform($platform);
		DataCache::getInstance()->setElearningPlatformContainer($container);
	}
	
	protected function readParallelGroupValuesContainer()
	{
		$group = new \HisInOneProxy\DataModel\ParallelGroupValue();
		$group->setId(1);
		$group->setLongText('LongTest');
		$container = new \HisInOneProxy\DataModel\Container\ParallelGroupValuesContainer();
		$container->appendParallelGroupValue($group);
		DataCache::getInstance()->setParallelGroupValues($container);
	}

	public function test_getInstance_shouldReturnInstance()
	{
		$this->assertInstanceOf('\HisInOneProxy\Soap\Interactions\DataPrinter', $this->instance );
	}

	/*public function test_convertUnitsToJson_shouldReturnArray()
	{
		$json = '[{"lectureID":null,"title":null,"abstract":null,"url":"","status":null,"organisation":"bla","workload":null,"term_type":2,"term":2000,"groupScenario":2,"groups":[{"id":null,"title":"Gruppe I","comment":"Comment 1","maxParticipants":10}],"courseID":null,"study_courses":null},{"lectureID":null,"title":null,"abstract":null,"url":"","status":null,"organisation":"bla","workload":null,"term_type":2,"term":2000,"groupScenario":2,"groups":[{"id":null,"title":"Gruppe I","comment":"Comment 1","maxParticipants":10}],"courseID":null,"study_courses":null}]';
		$units = $this->buildUnit();
		$builder = new \HisInOneProxy\Soap\JsonBuilder();
		$values = $builder->convertUnitsToJson($units);
		$this->assertEquals(json_encode($values), $json);
	}*/

	public function test_printUnits_shouldPrintUnits()
	{
		$this->collectedMessages = array();
		$units = $this->buildUnit();
		$this->instance->printUnits($units);
		$msg = array_pop($this->collectedMessages);
		$this->assertEquals( 'Debug: 		|-  Org-Lid: () Id: ()', $msg);
		$msg = array_pop($this->collectedMessages);
		$this->assertEquals('Debug: 		|* Mapping: eSystemId:  (), MappingId: 2', $msg);
		$msg = array_pop($this->collectedMessages);
		$this->assertEquals( 'Debug: 	|- 444, , , ', $msg);
		$msg = array_pop($this->collectedMessages);
		$this->assertEquals( 'Debug: |* Unit: , ', $msg);
		$msg = array_pop($this->collectedMessages);
		$this->assertEquals( 'Debug: 		|-  Org-Lid: () Id: ()', $msg);
		$msg = array_pop($this->collectedMessages);
		$this->assertEquals( 'Debug: 		|* Mapping: eSystemId:  (), MappingId: 2', $msg);
		$msg = array_pop($this->collectedMessages);
		$this->assertEquals( 'Debug: 	|- 444, , , ', $msg);
		$msg = array_pop($this->collectedMessages);
		$this->assertEquals( 'Debug: |* Unit: , ', $msg);
	}

	public function test_printExamRelation_shouldPrintExamRelation()
	{
		$this->readWorkStatus();
		$this->collectedMessages = array();
		$container = new \HisInOneProxy\DataModel\Container\ExamRelationContainer();
		$exam_relation = new \HisInOneProxy\DataModel\ExamRelation();
		$exam_relation->setPersonId(1);
		$exam_relation->setWorkStatusId(1);
		$exam_relation->setUnitId(2);
		$exam_relation->setPlanElementId(232);
		$container->appendExamRelation($exam_relation);

		$this->instance->printExamRelation($container, 0);
		$msg = array_pop($this->collectedMessages);
		$this->assertEquals($msg, 'Debug: 	|- WorkStatus id: 1 (Test), Cancellation: 0');
		$msg = array_pop($this->collectedMessages);
		$this->assertEquals($msg, 'Debug: |* ExamRelation: 1, 2, 232');
	}

	public function test_printPersonPlanElementContainer_shouldPrintPersonPlanElementContainer()
	{
		$this->readPersonDetails();
		$this->collectedMessages = array();
		$ppe = new \HisInOneProxy\DataModel\PersonPlanElement();
		$ppe->setPersonId(3);
		$ppe->setSortOrder(0);
		$ppe->setPlanElementId(5);
		$ppe->setPersonId(13423);

		$this->instance->printPersonPlanElementContainer(array($ppe), 0);
		$msg = array_pop($this->collectedMessages);
		$this->assertEquals($msg, 'Debug: 	|* Person: Hulla, Sure, 23');
		$msg = array_pop($this->collectedMessages);
		$this->assertEquals($msg, 'Debug: |* Person: 13423, 5, role: 2');
	}
	
	public function test_printCatalogDetail_shouldPrintCatalogDetail()
	{
		
		$leaf = new \HisInOneProxy\DataModel\CourseCatalogLeaf();
		$leaf->setId(3);
		$leaf->setTitle('My little title');

		$this->instance->printCatalogDetail($leaf, 0);
		$msg = array_pop($this->collectedMessages);
		$this->assertEquals($msg, 'Debug: 0|- My little title Id: (3)');
	}

	public function test_printOrgUnitDetail_shouldPrintOrgUnitDetail()
	{

		$org = new \HisInOneProxy\DataModel\OrgUnit();
		$org->setId(3);
		$org->setLid(343);
		$org->setParentId(0);
		$org->setDefaultText('My little title');

		$this->instance->printOrgUnitDetail($org, array(new \HisInOneProxy\DataModel\CourseOfStudy()), 0);
		$msg = array_pop($this->collectedMessages);
		$this->assertEquals('Debug: 0	|* My little title Org-Lid: (343) Id: (3)', $msg);

		$course_of_study = new \HisInOneProxy\DataModel\CourseOfStudy();
		$course_of_study->setDefaultText('default');
		$course_of_study->setOrgUnitLid(23121);
		$course_of_study->setId(23);
		
		$this->instance->printOrgUnitDetail($org, array("343"=> $course_of_study ), 0);
		$msg = array_pop($this->collectedMessages);
		$this->assertEquals($msg, 'Debug: 0	|* default Org-Lid: (23121) Id: (23)');
		$msg = array_pop($this->collectedMessages);
		$this->assertEquals($msg, 'Debug: 0|- My little title Lid: (343) Id: (3) ParentId: (0)');

	}

	public function test_printPlanElementContainer_shouldPrintPlanElementContainer()
	{
		$this->readParallelGroupValuesContainer();
		$plan = new \HisInOneProxy\DataModel\PlanElement();
		$plan->setId(51);
		$plan->setShortText('short');
		$plan->setLongText('long');
		$plan->setAttendeeMinimum(3);
		$plan->setAttendeeMaximum(34);
		$plan->setCancelled(34);
		$plan->setCredits(2);
		$plan->setHoursPerWeek(40);
		$plan->setParallelGroupId(1);

		$this->instance->printPlanElementContainer(array($plan), 0);
		$msg = array_pop($this->collectedMessages);
		$this->assertEquals($msg, 'Debug: 	|- Hours: 40, ParallelGroupId:1 => LongTest');
		$msg = array_pop($this->collectedMessages);
		$this->assertEquals($msg, 'Debug: 	|- Cancelled: 34, Credits:2');
		$msg = array_pop($this->collectedMessages);
		$this->assertEquals($msg, 'Debug: 	|- Attendee Min: 3, Attendee Max:34');
		$msg = array_pop($this->collectedMessages);
		$this->assertEquals($msg, 'Debug: |* PlanElement: short, long, 51');

	}

	public function test_printOrgUnit_shouldPrintOrgUnit()
	{
		$org = new \HisInOneProxy\DataModel\OrgUnit();
		$org->setId(51);
		$org->setLid(3423);
		$org->setDefaultText('1');
		$org->setParentId(0);
		$org2 = new \HisInOneProxy\DataModel\OrgUnit();
		$org2->setId(54);
		$org2->setLid(34223);
		$org2->setDefaultText('2');
		$org2->setParentId(3423);
		$org3 = new \HisInOneProxy\DataModel\OrgUnit();
		$org3->setId(534);
		$org3->setLid(342342323);
		$org3->setDefaultText('3');
		$org3->setParentId(34223);
		$org2->appendOrgUnit($org3);
		$org->appendOrgUnit($org2);
		$this->instance->printOrgUnit($org, array(new \HisInOneProxy\DataModel\CourseOfStudy()));
		$msg = array_pop($this->collectedMessages);
		$this->assertEquals( 'Debug: 		|* 2 Org-Lid: (34223) Id: (54)', $msg);
		$msg = array_pop($this->collectedMessages);
		$this->assertEquals('Debug: 	|- 2 Lid: (34223) Id: (54) ParentId: (3423)', $msg);
		$msg = array_pop($this->collectedMessages);
		$this->assertEquals('Debug: 	|* 1 Org-Lid: (3423) Id: (51)', $msg);
	}

	public function test_printOrgUnitForUnit_shouldPrintOrgUnit()
	{
		$org = new \HisInOneProxy\DataModel\OrgUnit();
		$org->setId(51);
		$org->setLid(3423);
		$org->setDefaultText('1');
		$org->setParentId(0);
		$this->instance->printOrgUnitForUnit($org, 1);
		$msg = array_pop($this->collectedMessages);
		$this->assertEquals('Debug: 	|- 1 Org-Lid: (3423) Id: (51)', $msg);
	}

	public function test_buildTabs_shouldReturnTabs()
	{
		$values = $this->instance->buildTabs(5);
		$this->assertEquals("\t\t\t\t\t", $values);
	}

}