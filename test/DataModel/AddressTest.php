<?php
require_once './libs/composer/vendor/autoload.php';

use  HisInOneProxy\DataModel;

/**
 * Class AddressTest
 */
class AddressTest extends PHPUnit\Framework\TestCase
{

	/**
	 * @var DataModel\Address $instance
	 */
	protected $instance;

	protected function setUp()
	{
		$this->instance = new DataModel\Address();
	}

	public function test_instantiateObject_shouldReturnInstance()
	{
		$this->assertInstanceOf('HisInOneProxy\DataModel\Address', $this->instance);
	}

	public function test_getPostCode_shouldReturnValue()
	{
		$this->instance->setPostCode(52146);
		$this->assertEquals(52146, $this->instance->getPostCode());
	}

	public function test_getStreet_shouldReturnValue()
	{
		$this->instance->setStreet('My private way.');
		$this->assertEquals('My private way.', $this->instance->getStreet());
	}

	public function test_getCity_shouldReturnValue()
	{
		$this->instance->setCity('My private city.');
		$this->assertEquals('My private city.', $this->instance->getCity());
	}

	public function test_getAddressAddition_shouldReturnValue()
	{
		$this->instance->setAddressAddition('My little addition.');
		$this->assertEquals('My little addition.', $this->instance->getAddressAddition());
	}

	public function test_getPostBoxOffice_shouldReturnValue()
	{
		$this->instance->setPostBoxOffice('My little post office.');
		$this->assertEquals('My little post office.', $this->instance->getPostBoxOffice());
	}

	public function test_getCompany_shouldReturnValue()
	{
		$this->instance->setCompany('My lemonade stand.');
		$this->assertEquals('My lemonade stand.', $this->instance->getCompany());
	}

	public function test_getState_shouldReturnValue()
	{
		$this->instance->setState('My state');
		$this->assertEquals('My state', $this->instance->getState());
	}

	public function test_getCountryId_shouldReturnValue()
	{
		$this->instance->setCountryId(122);
		$this->assertEquals(122, $this->instance->getCountryId());
	}
}