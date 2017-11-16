<?php
require_once './libs/composer/vendor/autoload.php';

use  HisInOneProxy\DataModel;

/**
 * Class GenderTest
 */
class GenderTest extends PHPUnit\Framework\TestCase
{

	/**
	 * @var DataModel\Gender $instance
	 */
	protected $instance;

	protected function setUp()
	{
		$this->instance = new DataModel\Gender();
	}

	public function test_instantiateObject_shouldReturnInstance()
	{
		$this->assertInstanceOf('HisInOneProxy\DataModel\Gender', $this->instance);
	}

	public function test_getId_shouldReturnId()
	{
		$this->instance->setId(12);
		$this->assertEquals(12, $this->instance->getId());
	}

	public function test_getLetterSalutation_shouldReturnValue()
	{
		$this->instance->setLetterSalutation('Sehr geehrte Frau');
		$this->assertEquals('Sehr geehrte Frau', $this->instance->getLetterSalutation());
	}

	public function test_getFormOfAddress_shouldReturnValue()
	{
		$this->instance->setFormOfAddress('Herr');
		$this->assertEquals('Herr', $this->instance->getFormOfAddress());
	}

}