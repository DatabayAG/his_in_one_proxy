<?php

include_once './libs/composer/vendor/autoload.php';

use  HisInOneProxy\Parser;

require_once 'test/TestCaseExtension.php';

/**
 * Class ParseExamRelationTest
 */
class ParseExamRelationTest extends TestCaseExtension
{
	protected function setUp()
	{
		parent::setUp();
	}

	public function test_simpleExamRelation_shouldReturnExamRelation()
	{
		$xml      = file_get_contents('test/fixtures/exam_relation.xml');
		$parser   = new Parser\ParseExamRelation($this->log);
		$plan = new \HisInOneProxy\DataModel\PlanElement();
		$parser->parse(simplexml_load_string('<res><examplans>' . $xml . '</examplans></res>'), $plan);
		$element = $plan->getPersonPlanElementContainer();
		$this->assertEquals('1234', $element[0]->getPersonId());
		$msg = array_pop($this->collectedMessages);
		$this->assertEquals('Info: Found ExamRelation with id 1234.', $msg);
		$this->assertEquals('8', $element[0]->getWorkStatusId());
		$this->assertEquals('true', $element[0]->getCancellation());
		$this->assertEquals('67657', $element[0]->getPlanElementId());
		$this->assertEquals('7878', $element[0]->getUnitId());
	}
}