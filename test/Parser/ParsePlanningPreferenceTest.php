<?php

include_once './libs/composer/vendor/autoload.php';

use  HisInOneProxy\Parser;

require_once 'test/TestCaseExtension.php';

/**
 * Class ParsePlanningPreferenceTest
 */
class ParsePlanningPreferenceTest extends TestCaseExtension
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

	public function test_simpleParseTimePreferences_shouldReturnLogWarning()
	{
		$xml    = file_get_contents('test/fixtures/incomplete/planning_preference_incomplete.xml');
		$parser = new Parser\ParsePlanningPreference($this->log);
		$parser->parse(simplexml_load_string($xml));
		$msg = array_pop($this->collectedMessages);
		$this->assertEquals('Warning: No id given for PlanningPreference, skipping!', $msg);
	}

	public function test_simpleParseTimePreferences_shouldReturnValue()
	{
		$xml    = file_get_contents('test/fixtures/planning_preference.xml');
		$parser =  new Parser\ParsePlanningPreference($this->log);
		$plan = $parser->parse(simplexml_load_string($xml));
		$this->assertEquals('435', $plan->getId());
		$msg = array_pop($this->collectedMessages);
		$this->assertEquals('Info: Found PlanningPreference with id 435.', $msg);	
		$this->assertEquals('4324-2343534-234-23-4-23', $plan->getObjGuid());
		$this->assertEquals('6', $plan->getLockVersion());
		$this->assertEquals('My super duper comment', $plan->getComment());
		$this->assertEquals('12:23', $plan->getFixedTime());
		$this->assertEquals('2', $plan->getOwnerPlanElementId());
		$this->assertEquals('4', $plan->getPartsInARow());
		$this->assertEquals('5', $plan->getTermTypeValueId());
	}


}