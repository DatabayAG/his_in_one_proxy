<?php

include_once './libs/composer/vendor/autoload.php';

use  HisInOneProxy\Parser;

require_once 'test/TestCaseExtension.php';

/**
 * Class ParsePersonPlanElementTest
 */
class ParsePersonPlanElementTest extends TestCaseExtension
{
	/**
	 * @var \HisInOneProxy\Log\Log
	 */
	protected $log;

	protected function setUp()
	{
		parent::setUp();
	}

	public function test_simpleUnitIncompleteParsing_shouldReturnLogWarning()
	{
		$xml    = file_get_contents('test/fixtures/incomplete/person_plan_element_incomplete.xml');
		$parser = new Parser\ParsePersonPlanElement($this->log);
		$parser->parse(simplexml_load_string($xml), new \HisInOneProxy\DataModel\PlanElement());
		$msg = array_pop($this->collectedMessages);
		$this->assertEquals('Warning: No id given for PersonPlanElement, skipping!', $msg);
	}

	public function test_simplePersonPlanElementParsing_shouldReturnPersonPlanElement()
	{
		$xml      = file_get_contents('test/fixtures/person_plan_element.xml');
		$parser   = new Parser\ParsePersonPlanElement($this->log);
		$plan_element = new \HisInOneProxy\DataModel\PlanElement();
		$parser->parse(simplexml_load_string($xml), $plan_element);
		$person_plan = $plan_element->getPersonPlanElementContainer()[0]; 
		$this->assertEquals('21', $person_plan->getPersonId());
		$msg = array_pop($this->collectedMessages);
		$this->assertEquals('Info: Added person id 21.', $msg);

	}

	public function test_multiPersonPlanElementParsing_shouldReturnPersonPlanElement()
	{
		$xml      = file_get_contents('test/fixtures/person_plan_elements.xml');
		$parser   = new Parser\ParsePersonPlanElement($this->log);
		$plan_element = new \HisInOneProxy\DataModel\PlanElement();
		$parser->parse(simplexml_load_string($xml), $plan_element);
		$person_plan = $plan_element->getPersonPlanElementContainer()[0]; 
		$this->assertEquals('133972', $person_plan->getPersonId());
		$msg = array_pop($this->collectedMessages);
		$this->assertEquals('Info: Added person id 636.', $msg);

	}


}