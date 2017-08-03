<?php

include_once './libs/composer/vendor/autoload.php';

use  HisInOneProxy\Parser;

require_once 'test/TestCaseExtension.php';

class ParseUnitIdListTest extends TestCaseExtension
{
	protected function setUp()
	{
		parent::setUp();
	}


	public function test_simpleVisibleChildren_shouldReturnVisibleChildren()
	{
		$xml      = file_get_contents('test/fixtures/unit_id_list.xml');
		$parser   = new Parser\ParseUnitIdList($this->log);
		$unit_id_list = $parser->parse(simplexml_load_string( $xml ));
		$this->assertEquals(1, $unit_id_list->getSizeOfContainer());
	}
}