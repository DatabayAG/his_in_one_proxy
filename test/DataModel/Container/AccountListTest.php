<?php
require_once './libs/composer/vendor/autoload.php';

use  HisInOneProxy\DataModel;

/**
 * Class AccountListTest
 */
class AccountListTest extends PHPUnit\Framework\TestCase
{

	/**
	 * @var DataModel\Container\AccountList
	 */
	protected $instance;

	protected function setUp()
	{
		$this->instance = new DataModel\Container\AccountList();
	}

	public function test_instantiateObject_shouldReturnInstance()
	{
		$this->assertInstanceOf('HisInOneProxy\DataModel\Container\AccountList', $this->instance);
	}

	public function test_getAccountList_shouldReturnAccountList()
	{
		$child = new \HisInOneProxy\DataModel\CompleteAccount();
		$child->setId(2);
		$this->instance->appendAccount($child);
		$this->assertEquals(1, count($this->instance->getAccountContainer()));
		$child = new \HisInOneProxy\DataModel\CompleteAccount();
		$child->setId(4);
		$this->instance->appendAccount($child);
		$this->assertEquals(2, $this->instance->getSizeOfContainer());
	}

	public function test_getAccount_shouldReturnAccount()
	{
		$this->instance = new DataModel\Container\AccountList();
		$child = new \HisInOneProxy\DataModel\CompleteAccount();
		$child->setId(2);
		$this->instance->appendAccount($child);
		foreach($this->instance->getAccount() as $account)
		{
			$this->assertEquals(2, $account->getId());
		}

	}

}