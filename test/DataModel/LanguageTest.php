<?php
require_once './libs/composer/vendor/autoload.php';

use  HisInOneProxy\DataModel;

/**
 * Class LanguageTest
 */
class LanguageTest extends PHPUnit\Framework\TestCase
{

	/**
	 * @var DataModel\Language $instance
	 */
	protected $instance;

	protected function setUp()
	{
		$this->instance = new DataModel\Language();
	}

	public function test_instantiateObject_shouldReturnInstance()
	{
		$this->assertInstanceOf('HisInOneProxy\DataModel\Language', $this->instance);
	}

	public function test_getId_shouldReturnId()
	{
		$this->instance->setId(2);
		$this->assertEquals(2, $this->instance->getId());
	}

	public function test_getIso6391_shouldReturnValue()
	{
		$this->instance->setIso6391('en');
		$this->assertEquals('en', $this->instance->getIso6391());
	}

	public function test_getIso6392_shouldReturnValue()
	{
		$this->instance->setIso6392('eng');
		$this->assertEquals('eng', $this->instance->getIso6392());
	}

	
}