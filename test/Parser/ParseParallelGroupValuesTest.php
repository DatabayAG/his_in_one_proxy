<?php

include_once './libs/composer/vendor/autoload.php';

use HisInOneProxy\Parser;

require_once 'test/TestCaseExtension.php';

class ParseParallelGroupValuesTest  extends TestCaseExtension{

	/**
	 * @var Parser\ParseParallelGroupValues $instance
	 */
	protected $instance;
	
	protected function setUp()
	{
		parent::setUp();
		$this->instance = new Parser\ParseParallelGroupValues($this->log);
	}

	public function test_parse_shouldReturnCurrentTerm()
	{
		$xml      = file_get_contents('test/fixtures/parallel_group_value.xml');

		$cont = $this->instance->parse(simplexml_load_string('<res>' . $xml . '</res>'));
		$value = $cont->getParallelGroupValueContainer();
		$this->assertEquals('342', $value['342']->getId());
		$this->assertEquals('Bla2',  $value['342']->getShortText());
		$this->assertEquals('My little value',  $value['342']->getDefaultText());
		$this->assertEquals('Loooooooooong value text',  $value['342']->getLongText());
		$this->assertEquals('TotallyUnique2',  $value['342']->getUniqueName());
		$this->assertEquals('0',  $value['342']->getSortOrder());
		$this->assertEquals('12',  $value['342']->getLanguageId());
		$this->assertEquals('454326547637562432',  $value['342']->getObjGuid());
	
	}
}