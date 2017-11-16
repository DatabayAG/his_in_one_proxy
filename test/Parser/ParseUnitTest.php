<?php

include_once './libs/composer/vendor/autoload.php';

use  HisInOneProxy\Parser;

require_once 'test/TestCaseExtension.php';

/**
 * Class ParseUnitTest
 */
class ParseUnitTest extends TestCaseExtension
{
	protected function setUp()
	{
		parent::setUp();
	}

	public function test_simpleUnitIncompleteParsing_shouldReturnLogWarning()
	{
		$xml    = file_get_contents('test/fixtures/incomplete/unit_incomplete.xml');
		$parser = new Parser\ParseUnit($this->log);
		$parser->parse(simplexml_load_string($xml));
		$msg = array_pop($this->collectedMessages);
		$this->assertEquals('Warning: No id given for Unit, skipping!', $msg);
	}

	public function test_simpleOrgUnitParsing_shouldReturnOrgUnit()
	{
		$xml      = file_get_contents('test/fixtures/unit.xml');
		$parser   = new Parser\ParseUnit($this->log);
		$org_unit = $parser->parse(simplexml_load_string($xml));
		$this->assertEquals('55', $org_unit->getId());
		$this->assertEquals('553123124343245', $org_unit->getObjGuid());
		$this->assertEquals('2', $org_unit->getLockVersion());
		$this->assertEquals('de', $org_unit->getDefaultLanguage());
		$this->assertEquals('4', $org_unit->getElementNr());
		$this->assertEquals('2', $org_unit->getElementTypeId());
		$this->assertEquals('My short text.', $org_unit->getShortText());
		$this->assertEquals('My default text.', $org_unit->getDefaultText());
		$this->assertEquals('My not so looooooong text.', $org_unit->getLongText());
	}

	public function test_simpleHisOrgUnitParsing_shouldReturnOrgUnit()
	{
		$xml      = file_get_contents('test/fixtures/his_unit_simple.xml');
		$parser   = new Parser\ParseUnit($this->log);
		$org_unit = $parser->parse(simplexml_load_string($xml));
		$this->assertEquals('1', $org_unit->getId());
		$msg = array_pop($this->collectedMessages);
		$this->assertEquals('Info: Found Unit with id 1.', $msg);
		$this->assertEquals('1', $org_unit->getId());
		$this->assertEquals('551d42d9-731f-4c42-83f3-fa2ef20a8564', $org_unit->getObjGuid());
		$this->assertEquals('7', $org_unit->getLockVersion());
		$this->assertEquals('12', $org_unit->getDefaultLanguage());
		$this->assertEquals('1', $org_unit->getElementNr());
		$this->assertEquals('7', $org_unit->getElementTypeId());
		$this->assertEquals('HZB', $org_unit->getShortText());
		$this->assertEquals('HZB', $org_unit->getDefaultText());
		$this->assertEquals('HZB', $org_unit->getLongText());
	}
}