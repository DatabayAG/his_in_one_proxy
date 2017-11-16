<?php

include_once './libs/composer/vendor/autoload.php';

use  HisInOneProxy\Parser;

require_once 'test/TestCaseExtension.php';

/**
 * Class ErrorLogTest
 */
class ErrorLogTest extends TestCaseExtension
{
	protected function setUp()
	{
		parent::setUp();
	}

	public function test_simpleUnitIncompleteParsing_shouldReturnLogWarning()
	{
		$xml    = file_get_contents('test/fixtures/incomplete/unit_incomplete.xml');
		$parser = new Parser\ParseUnit($this->log);
		$parser->parse($xml);
		$msg = array_pop($this->collectedMessages);
		$this->assertEqualClearedString('Warning: No id given for Unit, skipping!', $msg);
	}

	public function test_simpleCourseIncompleteParsing_shouldReturnLogWarning()
	{
		$xml    = file_get_contents('test/fixtures/incomplete/unit_incomplete.xml');
		$parser = new Parser\ParseCourse($this->log);
		$parser->parse($xml);
		$msg = array_pop($this->collectedMessages);
		$this->assertEqualClearedString('Warning: No id given for Course, skipping!', $msg);
	}

	public function test_simplePlanElementIncompleteParsing_shouldReturnLogWarning()
	{
		$xml    = file_get_contents('test/fixtures/incomplete/plan_element_incomplete.xml');
		$parser = new Parser\ParsePlanElements($this->log);
		$parser->parse(simplexml_load_string( $xml ), new \HisInOneProxy\DataModel\Unit());
		$msg = array_pop($this->collectedMessages);
		$this->assertEqualClearedString('Warning: No id given for PlanElement, skipping!', $msg);
	}

	public function test_simplePreferredInstructorIncompleteParsing_shouldReturnLogWarning()
	{
		$xml    = file_get_contents('test/fixtures/incomplete/preferred_instructors_incomplete.xml');
		$parser = new Parser\ParsePreferredInstructors($this->log);
		$parser->parse(simplexml_load_string($xml), new \HisInOneProxy\DataModel\PlanElementPreferencePart());
		$msg = array_pop($this->collectedMessages);
		$this->assertEqualClearedString('Warning: No id given for PreferredInstructor, skipping!', $msg);
	}

	public function test_simplePlanElementPreferencePartIncompleteParsing_shouldReturnLogWarning()
	{
		$xml    = file_get_contents('test/fixtures/incomplete/plan_element_preference_part_incomplete.xml');
		$parser = new Parser\ParsePlanElementPreferenceParts($this->log);
		$parser->parse(simplexml_load_string($xml), new \HisInOneProxy\DataModel\PlanningPreference());
		$msg = array_pop($this->collectedMessages);
		$this->assertEqualClearedString('Warning: No id given for PlanElementPreferencePart, skipping!', $msg);
	}

	public function test_simplePlanningPreferenceIncompleteParsing_shouldReturnLogWarning()
	{
		$xml    = file_get_contents('test/fixtures/incomplete/unit_incomplete.xml');
		$parser = new Parser\ParsePlanningPreference($this->log);
		$parser->parse($xml);
		$msg = array_pop($this->collectedMessages);
		$this->assertEqualClearedString('Warning: No id given for PlanningPreference, skipping!', $msg);
	}

	public function test_simpleRoomIncompleteParsing_shouldReturnLogWarning()
	{
		$xml    = file_get_contents('test/fixtures/incomplete/room_incomplete.xml');
		$parser = new Parser\ParsePreferredRooms($this->log);
		$parser->parse(simplexml_load_string($xml), new \HisInOneProxy\DataModel\PlanElementPreferencePart());
		$msg = array_pop($this->collectedMessages);
		$this->assertEqualClearedString('Warning: No id given for Room, skipping!', $msg);
	}

	public function test_simpleEventDateIncompleteParsing_shouldReturnLogWarning()
	{
		$xml    = file_get_contents('test/fixtures/incomplete/event_date_incomplete.xml');
		$parser = new Parser\ParseEventDate($this->log);
		$parser->parse(simplexml_load_string($xml), new \HisInOneProxy\DataModel\PlanElement());
		$msg = array_pop($this->collectedMessages);
		$this->assertEqualClearedString('Warning: No id given for EventDate, skipping!', $msg);
	}

