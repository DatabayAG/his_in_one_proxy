<?php

include_once './libs/composer/vendor/autoload.php';

use HisInOneProxy\Parser;

require_once 'test/TestCaseExtension.php';

/**
 * Class ParseEAddressTagTest
 */
class ParseEAddressTagTest  extends TestCaseExtension{

	/**
	 * @var Parser\ParseEAddressTag $instance
	 */
	protected $instance;
	
	protected function setUp()
	{
		$this->instance = new Parser\ParseEAddressTag($this->log);
		parent::setUp();
	}

	public function test_parse_shouldReturnAddress()
	{
		$xml      = file_get_contents('test/fixtures/e_address_tag.xml');

		$address = $this->instance->parse(simplexml_load_string('<res>' . $xml . '</res>'));

		$this->assertEquals('23412', $address[23412]->getId());
		$this->assertEquals('MyName', $address[23412]->getUniqueName());
		$this->assertEquals('f', $address[23412]->getShortText());
		$this->assertEquals('My Name', $address[23412]->getDefaultText());
		$this->assertEquals('My Long Name', $address[23412]->getLongText());
		$this->assertEquals('0', $address[23412]->getSortOrder());
		$this->assertEquals('12', $address[23412]->getDefaultLanguage());
		$this->assertEquals('43523534643523432', $address[23412]->getObjGuid());
	}

	public function test_parse2_shouldReturnAddress()
	{
		$string = '<res><listOfEAddresstags><eaddresstagvalue><id>23435</id></eaddresstagvalue><eaddresstagvalue><id>23436</id></eaddresstagvalue></listOfEAddresstags></res>';
		$address = $this->instance->parse(simplexml_load_string($string));
		$this->assertEquals('23435', $address[23435]->getId());
		$this->assertEquals('23436', $address[23436]->getId());
	}
}