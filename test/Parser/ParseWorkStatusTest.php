<?php

include_once './libs/composer/vendor/autoload.php';

use HisInOneProxy\Parser;

require_once 'test/TestCaseExtension.php';

/**
 * Class ParseWorkStatusTest
 */
class ParseWorkStatusTest  extends TestCaseExtension{

	/**
	 * @var Parser\ParseWorkStatus $instance
	 */
	protected $instance;
	
	protected function setUp()
	{
		parent::setUp();
		$this->instance = new Parser\ParseWorkStatus($this->log);
	}

	public function test_parse_shouldReturnWorkStatusContainer()
	{
		$xml      = file_get_contents('test/fixtures/work_status_value.xml');

		$work = $this->instance->parse(simplexml_load_string('<res>' . $xml . '</res>'));

		$work = $work->getWorkStatusContainer();
		$this->assertEquals('23', $work['23']->getId());
		$this->assertEquals('Bla', $work['23']->getShortText());
		$this->assertEquals('My little workstatus', $work['23']->getDefaultText());
		$this->assertEquals('Loooooooooong Workstatus text', $work['23']->getLongText());
		$this->assertEquals('TotallyUnique', $work['23']->getUniqueName());
		$this->assertEquals('0', $work['23']->getSortOrder());
		$this->assertEquals('12', $work['23']->getLanguageId());
		$this->assertEquals('45432654763756243', $work['23']->getObjGuid());

	}
}