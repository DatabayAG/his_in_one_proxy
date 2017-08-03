<?php

include_once './libs/composer/vendor/autoload.php';

use  HisInOneProxy\Parser;

require_once 'test/TestCaseExtension.php';

class ParseVisibleChildrenTest extends TestCaseExtension
{
	protected function setUp()
	{
		parent::setUp();
	}

	public function test_simpleVisibleChildrenIncompleteParsing_shouldReturnLogWarning()
	{
		$xml    = file_get_contents('test/fixtures/incomplete/visible_children_incomplete.xml');
		$parser = new Parser\ParseVisibleChildren($this->log);
		$parser->parse(simplexml_load_string('<resp>' . $xml .'</resp>') );
		$msg = array_pop($this->collectedMessages);
		$this->assertEquals('Warning: No id given for VisibleChild, skipping!', $msg);
	}

	public function test_simpleVisibleChildren_shouldReturnVisibleChildren()
	{
		$xml      = file_get_contents('test/fixtures/visible_children.xml');
		$parser   = new Parser\ParseVisibleChildren($this->log);
		$visible_child = $parser->parse(simplexml_load_string('<resp>' . $xml .'</resp>'));
		$this->assertEquals(1, count($visible_child));
		$this->assertEquals('435', $visible_child[435]->getUnitId());
		$msg = array_pop($this->collectedMessages);
		$this->assertEquals('Info: Found VisibleChild with id 435.', $msg);
		$this->assertEquals('56', $visible_child[435]->getRelationTypeId());
		$this->assertEquals('dsafdag', $visible_child[435]->getChildDefaultText());
		$this->assertEquals('4', $visible_child[435]->getChildElements());
		$this->assertEquals('1234', $visible_child[435]->getParentUnitId());
	}
}