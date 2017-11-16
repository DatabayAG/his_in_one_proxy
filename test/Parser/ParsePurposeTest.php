<?php

include_once './libs/composer/vendor/autoload.php';

use HisInOneProxy\Parser;

require_once 'test/TestCaseExtension.php';

/**
 * Class ParsePurposeTest
 */
class ParsePurposeTest  extends TestCaseExtension{

	/**
	 * @var Parser\ParsePurposeList $instance
	 */
	protected $instance;
	
	protected function setUp()
	{
		$this->instance = new Parser\ParsePurposeList($this->log);
		parent::setUp();
	}

	public function test_parse_shouldReturnAddress()
	{
		$xml      = file_get_contents('test/fixtures/purpose.xml');

		$purpose = $this->instance->parse(simplexml_load_string('<res>' . $xml . '</res>'));

		$this->assertEquals('23412', $purpose[23412]->getId());
		$this->assertEquals('MyName', $purpose[23412]->getUniqueName());
		$this->assertEquals('f', $purpose[23412]->getShortText());
		$this->assertEquals('My Name', $purpose[23412]->getDefaultText());
		$this->assertEquals('My Long Name', $purpose[23412]->getLongText());
		$this->assertEquals('0', $purpose[23412]->getSortOrder());
		$this->assertEquals('12', $purpose[23412]->getDefaultLanguage());
		$this->assertEquals('43523534643523432', $purpose[23412]->getObjGuid());
		$this->assertEquals('10', $purpose[23412]->getObjectType());
		$this->assertEquals('31', $purpose[23412]->getHisKeyId());
	}

	public function test_parse2_shouldReturnAddress()
	{
		$string = '<res><listOfPurposes><purposevalue><id>23435</id></purposevalue><purposevalue><id>23436</id></purposevalue></listOfPurposes></res>';
		$address = $this->instance->parse(simplexml_load_string($string));
		$this->assertEquals('23435', $address[23435]->getId());
		$this->assertEquals('23436', $address[23436]->getId());
	}
}