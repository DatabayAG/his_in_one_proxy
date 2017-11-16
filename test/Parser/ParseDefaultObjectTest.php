<?php

include_once './libs/composer/vendor/autoload.php';

use HisInOneProxy\Parser;

require_once 'test/TestCaseExtension.php';

/**
 * Class ParseDefaultObjectTest
 */
class ParseDefaultObjectTest  extends TestCaseExtension{

	/**
	 * @var Parser\ParseDefaultObject $instance
	 */
	protected $instance;
	
	protected function setUp()
	{
		$this->instance = new Parser\ParseDefaultObject($this->log);
		parent::setUp();
	}

	public function test_parse_shouldReturnAddress()
	{
		$xml      = file_get_contents('test/fixtures/default_object.xml');

		$this->instance->setListValue('myList');
		$this->instance->setTagValue('myAttribute');
		$default_object = $this->instance->parse(simplexml_load_string('<res>' . $xml . '</res>'));
		$this->assertEquals('23412', $default_object['23412']->getId());
		$this->assertEquals('MyName', $default_object['23412']->getUniqueName());
		$this->assertEquals('f', $default_object['23412']->getShortText());
		$this->assertEquals('My Name', $default_object['23412']->getDefaultText());
		$this->assertEquals('My Long Name', $default_object['23412']->getLongText());
		$this->assertEquals('0', $default_object['23412']->getSortOrder());
		$this->assertEquals('12', $default_object['23412']->getDefaultLanguage());
		$this->assertEquals('43523534643523432', $default_object['23412']->getObjGuid());
		$this->assertEquals('31', $default_object['23412']->getHisKeyId());
	}

	public function test_parse2_shouldReturnAddress()
	{
		$string = '<res><myList><myAttribute><id>23435</id></myAttribute><myAttribute><id>23436</id></myAttribute></myList></res>';

		$this->instance->setListValue('myList');
		$this->instance->setTagValue('myAttribute');
		$address = $this->instance->parse(simplexml_load_string($string));
		$this->assertEquals('23435', $address['23435']->getId());
		$this->assertEquals('23436', $address['23436']->getId());
	}
}