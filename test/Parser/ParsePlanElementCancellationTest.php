<?php

include_once './libs/composer/vendor/autoload.php';

use  HisInOneProxy\Parser;

require_once 'test/TestCaseExtension.php';

class ParsePlanElementCancellationTest extends TestCaseExtension
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
		$xml    = file_get_contents('test/fixtures/incomplete/plan_element_cancellation_incomplete.xml');
		$parser = new Parser\ParsePlanElementCancellation($this->log);
		$parser->parse(simplexml_load_string($xml), new \HisInOneProxy\DataModel\PlannedDate());
		$msg = array_pop($this->collectedMessages);
		$this->assertEquals('Warning: No id given for PlanElementCancellation, skipping!', $msg);
	}

	public function test_simplePersonPlanElementParsing_shouldReturnPersonPlanElement()
	{
		$xml      = file_get_contents('test/fixtures/plan_element_cancellation.xml');
		$parser   = new Parser\ParsePlanElementCancellation($this->log);
		$plan_element = new \HisInOneProxy\DataModel\PlannedDate();
		$parser->parse(simplexml_load_string($xml), $plan_element);
		$person_plan = $plan_element->getPlanElementCancellationContainer()[0]; 
		$this->assertEquals('231', $person_plan->getId());
		$msg = array_pop($this->collectedMessages);
		$this->assertEquals('Info: Found PlanElementCancellation with id 231.', $msg);
		$this->assertEquals('2332423-234234-234-23421', $person_plan->getObjGuid());
		$this->assertEquals('1', $person_plan->getLockVersion());
		$this->assertEquals('34', $person_plan->getCanceledDate());
		$this->assertEquals('2', $person_plan->getLanguageId());
		$this->assertEquals('4324523', $person_plan->getPlannedDatesId());
		$this->assertEquals('1', $person_plan->getRemark());

	}


}