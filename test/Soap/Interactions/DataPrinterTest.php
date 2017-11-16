<?php

require_once 'test/TestCaseExtension.php';

use HisInOneProxy\Soap\Interactions\DataPrinter;
use HisInOneProxy\Soap\Interactions\DataCache;

/**
 * Class DataPrinterTest
 */
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
	 * @return \HisInOneProxy\DataModel\Person | \HisInOneProxy\DataModel\Person[]
	 */
	protected function getPersons($getMultiple = false)
	{
		$this->readWorkStatus();
		$this->collectedMessages = array();
		$per                     = new \HisInOneProxy\DataModel\Person();
		$per->setId(1);
		$per->setFirstName('Otto');
		$per->setSurName('Willy');
		$per->setTitleId(2);

		$eaddress = new \HisInOneProxy\DataModel\ElectronicAddress();
		$eaddress->setId(1);
		$eaddress->setObjGuid(1);
		$eaddress->setSortOrder(2);
		$eaddress->setEAddressTypeId(232);
		$eaddress->setEAddress('holla');
		$type = new \HisInOneProxy\DataModel\EAddressType();
		$type->setId(232);
		$type->setDefaultText('test');
		$this->callMethod(DataCache::getInstance(), 'setEAddressTypes', array(array('232' => $type)));
		$per->setEAddresses(array($eaddress));

		$obj = new DataCache();
		$pur = new \HisInOneProxy\DataModel\Purpose();
		$pur->setId(2);
		$pur->setDefaultText('Unittest');

		if($getMultiple)
		{
			$per2 = new \HisInOneProxy\DataModel\Person();
			$per2->setId(2);
			$per2->setFirstName('Heinz');
			$per2->setSurName('Willy');

			$this->setHiddenProperty($obj, 'purposes_list', array('2' => $pur));
			$this->setHiddenProperty($obj, 'person_cache', array('1' => $per, '2' => $per2));

			return array($per, $per2);
		}
		else
		{
			$this->setHiddenProperty($obj, 'purposes_list', array('2' => $pur));
			$this->setHiddenProperty($obj, 'person_cache', array('1' => $per));

			return $per;
		}

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

	public function test_printUnits_shouldPrintUnits()
	{
		$this->collectedMessages = array();
		$units = $this->buildUnit();
		$this->instance->printUnits($units);
		$msg = array_pop($this->collectedMessages);
		$this->assertEqualClearedString( 'Debug: 		|-  Org-Lid: () Id: ()', $msg);
		$msg = array_pop($this->collectedMessages);
		$this->assertEqualClearedString('Debug: 		|* Mapping: eSystemId:  (), MappingId: 2', $msg);
		$msg = array_pop($this->collectedMessages);
		$this->assertEqualClearedString( 'Debug: 	|- 444, , , ', $msg);
		$msg = array_pop($this->collectedMessages);
		$this->assertEqualClearedString( 'Debug: |* Unit: , ', $msg);
		$msg = array_pop($this->collectedMessages);
		$this->assertEqualClearedString( 'Debug: 		|-  Org-Lid: () Id: ()', $msg);
		$msg = array_pop($this->collectedMessages);
		$this->assertEqualClearedString( 'Debug: 		|* Mapping: eSystemId:  (), MappingId: 2', $msg);
		$msg = array_pop($this->collectedMessages);
		$this->assertEqualClearedString( 'Debug: 	|- 444, , , ', $msg);
		$msg = array_pop($this->collectedMessages);
		$this->assertEqualClearedString( 'Debug: |* Unit: , ', $msg);
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
		$this->assertEqualClearedString($msg, 'Debug: 	|- WorkStatus id: 1 (Test), Cancellation: 0');
		$msg = array_pop($this->collectedMessages);
		$this->assertEqualClearedString($msg, 'Debug: |* ExamRelation: 1, 2, 232');
	}

	public function test_printPersonEAddress_shouldPrintPersonEAddress()
	{
		$this->readWorkStatus();
		$this->collectedMessages = array();
		$eadresstype = new \HisInOneProxy\DataModel\ElectronicAddress();
		$eadresstype->setId(1);
		$eadresstype->setObjGuid(1);
		$eadresstype->setSortOrder(2);
		$eadresstype->setEAddressTypeId(232);
		$eadresstype->setEAddress('holla');
		$type = new \HisInOneProxy\DataModel\EAddressType();
		$type->setId(232);
		$type->setDefaultText('test');

		$this->callMethod(DataCache::getInstance(), 'setEAddressTypes', array(array('232' => $type)));

		$this->instance->printPersonEAddress(array($eadresstype), 0);
		$msg = array_pop($this->collectedMessages);
		$this->assertEqualClearedString($msg, 'Debug: |* eAddress: Id (1), objGuid (1), SortOrder (2), AddressType (232), AddressTypeReadable (test), Address (holla)');
	}

	public function test_printPersonAccounts_shouldPrintPersonAccounts()
	{
		$this->readWorkStatus();
		$this->collectedMessages = array();
		$ca = new \HisInOneProxy\DataModel\CompleteAccount();
		$ca->setId(1);
		$ca->setPersonId(43);
		$ca->setIsLdapAccount(2);
		$ca->setAuthInfo(232);
		$ca->setUserName('holla');
		$ca->setExternalSystemId(4);
		$ca->setPurposeId(2);

		$obj         = new DataCache();
		$pur = new \HisInOneProxy\DataModel\Purpose();
		$pur->setId(2);
		$pur->setDefaultText('Unittest');

		$this->setHiddenProperty($obj, 'purposes_list', array('2' => $pur));
		$this->instance->printPersonAccounts(array($ca), 0);
		$msg = array_pop($this->collectedMessages);
		$this->assertEqualClearedString($msg, 'Debug: |* Purpose: Unittest (2)');
		$msg = array_pop($this->collectedMessages);
		$this->assertEqualClearedString($msg, 'Debug: |* Account: Id (1), PersonId (43), Username (holla), Ldap (2), AuthId (), AuthInfo (232), ExternalId (4)');
	}

	public function test_printPerson_shouldPrintPerson()
	{
		$per = $this->getPersons();

		$this->instance->printPerson($per, 0);
		$msg = array_pop($this->collectedMessages);
		$this->assertEqualClearedString($msg, 'Debug:|*eAddress:Id(1),objGuid(1),SortOrder(2),AddressType(232),AddressTypeReadable(test),Address(holla)');
		$msg = array_pop($this->collectedMessages);
		$this->assertEqualClearedString($msg, 'Debug:|*Person:Otto,Willy,2');
	}

	public function test_printMultiplePersons_shouldPrintPersons()
	{
		$per_array = $this->getPersons(true);

		$this->instance->printMultiplePersons($per_array, 0);

		$msg = array_pop($this->collectedMessages);
		$this->assertEqualClearedString($msg, 'Debug:|*Person:Heinz,Willy,');
		$msg = array_pop($this->collectedMessages);
		$this->assertEqualClearedString($msg, 'Debug:|*eAddress:Id(1),objGuid(1),SortOrder(2),AddressType(232),AddressTypeReadable(test),Address(holla)');
		$msg = array_pop($this->collectedMessages);
		$this->assertEqualClearedString($msg, 'Debug:|*Person:Otto,Willy,2');

	}

	public function test_printCourseCatalog_shouldPrintCourseCatalog()
	{
		$this->collectedMessages = array();
		$cf = new \HisInOneProxy\DataModel\CourseCatalogLeaf();
		$cf->setId(1);
		$cf->setTitle('Root');

		$co = new \HisInOneProxy\DataModel\CourseCatalogChild();
		$co->setCourseCatalogId(2);
		$co->setType('Child I');

		$cf->appendChild($co);

		$this->instance->printCourseCatalog($cf, 0);
		$msg = array_pop($this->collectedMessages);
		$this->assertEqualClearedString($msg, 'Debug: |- Root Id: (1)');
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
		$this->assertEqualClearedString($msg, 'Debug: 	|* Person: Hulla, Sure, 23');
		$msg = array_pop($this->collectedMessages);
		$this->assertEqualClearedString($msg, 'Debug: |* Person: 13423, 5, role: 2');
	}
	
	public function test_printCatalogDetail_shouldPrintCatalogDetail()
	{
		
		$leaf = new \HisInOneProxy\DataModel\CourseCatalogLeaf();
		$leaf->setId(3);
		$leaf->setTitle('My little title');

		$this->instance->printCatalogDetail($leaf, 0);
		$msg = array_pop($this->collectedMessages);
		$this->assertEqualClearedString($msg, 'Debug: 0|- My little title Id: (3)');
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
		$this->assertEqualClearedString('Debug: 0	|* My little title Org-Lid: (343) Id: (3)', $msg);

		$course_of_study = new \HisInOneProxy\DataModel\CourseOfStudy();
		$course_of_study->setDefaultText('default');
		$course_of_study->setOrgUnitLid(23121);
		$course_of_study->setId(23);
		
		$this->instance->printOrgUnitDetail($org, array("343"=> $course_of_study ), 0);
		$msg = array_pop($this->collectedMessages);
		$this->assertEqualClearedString($msg, 'Debug: 0	|* default Org-Lid: (23121) Id: (23)');
		$msg = array_pop($this->collectedMessages);
		$this->assertEqualClearedString($msg, 'Debug: 0|- My little title Lid: (343) Id: (3) ParentId: (0)');

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
		$this->assertEqualClearedString($msg, 'Debug: 	|- Hours: 40, ParallelGroupId:1 => LongTest');
		$msg = array_pop($this->collectedMessages);
		$this->assertEqualClearedString($msg, 'Debug: 	|- Cancelled: 34, Credits:2');
		$msg = array_pop($this->collectedMessages);
		$this->assertEqualClearedString($msg, 'Debug: 	|- Attendee Min: 3, Attendee Max:34');
		$msg = array_pop($this->collectedMessages);
		$this->assertEqualClearedString($msg, 'Debug: |* PlanElement: short, long, 51');

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
		$this->assertEqualClearedString( 'Debug: 		|* 2 Org-Lid: (34223) Id: (54)', $msg);
		$msg = array_pop($this->collectedMessages);
		$this->assertEqualClearedString('Debug: 	|- 2 Lid: (34223) Id: (54) ParentId: (3423)', $msg);
		$msg = array_pop($this->collectedMessages);
		$this->assertEqualClearedString('Debug: 	|* 1 Org-Lid: (3423) Id: (51)', $msg);
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
		$this->assertEqualClearedString('Debug: 	|- 1 Org-Lid: (3423) Id: (51)', $msg);
	}

	public function test_buildTabs_shouldReturnTabs()
	{
		$values = $this->instance->buildTabs(5);
		$this->assertEquals("\t\t\t\t\t", $values);
	}

}