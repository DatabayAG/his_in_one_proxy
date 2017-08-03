<?php

include_once './libs/composer/vendor/autoload.php';

use  HisInOneProxy\Parser;

require_once 'test/TestCaseExtension.php';

class ParseTermTypeTest extends TestCaseExtension
{
	protected function setUp()
	{
		parent::setUp();
	}

	public function test_simpleIncompleteParsing_shouldReturnLogWarning()
	{
		$xml    = file_get_contents('test/fixtures/incomplete/term_type_incomplete.xml');
		$parser = new Parser\ParseTermType($this->log);
		$parser->parse(simplexml_load_string($xml));
		$msg = array_pop($this->collectedMessages);
		$this->assertEquals('Warning: No id given for TermType, skipping!', $msg);
	}

	public function test_simplePersonPlanElementParsing_shouldReturnPersonPlanElement()
	{
		$xml    = file_get_contents('test/fixtures/term_type.xml');
		$parser =  new Parser\ParseTermType($this->log);
		$term_type = $parser->parse(simplexml_load_string($xml));
		$this->assertEquals('432423', $term_type->getId());
		$msg = array_pop($this->collectedMessages);
		$this->assertEquals('Info: Found TermType with id 432423.', $msg);
		$this->assertEquals('4324-234-234-23-4-23', $term_type->getObjGuid());
		$this->assertEquals('Text', $term_type->getDefaultText());
		$this->assertEquals('Langer Text', $term_type->getLongText());
		$this->assertEquals('txt', $term_type->getShortText());
		$this->assertEquals('UniqueName', $term_type->getUniqueName());
		$this->assertEquals('4', $term_type->getSortOrder());
		$this->assertEquals('2', $term_type->getLanguageId());
		$this->assertEquals('43', $term_type->getTermCategory());
		$this->assertEquals('1', $term_type->getTermNumber());
	}


}