<?php
require_once './libs/composer/vendor/autoload.php';

use  HisInOneProxy\DataModel;

/**
 * Class StudentExistingTest
 */
class StudentExistingTest extends PHPUnit\Framework\TestCase
{

	/**
	 * @var DataModel\StudentExisting $instance
	 */
	protected $instance;

	protected function setUp()
	{
		$this->instance = new DataModel\StudentExisting();
	}

	public function test_instantiateObject_shouldReturnInstance()
	{
		$this->assertInstanceOf('HisInOneProxy\DataModel\StudentExisting', $this->instance);
	}

	public function test_getConnectedToSubject_shouldReturnConnectedToSubject()
	{
		$this->instance->setConnectedToSubject(55555555555);
		$this->assertEquals(55555555555, $this->instance->getConnectedToSubject());
	}

	public function test_getDegreePrograms70_shouldReturnDegreePrograms70()
	{
		$this->instance->setDegreePrograms70(new DataModel\DegreeProgram());
		$this->assertEquals(new DataModel\DegreeProgram(), $this->instance->getDegreePrograms70());
	}

	public function test_getEduType_shouldReturnEduType()
	{
		$this->instance->setEduType(342);
		$this->assertEquals(342, $this->instance->getEduType());
	}

	public function test_getEnrollmentDate_shouldReturnEnrollmentDate()
	{
		$date = new DateTime('2016-12-01 16:32');
		$this->instance->setEnrollmentDate($date);
		$this->assertEquals($date, $this->instance->getEnrollmentDate());
	}

	public function test_getExchangeProgramId_shouldReturnExchangeProgramId()
	{
		$this->instance->setExchangeProgramId(555455555);
		$this->assertEquals(555455555, $this->instance->getExchangeProgramId());
	}

	public function test_getHasLoanRequest_shouldReturnHasLoanRequest()
	{
		$this->instance->setHasLoanRequest(0);
		$this->assertEquals(0, $this->instance->getHasLoanRequest());
	}


	public function test_getHomeCountryId_shouldReturnHomeCountryId()
	{
		$this->instance->setHomeCountryId(2);
		$this->assertEquals(2, $this->instance->getHomeCountryId());
	}


	public function test_getHomeDistrictId_shouldReturnHomeDistrictId()
	{
		$this->instance->setHomeDistrictId(3);
		$this->assertEquals(3, $this->instance->getHomeDistrictId());
	}

	public function test_getHomeDistrictObjId_shouldReturnHomeDistrictObjId()
	{
		$this->instance->setHomeDistrictObjId(34);
		$this->assertEquals(34, $this->instance->getHomeDistrictObjId());
	}

	public function test_getKollegSemester_shouldReturnKollegSemester()
	{
		$this->instance->setKollegSemester(31);
		$this->assertEquals(31, $this->instance->getKollegSemester());
	}

	public function test_getLeaveSemester_shouldReturnLeaveSemester()
	{
		$this->instance->setLeaveSemester(3.3);
		$this->assertEquals(3.3, $this->instance->getLeaveSemester());
	}

	public function test_getOrgUnitId_shouldReturnOrgUnitId()
	{
		$this->instance->setOrgUnitId(313);
		$this->assertEquals(313, $this->instance->getOrgUnitId());
	}

	public function test_getOrgUnitLid_shouldReturnOrgUnitLid()
	{
		$this->instance->setOrgUnitLid(3324353453443);
		$this->assertEquals(3324353453443, $this->instance->getOrgUnitLid());
	}

	public function test_getPerson_shouldReturnPerson()
	{
		$this->instance->setPerson(new DataModel\Person());
		$this->assertEquals(new DataModel\Person(), $this->instance->getPerson());
	}

	public function test_getPracticalSemester_shouldReturnPracticalSemester()
	{
		$this->instance->setPracticalSemester(33243.53453443);
		$this->assertEquals(33243.53453443, $this->instance->getPracticalSemester());
	}

	public function test_getRequestForDisEnrollment_shouldReturnRequestForDisEnrollment()
	{
		$this->instance->setRequestForDisEnrollment(1);
		$this->assertEquals(1, $this->instance->getRequestForDisEnrollment());
	}

	public function test_getRegistrationNumber_shouldReturnRegistrationNumber()
	{
		$this->instance->setRegistrationNumber(1232432);
		$this->assertEquals(1232432, $this->instance->getRegistrationNumber());
	}

	public function test_getSemesterCountryId_shouldReturnSemesterCountryId()
	{
		$this->instance->setSemesterCountryId(3211);
		$this->assertEquals(3211, $this->instance->getSemesterCountryId());
	}

	public function test_getSemesterDistrictId_shouldReturnSemesterDistrictId()
	{
		$this->instance->setSemesterDistrictId(122222);
		$this->assertEquals(122222, $this->instance->getSemesterDistrictId());
	}

	public function test_getSemesterDistrictObjId_shouldReturnSemesterDistrictObjId()
	{
		$this->instance->setSemesterDistrictObjId(1111111111);
		$this->assertEquals(1111111111, $this->instance->getSemesterDistrictObjId());
	}

	public function test_getStudyStatusId_shouldReturnStudyStatusId()
	{
		$this->instance->setStudyStatusId(76);
		$this->assertEquals(76, $this->instance->getStudyStatusId());
	}

	public function test_getTermTypeValueId_shouldReturnTermTypeValueId()
	{
		$this->instance->setTermTypeValueId(9);
		$this->assertEquals(9, $this->instance->getTermTypeValueId());
	}

	public function test_getUniversitySemester_shouldReturnUniversitySemester()
	{
		$this->instance->setUniversitySemester(9.1);
		$this->assertEquals(9.1, $this->instance->getUniversitySemester());
	}

	public function test_getYear_shouldReturYear()
	{
		$this->instance->setYear(1999);
		$this->assertEquals(1999, $this->instance->getYear());
	}

	public function test_ggetStudentFunctionLocks_shouldReturnStudentFunctionLocks()
	{
		$this->instance->setStudentFunctionLocks(91);
		$this->assertEquals(91, $this->instance->getStudentFunctionLocks());
	}

}