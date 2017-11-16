<?php

include_once './libs/composer/vendor/autoload.php';

require_once 'test/TestCaseExtension.php';

use HisInOneProxy\Parser;

/**
 * Class ParseCourseCatalogChildrenTest
 */
class ParseCourseCatalogChildrenTest extends TestCaseExtension
{
	protected function setUp()
	{
		parent::setUp();
	}

	public function test_simpleCourseCatalogChildIncompleteParsing_shouldReturnLogWarning()
	{
		$parser = new Parser\ParseCourseCatalogChildren($this->log);
		$leaf = new \HisInOneProxy\DataModel\CourseCatalogLeaf();
		$parser->parse(simplexml_load_string('<list></list>'), $leaf);
		$msg = array_pop($this->collectedMessages);
		$this->assertEquals('Warning: No children given for CourseCatalogChildren, skipping!', $msg);
	}

	public function test_simpleCourseCatalogChildIllegalTypeParsing_shouldReturnLogWarning()
	{
		$xml    = file_get_contents('test/fixtures/incomplete/course_catalog_children_illegal_type.xml');
		$parser = new Parser\ParseCourseCatalogChildren($this->log);
		$leaf = new \HisInOneProxy\DataModel\CourseCatalogLeaf();
		$parser->parse(simplexml_load_string($xml), $leaf);
		$msg = array_pop($this->collectedMessages);
		$this->assertEquals('Warning: Type: My type is not valid, skipping!', $msg);
		$msg = array_pop($this->collectedMessages);
		$this->assertEquals('Info: Found CourseCatalogChild with id 6756876.', $msg);
	}

	public function test_simpleCourseCatalogChild_shouldReturnCourseCatalogChild()
	{
		$xml      = file_get_contents('test/fixtures/course_catalog_children.xml');
		$parser   = new Parser\ParseCourseCatalogChildren($this->log);
		$leaf = new \HisInOneProxy\DataModel\CourseCatalogLeaf();
		$parser->parse(simplexml_load_string($xml), $leaf);
		$this->assertEquals(3, count($leaf->getChildren()));
		$child = $leaf->getChildren()['6756876'];
		$this->assertEquals('6756876', $child->getCourseCatalogId());
		$msg = array_pop($this->collectedMessages);
		$this->assertEquals('Info: Found CourseCatalogChild with id 5555.', $msg);
		$msg = array_pop($this->collectedMessages);
		$this->assertEquals('Info: Found CourseCatalogChild with id 33334.', $msg);
		$msg = array_pop($this->collectedMessages);
		$this->assertEquals('Info: Found CourseCatalogChild with id 6756876.', $msg);

		$this->assertEquals('courseCatalog', $leaf->getChildren()['6756876']->getType());
		$this->assertEquals('0', $leaf->getChildren()['6756876']->getSortOrder());
		$this->assertEquals('6756876', $leaf->getChildren()['6756876']->getCourseCatalogId());

		$this->assertEquals('planelement', $leaf->getChildren()['33334']->getType());
		$this->assertEquals('1', $leaf->getChildren()['33334']->getSortOrder());
		$this->assertEquals('33334', $leaf->getChildren()['33334']->getCourseCatalogId());

		$this->assertEquals('unit', $leaf->getChildren()['5555']->getType());
		$this->assertEquals('1', $leaf->getChildren()['5555']->getSortOrder());
		$this->assertEquals('5555', $leaf->getChildren()['5555']->getCourseCatalogId());
	}

}