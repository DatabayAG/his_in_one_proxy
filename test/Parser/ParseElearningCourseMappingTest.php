<?php

include_once './libs/composer/vendor/autoload.php';

use  HisInOneProxy\Parser;

require_once 'test/TestCaseExtension.php';

class ParseElearningCourseMappingTest extends TestCaseExtension
{
	protected function setUp()
	{
		parent::setUp();
	}

	public function test_simpleCourseOfStudyIncompleteParsing_shouldReturnLogWarning()
	{
		$xml    = file_get_contents('test/fixtures/incomplete/cos_incomplete.xml');
		$parser = new Parser\ParseExamRelation($this->log);
		$parser->parse(simplexml_load_string('<res><examplans><examplan></examplan></examplans></res>'), new \HisInOneProxy\DataModel\PlanElement() );
		$msg = array_pop($this->collectedMessages);
		$this->assertEquals('Warning: No id given for ExamRelation, skipping!', $msg);
	}

	public function test_simpleExamRelation_shouldReturnExamRelation()
	{
		$xml      = file_get_contents('test/fixtures/course_mapping.xml');
		$parser   = new Parser\ParseExamRelation($this->log);
		$plan = new \HisInOneProxy\DataModel\PlanElement();
		$parser->parse(simplexml_load_string($xml), $plan);
		$mapping = $plan->getPersonPlanElementContainer()[0];
		$this->assertEquals('67568376', $mapping->getPersonId());
		$msg = array_pop($this->collectedMessages);
		$this->assertEquals('Info: Found ExamRelation with id 67568376.', $msg);
		$this->assertEquals('23', $mapping->getPlanElementId());
		$this->assertEquals('32432', $mapping->getCancellation());
		$this->assertEquals('8', $mapping->getWorkStatusId());
	}
}
