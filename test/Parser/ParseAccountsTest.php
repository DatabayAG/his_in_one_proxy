<?php

include_once './libs/composer/vendor/autoload.php';

use HisInOneProxy\Parser;

require_once 'test/TestCaseExtension.php';

/**
 * Class ParseAccountsTest
 */
class ParseAccountsTest  extends TestCaseExtension{

	/**
	 * @var Parser\ParseAccounts $instance
	 */
	protected $instance;
	
	protected function setUp()
	{
		$this->instance = new Parser\ParseAccounts($this->log);
		parent::setUp();
	}

	public function test_parse_shouldReturnAccount()
	{
		$xml      = file_get_contents('test/fixtures/account.xml');

		$account = $this->instance->parse(simplexml_load_string('<res>' . $xml . '</res>'));
		$this->assertEquals('13', $account[0]->getId());
		$this->assertEquals('43', $account[0]->getPersonId());
		$this->assertEquals('4711abc', $account[0]->getUserName());
		$this->assertEquals('21', $account[0]->getAccountAuthId());
		$this->assertEquals('Whatever', $account[0]->getAuthInfo());
		$this->assertEquals('47112', $account[0]->getExternalSystemId());
		$this->assertEquals('0', $account[0]->isLdapAccount());
		$this->assertEquals('23325436234', $account[0]->getOrgUnitLid());
		$this->assertEquals('41', $account[0]->getPurposeId());
	}

	public function test_parse_shouldReturnAccounts()
	{
		$xml      = file_get_contents('test/fixtures/accounts.xml');

		$account = $this->instance->parse(simplexml_load_string('<res>' . $xml . '</res>'));
		$this->assertEquals('13', $account[0]->getId());
		$this->assertEquals('43', $account[0]->getPersonId());
		$this->assertEquals('4711abc', $account[0]->getUserName());
		$this->assertEquals('21', $account[0]->getAccountAuthId());
		$this->assertEquals('Whatever', $account[0]->getAuthInfo());
		$this->assertEquals('47112', $account[0]->getExternalSystemId());
		$this->assertEquals('0', $account[0]->isLdapAccount());
		$this->assertEquals('23325436234', $account[0]->getOrgUnitLid());
		$this->assertEquals('412', $account[1]->getPurposeId());
		$this->assertEquals('132', $account[1]->getId());
		$this->assertEquals('432', $account[1]->getPersonId());
		$this->assertEquals('4711abc2', $account[1]->getUserName());
		$this->assertEquals('212', $account[1]->getAccountAuthId());
		$this->assertEquals('Whatever2', $account[1]->getAuthInfo());
		$this->assertEquals('471122', $account[1]->getExternalSystemId());
		$this->assertEquals('1', $account[1]->isLdapAccount());
		$this->assertEquals('233254362342', $account[1]->getOrgUnitLid());
		$this->assertEquals('412', $account[1]->getPurposeId());
	}

}