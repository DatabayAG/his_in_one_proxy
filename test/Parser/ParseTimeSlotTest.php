<?php

include_once './libs/composer/vendor/autoload.php';

use  HisInOneProxy\Parser;

require_once 'test/TestCaseExtension.php';

class ParseTimeSlotTest extends TestCaseExtension
{
	protected function setUp()
	{
		parent::setUp();
	}

	public function test_simpleIncompleteParsing_shouldReturnLogWarning()
	{
		$xml    = file_get_contents('test/fixtures/incomplete/time_slot_incomplete.xml');
		$parser = new Parser\ParseTimeSlot($this->log);
		$parser->parse(simplexml_load_string($xml));
		$msg = array_pop($this->collectedMessages);
		$this->assertEquals('Warning: No id given for TimeSlot, skipping!', $msg);
	}

	public function test_simplePersonPlanElementParsing_shouldReturnPersonPlanElement()
	{
		$xml    = file_get_contents('test/fixtures/time_slot.xml');
		$parser = new Parser\ParseTimeSlot($this->log);
		$time_slot = $parser->parse(simplexml_load_string($xml));
		$this->assertEquals('3213', $time_slot->getId());
		$msg = array_pop($this->collectedMessages);
		$this->assertEquals('Info: Found TimeSlot with id 3213.', $msg);
		$this->assertEquals('32432-45324-23-432-4-23', $time_slot->getObjGuid());
		$this->assertEquals('1', $time_slot->getLockVersion());
		$this->assertEquals('12:45', $time_slot->getStartTime());
		$this->assertEquals('15:01', $time_slot->getEndTime());
		$this->assertEquals('2', $time_slot->getWeekDay());
	}


}