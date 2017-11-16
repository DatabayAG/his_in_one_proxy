<?php

include_once './libs/composer/vendor/autoload.php';

use HisInOneProxy\Parser;

require_once 'test/TestCaseExtension.php';

/**
 * Class ParseCurrentTermTest
 */
class ParseCurrentTermTest  extends TestCaseExtension{

	/**
	 * @var Parser\ParseCurrentTerm $instance
	 */
	protected $instance;
	
	protected function setUp()
	{
		parent::setUp();
		$this->instance = new Parser\ParseCurrentTerm($this->log);
	}

	public function test_parse_shouldReturnCurrentTerm()
	{
		$xml      = file_get_contents('test/fixtures/current_term.xml');

		$term = $this->instance->parse(simplexml_load_string($xml));
		$this->assertEquals('2017', $term->getYear());
		$this->assertEquals('Text 2', $term->getDefaultText());
		$this->assertEquals('Text 4', $term->getLongText());
		$this->assertEquals('Text 3', $term->getShortText());
		$this->assertEquals('543', $term->getTermNumber());
	
	}
}