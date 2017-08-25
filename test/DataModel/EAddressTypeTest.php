<?php
require_once './libs/composer/vendor/autoload.php';

use  HisInOneProxy\DataModel;

class EAddressTypeTest extends PHPUnit\Framework\TestCase
{

	/**
	 * @var DataModel\EAddressType $instance
	 */
	protected $instance;

	protected function setUp()
	{
		$this->instance = new DataModel\EAddressType();
	}

	public function test_instantiateObject_shouldReturnInstance()
	{
		$this->assertInstanceOf('HisInOneProxy\DataModel\EAddressType', $this->instance);
	}

	public function test_getAddressType_shouldReturnValue()
	{
		$this->instance->setAddressType(10);
		$this->assertEquals(10, $this->instance->getAddressType());
	}
}