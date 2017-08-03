<?php

include_once './libs/composer/vendor/autoload.php';

use  HisInOneProxy\Parser;

require_once 'test/TestCaseExtension.php';

class ParseStudentExistingTest extends TestCaseExtension
{
	protected function setUp()
	{
		parent::setUp();
	}

	public function test_simplePersonExistingParsing_shouldReturnLogWarning()
	{
		$xml    = file_get_contents('test/fixtures/incomplete/student_existing_incomplete.xml');
		$parser = new Parser\ParseStudentExisting($this->log);
		$parser->parse(simplexml_load_string($xml));
		$msg = array_pop($this->collectedMessages);
		$this->assertEquals('Error: No person returned in student existing!', $msg);
	}

	public function test_simpleOrgUnitParsing_shouldReturnOrgUnit()
	{
		$xml      = file_get_contents('test/fixtures/student_existing.xml');
		$parser   = new Parser\ParseStudentExisting($this->log);
		$student = $parser->parse(simplexml_load_string($xml));
		$this->assertEquals('122', $student->getConnectedToSubject());
		$this->assertEquals('1232342', $student->getDegreePrograms70());
		$this->assertEquals('23', $student->getEduType());
		$this->assertEquals('1900-12-21', $student->getEnrollmentDate());
		$this->assertEquals('123', $student->getExchangeProgramId());
		$this->assertEquals('false', $student->getHasLoanRequest());
		$this->assertEquals('0', $student->getHomeCountryId());
		$this->assertEquals('23', $student->getHomeDistrictId());
		$this->assertEquals('444', $student->getHomeDistrictObjId());
		$this->assertEquals('12', $student->getKollegSemester());
		$this->assertEquals('15', $student->getLeaveSemester());
		$this->assertEquals('45', $student->getOrgUnitId());
		$this->assertEquals('3654775', $student->getOrgUnitLid());
		$this->assertEquals('Person', $student->getPerson());
		$this->assertEquals('12', $student->getPracticalSemester());
		$this->assertEquals('false', $student->getRequestForDisEnrollment());
		$this->assertEquals('978765', $student->getRegistrationNumber());
		$this->assertEquals('21', $student->getSemesterCountryId());
		$this->assertEquals('1', $student->getSemesterDistrictId());
		$this->assertEquals('2', $student->getSemesterDistrictObjId());
		$this->assertEquals('3', $student->getStudyStatusId());
		$this->assertEquals('4', $student->getTermTypeValueId());
		$this->assertEquals('1999', $student->getYear());
		$this->assertEquals('665', $student->getStudentFunctionLocks());

	}

}