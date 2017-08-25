<?php
require_once './libs/composer/vendor/autoload.php';

use  HisInOneProxy\DataModel;

class CompleteAccountTest extends PHPUnit\Framework\TestCase
{

	/**
	 * @var DataModel\CompleteAccount $instance
	 */
	protected $instance;

	protected function setUp()
	{
		$this->instance = new DataModel\CompleteAccount();
	}

	public function test_instantiateObject_shouldReturnInstance()
	{
		$this->assertInstanceOf('HisInOneProxy\DataModel\CompleteAccount', $this->instance);
	}

	public function test_getPersonId_shouldReturnValue()
	{
		$this->instance->setPersonId(52146);
		$this->assertEquals(52146, $this->instance->getPersonId());
	}

	public function test_getId_shouldReturnValue()
	{
		$this->instance->setId(768576);
		$this->assertEquals(768576, $this->instance->getId());
	}

	public function test_getUserName_shouldReturnValue()
	{
		$this->instance->setUserName('MyUsername');
		$this->assertEquals('MyUsername', $this->instance->getUserName());
	}

	public function test_getAccountAuthId_shouldReturnValue()
	{
		$this->instance->setAccountAuthId(64);
		$this->assertEquals(64, $this->instance->getAccountAuthId());
	}

	public function test_getExternalSystemId_shouldReturnValue()
	{
		$this->instance->setExternalSystemId(98);
		$this->assertEquals(98, $this->instance->getExternalSystemId());
	}

	public function test_getAuthInfo_shouldReturnValue()
	{
		$this->instance->setAuthInfo('My lemonade stand.');
		$this->assertEquals('My lemonade stand.', $this->instance->getAuthInfo());
	}

	public function test_isLdapAccount_shouldReturnValue()
	{
		$this->instance->setIsLdapAccount(1);
		$this->assertEquals(1, $this->instance->isLdapAccount());
	}

	public function test_getPurposeId_shouldReturnValue()
	{
		$this->instance->setPurposeId(122);
		$this->assertEquals(122, $this->instance->getPurposeId());
	}
}