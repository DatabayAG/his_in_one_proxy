<?php

include_once './libs/composer/vendor/autoload.php';

use  HisInOneProxy\Parser;

require_once 'test/TestCaseExtension.php';

/**
 * Class ParseEventDateTest
 */
class ParseEventDateTest extends TestCaseExtension
{

	protected function setUp()
	{
		parent::setUp();
	}

	public function test_simpleUnitIncompleteParsing_shouldReturnLogWarning()
	{
		$xml    = file_get_contents('test/fixtures/incomplete/event_date_incomplete.xml');
		$parser = new Parser\ParseEventDate($this->log);
		$parser->parse(simplexml_load_string($xml), new \HisInOneProxy\DataModel\PlanElement());
		$msg = array_pop($this->collectedMessages);
		$this->assertEquals('Warning: No id given for EventDate, skipping!', $msg);
	}

	public function test_simpleEventDateParsing_shouldReturnEventDate()
	{
		$xml      = file_get_contents('test/fixtures/event_date.xml');
		$parser   = new Parser\ParseEventDate($this->log);
		$plan_element = new \HisInOneProxy\DataModel\PlanElement();
		$parser->parse(simplexml_load_string($xml), $plan_element , $this->log);
		$event_date = $plan_element->getEventDateContainer()[0];
		$this->assertEquals('2', $event_date->getId());
		$msg = array_pop($this->collectedMessages);
		$this->assertEquals('Info: Found EventDate with id 2.', $msg);
		$this->assertEquals('3453443-435345435-43543543', $event_date->getObjGuid());
		$this->assertEquals('34', $event_date->getLockVersion());
		$this->assertEquals('2016', $event_date->getAcademicYear());
		$this->assertEquals('This', $event_date->getCompulsoryRequirement());
		$this->assertEquals('Short Content', $event_date->getContents());
		$this->assertEquals('courseAchievement', $event_date->getCourseAchievement());
		$this->assertEquals('12', $event_date->getCredits());
		$this->assertEquals('YEAH', $event_date->getExaminationAchievement());
		$this->assertEquals('Him', $event_date->getExternOrganizer());
		$this->assertEquals('5', $event_date->getGrading());
		$this->assertEquals('23', $event_date->getLearningTarget());
		$this->assertEquals('This Book', $event_date->getLiterature());
		$this->assertEquals('None', $event_date->getObjectiveQualification());
		$this->assertEquals('23', $event_date->getPlanElementId());
		$this->assertEquals('That', $event_date->getRecommendedRequirement());
		$this->assertEquals('You', $event_date->getTargetGroup());
		$this->assertEquals('2', $event_date->getTeachingLanguageId());
		$this->assertEquals('4', $event_date->getTeachingMethod());
		$this->assertEquals('12', $event_date->getWorkload());
	}
	

}