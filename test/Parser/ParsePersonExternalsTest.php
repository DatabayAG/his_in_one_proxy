<?php

include_once './libs/composer/vendor/autoload.php';

use  HisInOneProxy\Parser;

require_once 'test/TestCaseExtension.php';

/**
 * Class ParsePersonPlanElementTest
 */
class ParsePersonExternalsTest extends TestCaseExtension
{
	/**
	 * @var \HisInOneProxy\Log\Log
	 */
	protected $log;

	protected function setUp()
	{
		parent::setUp();
	}

	public function test_simplePersonPlanElementParsing_shouldReturnPersonPlanElement()
	{
		$xml      = file_get_contents('test/fixtures/person_externals.xml');
		$parser   = new Parser\ParsePersonExternals($this->log);
		$plan_element = new \HisInOneProxy\DataModel\PlanElement();
		$parser->parse(simplexml_load_string($xml), $plan_element);
		$person_plan = $plan_element->getPersonExternalsContainer()[0]; 
		$this->assertEquals('133972', $person_plan->getPersonId());
		$msg = array_pop($this->collectedMessages);
		$this->assertEquals('Info: Added person id 133972.', $msg);

	}

	public function test_multiPersonPlanElementParsing_shouldReturnPersonPlanElement()
	{
		$xml      = file_get_contents('test/fixtures/person_externalsmulti.xml');
		$parser   = new Parser\ParsePersonExternals($this->log);
		$plan_element = new \HisInOneProxy\DataModel\PlanElement();
		$parser->parse(simplexml_load_string($xml), $plan_element);
		$person_plan = $plan_element->getPersonExternalsContainer()[0]; 
		$this->assertEquals('133972', $person_plan->getPersonId());
		$msg = array_pop($this->collectedMessages);
		$this->assertEquals('Info: Added person id 133972.', $msg);

	}


}