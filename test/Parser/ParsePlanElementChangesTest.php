<?php

include_once './libs/composer/vendor/autoload.php';

use  HisInOneProxy\Parser;

require_once 'test/TestCaseExtension.php';

/**
 * Class ParsePlanElementChangesTest
 */
class ParsePlanElementChangesTest extends TestCaseExtension
{
	/**
	 * @var \HisInOneProxy\Log\Log
	 */
	protected $log;

	protected $collectedMessages = array();

	protected function setUp()
	{
		parent::setUp();
	}

	public function test_simpleUnitIncompleteParsing_shouldReturnLogWarning()
	{
		$xml    = file_get_contents('test/fixtures/incomplete/plan_element_change_incomplete.xml');
		$parser = new Parser\ParsePlanElementChanges($this->log);
		$parser->parse(simplexml_load_string($xml), new \HisInOneProxy\DataModel\PlannedDate());
		$msg = array_pop($this->collectedMessages);
		$this->assertEquals('Warning: No id given for PlanElementChange, skipping!', $msg);
	}

	public function test_simplePersonPlanElementParsing_shouldReturnPersonPlanElement()
	{
		$xml      = file_get_contents('test/fixtures/plan_element_change.xml');
		$parser   = new Parser\ParsePlanElementChanges($this->log);
		$plan_element = new \HisInOneProxy\DataModel\PlannedDate();
		$parser->parse(simplexml_load_string($xml), $plan_element);
		$person_plan = $plan_element->getPlanElementChangeContainer()[0]; 
		$this->assertEquals('98', $person_plan->getId());
		$msg = array_pop($this->collectedMessages);
		$this->assertEquals('Info: Found Instructor with id 124.', $msg);
		$msg = array_pop($this->collectedMessages);
		$this->assertEquals('Info: Found PlanElementChange with id 98.', $msg);
		$this->assertEquals('54-234234-234-23421', $person_plan->getObjGuid());
		$this->assertEquals('12.02.2017', $person_plan->getNewDate());
		$this->assertEquals('31.02.2017', $person_plan->getOldDate());
		$this->assertEquals('4324523', $person_plan->getPlannedDatesId());
		$this->assertEquals('4324521', $person_plan->getRoomId());
		$this->assertEquals('11:00', $person_plan->getStartTime());
		$this->assertEquals('11:15', $person_plan->getEndTime());
		$this->assertEquals('2', $person_plan->getLanguageId());
		$this->assertEquals('1', $person_plan->getRemark());
		$this->assertEquals('1', count($person_plan->getInstructorContainer()));
	}


}