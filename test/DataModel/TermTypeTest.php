<?php
require_once './libs/composer/vendor/autoload.php';

use  HisInOneProxy\DataModel;

class TermTypeTest extends PHPUnit\Framework\TestCase
{

	/**
	 * @var DataModel\TermType $instance
	 */
	protected $instance;

	protected function setUp()
	{
		$this->instance = new DataModel\TermType();
	}

	public function test_instantiateObject_shouldReturnInstance()
	{
		$this->assertInstanceOf('HisInOneProxy\DataModel\TermType', $this->instance);
	}

	public function test_getTermCategory_shouldReturnValue()
	{
		$this->instance->setTermCategory(22872);
		$this->assertEquals(22872, $this->instance->getTermCategory());
	}

	public function test_getTermNumber_shouldReturnValue()
	{
		$this->instance->setTermNumber(22872);
		$this->assertEquals(22872, $this->instance->getTermNumber());
	}


}