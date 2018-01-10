<?php

include_once './libs/composer/vendor/autoload.php';

use  HisInOneProxy\Parser;

require_once 'test/TestCaseExtension.php';

/**
 * Class ParsePlanElementTest
 */
class ParsePlanElementTest extends TestCaseExtension
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

	public function test_simpleParsePlanElements_shouldReturnLogWarning()
	{
		$xml    = file_get_contents('test/fixtures/incomplete/plan_element_incomplete.xml');
		$parser = new Parser\ParsePlanElements($this->log);
		$parser->parse(simplexml_load_string($xml), new \HisInOneProxy\DataModel\Unit());
		$msg = array_pop($this->collectedMessages);
		$this->assertEquals('Warning: No id given for PlanElement, skipping!', $msg);
	}

	public function test_simpleParsePlanElements_shouldReturnValue()
	{
		$xml    = file_get_contents('test/fixtures/plan_element.xml');
		$parser =  new Parser\ParsePlanElements($this->log);
		$unit = new \HisInOneProxy\DataModel\Unit();
		$parser->parse(simplexml_load_string('<res>'.$xml.'</res>'), $unit);
		$plan = $unit->getPlanElementContainer()[0];
		$this->assertEquals('234', $plan->getId());
		$this->assertEquals('324-234-23-4325', $plan->getObjGuid());
		$this->assertEquals('2', $plan->getLockVersion());
		$this->assertEquals('2', $plan->getAttendeeMaximum());
		$this->assertEquals('1', $plan->getAttendeeMinimum());
		$this->assertEquals('22.01.2017', $plan->getCancelEnd());
		$this->assertEquals('0', $plan->getCancelled());
		$this->assertEquals('2', $plan->getDefaultLanguage());
		$this->assertEquals('Def Text', $plan->getDefaultText());
		$this->assertEquals('1', $plan->getGenderId());
		$this->assertEquals('23', $plan->getGradeAssessmentStatusId());
		$this->assertEquals('2', $plan->getHoursPerWeek());
		$this->assertEquals('Long Text', $plan->getLongText());
		$this->assertEquals('3', $plan->getParallelGroupId());
		$this->assertEquals('10.01.2017', $plan->getRegisterBegin());
		$this->assertEquals('22.01.2017', $plan->getRegisterEnd());
		$this->assertEquals('1', $plan->getRotation());
		$this->assertEquals('Def text', $plan->getShortText());
		$this->assertEquals('3', $plan->getTermSegment());
		$this->assertEquals('4', $plan->getTermTypeValueId());
		$this->assertEquals('12', $plan->getUnitId());
		$this->assertEquals('2017', $plan->getYear());
	}


}