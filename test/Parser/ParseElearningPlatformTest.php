<?php

include_once './libs/composer/vendor/autoload.php';

use HisInOneProxy\Parser;

require_once 'test/TestCaseExtension.php';

/**
 * Class ParseElearningPlatformTest
 */
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
		$this->assertEquals('55', $platform['55']->getId());
		$this->assertEquals('Bla2',  $platform['55']->getShortText());
		$this->assertEquals('My little platform',  $platform['55']->getDefaultText());
		$this->assertEquals('Loooooooooong platform text',  $platform['55']->getLongText());
		$this->assertEquals('TotallyUnique2',  $platform['55']->getUniqueName());
		$this->assertEquals('0',  $platform['55']->getSortOrder());
		$this->assertEquals('12',  $platform['55']->getLanguageId());
		$this->assertEquals('454326547637562432',  $platform['55']->getObjGuid());
		$this->assertEquals('http://there',  $platform['55']->getConnectionInfo());
		$this->assertEquals('45432654763756243',  $platform['55']->getHisKeyId());


	}
}