<?php

include_once './libs/composer/vendor/autoload.php';

use  HisInOneProxy\Parser;

require_once 'test/TestCaseExtension.php';

class ParsePlanElementPreferencesPartTest extends TestCaseExtension
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
		$xml    = file_get_contents('test/fixtures/incomplete/plan_element_preference_part_incomplete.xml');
		$parser = new Parser\ParsePlanElementPreferenceParts($this->log);
		$parser->parse(simplexml_load_string($xml), new \HisInOneProxy\DataModel\PlanningPreference());
		$msg = array_pop($this->collectedMessages);
		$this->assertEquals('Warning: No id given for PlanElementPreferencePart, skipping!', $msg);
	}

	public function test_simplePersonPlanElementParsing_shouldReturnPersonPlanElement()
	{
		$xml      = file_get_contents('test/fixtures/plan_element_preference_part.xml');
		$parser   = new Parser\ParsePlanElementPreferenceParts($this->log);
		$plan_element = new \HisInOneProxy\DataModel\PlanningPreference();
		$parser->parse(simplexml_load_string($xml), $plan_element);
		$person_plan = $plan_element->getPlanElementPreferenceParts()[0]; 
		$this->assertEquals('231', $person_plan->getId());
		$msg = array_pop($this->collectedMessages);
		$this->assertEquals('Info: Found Room with id 23.', $msg);
		$msg = array_pop($this->collectedMessages);
		$this->assertEquals('Info: Found PreferredInstructor with id 4433.', $msg);
		$msg = array_pop($this->collectedMessages);
		$this->assertEquals('Info: Found PlanElementPreferencePart with id 231.', $msg);
		$this->assertEquals('54-24334234-234-23421', $person_plan->getObjGuid());
		$this->assertEquals('1', count($person_plan->getPreferredInstructors()));
		$this->assertEquals('2', $person_plan->getLockVersion());
		$this->assertEquals('21312', $person_plan->getBelongsToPlanElementPreferenceId());
		$instructor = $person_plan->getPreferredInstructors()[0];
		$this->assertEquals('43543-5345-345-34-5-3454', $instructor->getObjGuid());
		$this->assertEquals('7', $instructor->getLockVersion());
		$this->assertEquals('45', $instructor->getPreferredInstructorId());
		$this->assertEquals('245', $instructor->getPreferredInstructorForPlanElementPartsId());
		$this->assertEquals('2', $instructor->getPriority());

	}


}