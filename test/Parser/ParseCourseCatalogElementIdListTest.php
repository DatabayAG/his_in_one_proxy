<?php

include_once './libs/composer/vendor/autoload.php';

use  HisInOneProxy\Parser;

require_once 'test/TestCaseExtension.php';

/**
 * Class ParseCourseCatalogElementIdListTest
 */
class ParseCourseCatalogElementIdListTest extends TestCaseExtension
{
	protected function setUp()
	{
		parent::setUp();
	}


	public function test_simpleVisibleChildren_shouldReturnVisibleChildren()
	{
		$xml      = file_get_contents('test/fixtures/course_catalog_element_id_list.xml');
		$parser   = new Parser\ParseCourseCatalogElementIdList($this->log);
		$unit_id_list = $parser->parse(simplexml_load_string( $xml ));
		$this->assertEquals(2, $unit_id_list->getSizeOfContainer());
		$this->assertEquals('Warning: No id given for course catalog element, skipping!', array_pop($this->collectedMessages));
		$this->assertEquals('Info: Found course catalog element id 12.', array_pop($this->collectedMessages));
		$this->assertEquals('Info: Found course catalog element id 22.', array_pop($this->collectedMessages));
		$this->assertEquals('Info: Found course catalog element id 12.', array_pop($this->collectedMessages));
	}
}