<?php

include_once './libs/composer/vendor/autoload.php';

use  HisInOneProxy\Parser;

require_once 'test/TestCaseExtension.php';

class ParseTimePreferenceTest extends TestCaseExtension
{
	protected function setUp()
	{
		parent::setUp();
	}

	public function test_simpleParseTimePreferences_shouldReturnLogWarning()
	{
		$xml    = file_get_contents('test/fixtures/incomplete/time_preference_incomplete.xml');
		$parser = new Parser\ParseTimePreferences($this->log);
		$parser->parse(simplexml_load_string($xml), new \HisInOneProxy\DataModel\PlanningPreference());
		$msg = array_pop($this->collectedMessages);
		$this->assertEquals('Warning: No id given for TimePreference, skipping!', $msg);
	}

	public function test_simpleParseTimePreferences_shouldReturnValue()
	{
		$xml    = file_get_contents('test/fixtures/time_preference.xml');
		$parser =  new Parser\ParseTimePreferences($this->log);
		$planning_pref = new \HisInOneProxy\DataModel\PlanningPreference();
		$parser->parse(simplexml_load_string($xml), $planning_pref ,$this->log);
		$time_pref	= $planning_pref->getTimePreferenceContainer()[0];
		$this->assertEquals('432423', $time_pref->getId());
		$msg = array_pop($this->collectedMessages);
		$this->assertEquals('Info: Found TimeSlot with id 3213.', $msg);	
		$msg = array_pop($this->collectedMessages);
		$this->assertEquals('Info: Found TimePreference with id 432423.', $msg);
		$this->assertEquals('4324-234-234-23-4-23', $time_pref->getObjGuid());
		$this->assertEquals('55', $time_pref->getLockVersion());
		$this->assertEquals('12', $time_pref->getOwnerPersonPreferenceId());
		$this->assertEquals('42', $time_pref->getOwnerPlanElementPreferenceId());
		$this->assertEquals('1', $time_pref->getOwnerRoomClassId());
		$this->assertEquals('2', $time_pref->getTermTypeValueId());
		$this->assertEquals('1', $time_pref->getWeightingFactor());
		$this->assertEquals('1200', $time_pref->getYear());
		$this->assertEquals('3213', $time_pref->getTimeSlotContainer()[0]->getId());

	}


}