	public function test_simplePlannedDateIncompleteParsing_shouldReturnLogWarning()
	{
		$xml    = file_get_contents('test/fixtures/incomplete/planned_date_incomplete.xml');
		$parser = new Parser\ParsePlannedDate($this->log);
		$parser->parse(simplexml_load_string($xml), new \HisInOneProxy\DataModel\PlanElement());
		$msg = array_pop($this->collectedMessages);
		$this->assertEqualClearedString('Warning: No id given for PlannedDate, skipping!', $msg);
	}

	public function test_simplePersonPlanElementIncompleteParsing_shouldReturnLogWarning()
	{
		$xml    = file_get_contents('test/fixtures/incomplete/person_plan_element_incomplete.xml');
		$parser = new Parser\ParsePersonPlanElement($this->log);
		$parser->parse(simplexml_load_string($xml), new \HisInOneProxy\DataModel\PlanElement());
		$msg = array_pop($this->collectedMessages);
		$this->assertEqualClearedString('Warning: No id given for PersonPlanElement, skipping!', $msg);
	}

	public function test_simpleIndividualDateIncompleteParsing_shouldReturnLogWarning()
	{
		$xml    = file_get_contents('test/fixtures/incomplete/individual_date_incomplete.xml');
		$parser = new Parser\ParseIndividualDates($this->log);
		$parser->parse(simplexml_load_string($xml), new \HisInOneProxy\DataModel\PlannedDate());
		$msg = array_pop($this->collectedMessages);
		$this->assertEqualClearedString('Warning: No id given for IndividualDate, skipping!', $msg);
	}

	public function test_simpleInstructorIncompleteParsing_shouldReturnLogWarning()
	{
		$xml    = file_get_contents('test/fixtures/incomplete/instructor_incomplete.xml');
		$parser = new Parser\ParseInstructors($this->log);
		$parser->parse(simplexml_load_string($xml), new \HisInOneProxy\DataModel\PlannedDate());
		$msg = array_pop($this->collectedMessages);
		$this->assertEqualClearedString('Warning: No id given for Instructor, skipping!', $msg);
	}

	public function test_simplePlanElementCancellationIncompleteParsing_shouldReturnLogWarning()
	{
		$xml    = file_get_contents('test/fixtures/incomplete/plan_element_cancellation_incomplete.xml');
		$parser = new Parser\ParsePlanElementCancellation($this->log);
		$parser->parse(simplexml_load_string($xml), new \HisInOneProxy\DataModel\PlannedDate());
		$msg = array_pop($this->collectedMessages);
		$this->assertEqualClearedString('Warning: No id given for PlanElementCancellation, skipping!', $msg);
	}

	public function test_simplePlanElementChangeIncompleteParsing_shouldReturnLogWarning()
	{
		$xml    = file_get_contents('test/fixtures/incomplete/plan_element_change_incomplete.xml');
		$parser = new Parser\ParsePlanElementChanges($this->log);
		$parser->parse(simplexml_load_string($xml), new \HisInOneProxy\DataModel\PlannedDate());
		$msg = array_pop($this->collectedMessages);
		$this->assertEqualClearedString('Warning: No id given for PlanElementChange, skipping!', $msg);
	}

	public function test_simpleTimePreferencesIncompleteParsing_shouldReturnLogWarning()
	{
		$xml    = file_get_contents('test/fixtures/incomplete/time_preference_incomplete.xml');
		$parser = new Parser\ParseTimePreferences($this->log);
		$parser->parse(simplexml_load_string($xml), new \HisInOneProxy\DataModel\PlanningPreference());
		$msg = array_pop($this->collectedMessages);
		$this->assertEqualClearedString('Warning: No id given for TimePreference, skipping!', $msg);
	}

	public function test_simpleTimeSlotIncompleteParsing_shouldReturnLogWarning()
	{
		$xml    = file_get_contents('test/fixtures/incomplete/time_slot_incomplete.xml');
		$parser = new Parser\ParseTimeSlot($this->log);
		$parser->parse(simplexml_load_string($xml));
		$msg = array_pop($this->collectedMessages);
		$this->assertEqualClearedString('Warning: No id given for TimeSlot, skipping!', $msg);
	}

}