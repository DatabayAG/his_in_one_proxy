<?php

include_once './libs/composer/vendor/autoload.php';

use HisInOneProxy\Soap;

require_once 'test/TestCaseExtension.php';

/**
 * Class AccountServiceTest
 */
class AccountServiceTest extends TestCaseExtension
{

	/**
	 * @var Soap\SoapServiceRouter
	 */
	protected $soap_client_router;

	protected function setUp(): void
	{
		parent::setUp();

		$this->soap_client_router = new Soap\SoapServiceRouter($this->log);
		$this->soap_client_router->setSoapClientAccountService($this->createSoapClientMock());
	}

	public function test_searchAccountForPerson61_shouldLogErrors()
	{
		$this->soap_client_router->getSoapClientAccountService()->method('__soapCall')
								 ->willThrowException(new SoapFault('Server', 'Account lookup failed for person 43.'));
		$soap_client = new Soap\AccountService($this->log, $this->soap_client_router );
		$soap_client->searchAccountForPerson61(43);
		$this->assertEqualClearedString('Error: Account lookup failed for person 43.', array_pop($this->collectedMessages));
	}


	public function test_searchAccountForPerson61_shouldReturnValue()
	{
		$this->soap_client_router->getSoapClientAccountService()->method('__soapCall')
								 ->willReturn(simplexml_load_string('<resp>'.file_get_contents('test/fixtures/account.xml') . '</resp>'));
		$soap_client = new Soap\AccountService($this->log, $this->soap_client_router);
		$value = $soap_client->searchAccountForPerson61(43);
		$this->assertInstanceOf('HisInOneProxy\DataModel\CompleteAccount', $value[0]);
		/**
		 * @var \HisInOneProxy\DataModel\CompleteAccount $account
		 */
		$account = $value[0];
		$this->assertEquals('13', $account->getId());
		$this->assertEquals('43', $account->getPersonId());
		$this->assertEquals('max.mueller', $account->getUserName());
		$this->assertEquals('21', $account->getAccountAuthId());
		$this->assertEquals('LDAP', $account->getAuthInfo());
		$this->assertEquals('ecs-43', $account->getExternalSystemId());
		$this->assertEquals('0', $account->isLdapAccount());
		$this->assertEquals('3654775', $account->getOrgUnitLid());
		$this->assertEquals('41', $account->getPurposeId());
	}

}
