<?php

include_once './libs/composer/vendor/autoload.php';

use  HisInOneProxy\Parser;

require_once 'test/TestCaseExtension.php';

/**
 * Class ParseInstructorTest
 */
class ParseInstructorTest extends TestCaseExtension
{
	protected function setUp()
	{
		parent::setUp();
	}

	public function test_simpleUnitIncompleteParsing_shouldReturnLogWarning()
	{
		$xml    = file_get_contents('test/fixtures/incomplete/instructor_incomplete.xml');
		$parser = new Parser\ParseInstructors($this->log);
		$parser->parse(simplexml_load_string($xml), new \HisInOneProxy\DataModel\PlannedDate());
		$msg = array_pop($this->collectedMessages);
		$this->assertEquals('Warning: No id given for Instructor, skipping!', $msg);
	}

	public function test_simplePersonPlanElementParsing_shouldReturnPersonPlanElement()
	{
		$xml      = file_get_contents('test/fixtures/instructor.xml');
		$parser   = new Parser\ParseInstructors($this->log);
		$plan_element = new \HisInOneProxy\DataModel\PlannedDate();
		$parser->parse(simplexml_load_string($xml), $plan_element);
		$person_plan = $plan_element->getInstructorContainer()[0]; 
		$this->assertEquals('90', $person_plan->getId());
		$msg = array_pop($this->collectedMessages);
		$this->assertEquals('Info: Found Instructor with id 90.', $msg);
		$this->assertEquals('43543-5345-345-34-5-3454', $person_plan->getObjGuid());
		$this->assertEquals('7', $person_plan->getLockVersion());
		$this->assertEquals('45', $person_plan->getExaminationSubareaId());
		$this->assertEquals('64', $person_plan->getInstructorTaskId());
		$this->assertEquals('334', $person_plan->getPersonId());
		$this->assertEquals('43545', $person_plan->getPlanElementChangeId());
		$this->assertEquals('6547', $person_plan->getPlannedDatesId());
		$this->assertEquals('3', $person_plan->getSortOrder());
		$this->assertEquals('60', $person_plan->getTeachingLoadPercentage());
		$this->assertEquals('1', $person_plan->getWeight());

	}


}