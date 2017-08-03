<?php

include_once './libs/composer/vendor/autoload.php';

use  HisInOneProxy\Parser;

require_once 'test/TestCaseExtension.php';

class ParseChildRelationTest extends TestCaseExtension
{

	protected function setUp()
	{
		parent::setUp();
	}

	public function test_simpleParseChildRelation_shouldReturnLogWarning()
	{
		$parser = new Parser\ParseChildRelation($this->log);
		$parser->parse(simplexml_load_string('<re><childRelation><childId></childId></childRelation></re>') );
		$msg = array_pop($this->collectedMessages);
		$this->assertEquals('Warning: No parent or child id given!', $msg);
	}

	public function test_simpleParseChildRelation_shouldReturnValue()
	{
		$xml    = file_get_contents('test/fixtures/child_relation.xml');
		$parser = new Parser\ParseChildRelation($this->log);
		$value = $parser->parse(simplexml_load_string('<re>'.$xml.'</re>') );

		$this->assertEquals('6756876', $value->getChildRelationContainer()['6756876']->getChildId());
		$this->assertEquals('1', $value->getChildRelationContainer()['6756876']->getParentId());
	}

	public function test_simpleParseChildRelation2_shouldReturnValue()
	{
		$xml    = file_get_contents('test/fixtures/child_relation_multi.xml');
		$parser = new Parser\ParseChildRelation($this->log);
		$value = $parser->parse(simplexml_load_string($xml) );

		$this->assertEquals('6756876', $value->getChildRelationContainer()['6756876']->getChildId());
		$this->assertEquals('1', $value->getChildRelationContainer()['6756876']->getParentId());
		$this->assertEquals('324532', $value->getChildRelationContainer()['324532']->getChildId());
		$this->assertEquals('2', $value->getChildRelationContainer()['324532']->getParentId());
	}
}