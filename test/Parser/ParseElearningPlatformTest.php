<?php

include_once './libs/composer/vendor/autoload.php';

use HisInOneProxy\Parser;

require_once 'test/TestCaseExtension.php';

class ParseElearningPlatformTest  extends TestCaseExtension{

	/**
	 * @var Parser\ParseElearningPlatform $instance
	 */
	protected $instance;
	
	protected function setUp()
	{
		parent::setUp();
		$this->instance = new Parser\ParseElearningPlatform($this->log);
	}

	public function test_parse_shouldReturnWorkStatusContainer()
	{
		$xml      = file_get_contents('test/fixtures/elearning_platform.xml');

		$cont = $this->instance->parse(simplexml_load_string('<res>' . $xml . '</res>'));
		$platform = $cont->getElearningPlatformContainer();
		$this->assertEquals('232', $platform['232']->getId());
		$this->assertEquals('Bla2',  $platform['232']->getShortText());
		$this->assertEquals('My little platform',  $platform['232']->getDefaultText());
		$this->assertEquals('Loooooooooong platform text',  $platform['232']->getLongText());
		$this->assertEquals('TotallyUnique2',  $platform['232']->getUniqueName());
		$this->assertEquals('0',  $platform['232']->getSortOrder());
		$this->assertEquals('12',  $platform['232']->getLanguageId());
		$this->assertEquals('454326547637562432',  $platform['232']->getObjGuid());
		$this->assertEquals('http://there',  $platform['232']->getConnectionInfo());
		$this->assertEquals('45432654763756243',  $platform['232']->getHisKeyId());


	}
}