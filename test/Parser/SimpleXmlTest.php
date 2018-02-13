<?php
include_once './libs/composer/vendor/autoload.php';

use HisInOneProxy\Parser;

require_once 'test/TestCaseExtension.php';

/**
 * Class SimpleXmlTest
 */
class SimpleXmlTest extends TestCaseExtension
{
	/**
	 * @var Parser\SimpleXmlParser $instance
	 */
	protected $instance;
	
	protected function setUp()
	{
		parent::setUp();
		$this->instance = new Parser\SimpleXmlParser($this->log);
	}

	public function test_instantiateObject_shouldReturnInstance()
	{

		$this->assertInstanceOf('HisInOneProxy\Parser\SimpleXmlParser', $this->instance);
	}

	public function test_doesAttributeExist_shouldReturnInstance()
	{
		$xml = simplexml_load_string('<res><xml></xml></res>');
		$val = $this->instance->doesAttributeExist($xml, 'xml');
		$this->assertTrue($val);
		$val = $this->instance->doesAttributeExist($xml, 'xml2');
		$this->assertFalse($val);
	}
	
	public function test_isAttributeValid_shouldReturnInstance()
	{
		$xml = simplexml_load_string('<res><xml>asdsad</xml></res>');
		$val = $this->instance->isAttributeValid($xml, 'xml');
		$this->assertTrue($val);
	}

	public function test_isAttributeNotNull_shouldReturnInstance()
	{
		$xml = simplexml_load_string('<res><xml>Blalubb</xml></res>');
		$val = $this->callMethod($this->instance, 'isAttributeNotNull', array($xml, 'xml'));
		$this->assertTrue($val);
	}

	public function test_isAttributeNotEmpty_shouldReturnInstance()
	{
		$xml = simplexml_load_string('<res><xml>Blalubb</xml></res>');
		$val = $this->callMethod($this->instance, 'isAttributeNotEmpty', array($xml, 'xml'));
		$this->assertTrue($val);
		$xml = simplexml_load_string('<res><xml></xml></res>');
		$val = $this->callMethod($this->instance, 'isAttributeNotEmpty', array($xml, 'xml'));
		$this->assertFalse($val);
	}

	public function test_doesMoreThanOneElementExists_shouldReturnInstance()
	{
		$xml = simplexml_load_string('<res><bla></bla><bla></bla></res>');
		$val = $this->callMethod($this->instance, 'doesAttributeExist', array($xml, 'bla'));
		$this->assertTrue($val);
		$xml = simplexml_load_string('<res><xml>Blalubb</xml></res>');
		$val = $this->callMethod($this->instance, 'doesAttributeExist', array($xml, 'xml2'));
		$this->assertFalse($val);
	}

	public function test_isAttributeValidAsContainer_shouldReturnInstance()
	{
		$xml = simplexml_load_string('<res><xml>Blalubb</xml></res>');
		$val = $this->instance->isAttributeValidAsContainer($xml, 'xml');
		$this->assertTrue($val);
	}

	public function test_doesExactlyOneElementExists_shouldReturnInstance()
	{
		$xml = simplexml_load_string('<res><xml>Blalubb</xml></res>');
		$val = $this->instance->doesExactlyOneElementExists($xml, 'xml');
		$this->assertTrue($val);
	}
}