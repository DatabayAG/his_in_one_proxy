<?php
require_once './libs/composer/vendor/autoload.php';

use  HisInOneProxy\DataModel;

/**
 * Class ElectronicAddressTest
 */
class ElectronicAddressTest extends PHPUnit\Framework\TestCase
{

	/**
	 * @var DataModel\ElectronicAddress $instance
	 */
	protected $instance;

	protected function setUp()
	{
		$this->instance = new DataModel\ElectronicAddress();
	}

	public function test_instantiateObject_shouldReturnInstance()
	{
		$this->assertInstanceOf('HisInOneProxy\DataModel\Address', $this->instance);
	}

	public function test_getEAddressTypeId_shouldReturnValue()
	{
		$this->instance->setEAddressTypeId(522146);
		$this->assertEquals(522146, $this->instance->getEAddressTypeId());
	}

	public function test_getEAddress_shouldReturnValue()
	{
		$this->instance->setEAddress('My e_address way.');
		$this->assertEquals('My e_address way.', $this->instance->getEAddress());
	}
}