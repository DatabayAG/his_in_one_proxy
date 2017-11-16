<?php

include_once './libs/composer/vendor/autoload.php';

use  HisInOneProxy\Parser;

require_once 'test/TestCaseExtension.php';

/**
 * Class ParseIndividualDateTest
 */
class ParseIndividualDateTest extends TestCaseExtension
{
	protected function setUp()
	{
		parent::setUp();
	}

	public function test_simpleUnitIncompleteParsing_shouldReturnLogWarning()
	{
		$xml    = file_get_contents('test/fixtures/incomplete/individual_dates_incomplete.xml');
		$parser = new Parser\ParseIndividualDates($this->log);
		$parser->parse(simplexml_load_string($xml), new \HisInOneProxy\DataModel\PlannedDate());
		$msg = array_pop($this->collectedMessages);
		$this->assertEquals('Warning: No id given for IndividualDate, skipping!', $msg);
	}

	public function test_simpleParseIndividualDates_shouldReturnIndividualDates()
	{
		$xml      = file_get_contents('test/fixtures/individual_dates.xml');
		$parser   = new Parser\ParseIndividualDates($this->log);
		$planned_date = new \HisInOneProxy\DataModel\PlannedDate();
		$parser->parse(simplexml_load_string($xml), $planned_date);
		$indy_date = $planned_date->getIndividualDateContainer()[0];
		$this->assertEquals('32', $indy_date->getId());
		$msg = array_pop($this->collectedMessages);
		$this->assertEquals('Info: Found IndividualDate with id 32.', $msg);
		$this->assertEquals('324324234123-34132432-41324-1234-13241', $indy_date->getObjGuid());
		$this->assertEquals('1', $indy_date->getLockVersion());
		$this->assertEquals('23', $indy_date->getPlannedDatesId());
		$this->assertEquals('22.12.2017', $indy_date->getExecutionDate());
		$this->assertEquals('8:00', $indy_date->getStartTime());
		$this->assertEquals('11:00', $indy_date->getEndTime());
		$this->assertEquals('2', $indy_date->getWeekDay());
		$this->assertEquals('23112', $indy_date->getRoomId());
	}
	

}