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

	protected function setUp()
	{
		parent::setUp();

		$this->soap_client_router = new Soap\SoapServiceRouter($this->log);
		$this->soap_client_router->setSoapClientAccountService($this->getMockFromWsdl(\HisInOneProxy\Config\GlobalSettings::getInstance()->getHisServerUrl().'AccountService.wsdl'));
	}

	public function test_searchAccountForPerson61_shouldLogErrors()
	{
		$this->soap_client_router->getSoapClientAccountService()->expects($this->any())
								 ->method('__soapCall')
								 ->will($this->throwException(new SoapFault('Server', 'Something horrible happened to the person.')));
		$soap_client = new Soap\AccountService($this->log, $this->soap_client_router );
		$soap_client->searchAccountForPerson61(1999);
		$this->assertEqualClearedString('Error: Something horrible happened to the person.', array_pop($this->collectedMessages));
	}


	public function test_searchAccountForPerson61_shouldReturnValue()
	{
		$this->soap_client_router->getSoapClientAccountService()->expects($this->any())
								 ->method('__soapCall')
								 ->willReturn(simplexml_load_string('<resp>'.file_get_contents('test/fixtures/account.xml') . '</resp>'));
		$soap_client = new Soap\AccountService($this->log, $this->soap_client_router);
		$value = $soap_client->searchAccountForPerson61(1999);
		$this->assertInstanceOf('HisInOneProxy\DataModel\CompleteAccount', $value[0]);
		/**
		 * @var \HisInOneProxy\DataModel\CompleteAccount $account
		 */
		$account = $value[0];
		$this->assertEquals('13', $account->getId());
		$this->assertEquals('43', $account->getPersonId());
		$this->assertEquals('4711abc', $account->getUserName());
		$this->assertEquals('21', $account->getAccountAuthId());
		$this->assertEquals('Whatever', $account->getAuthInfo());
		$this->assertEquals('47112', $account->getExternalSystemId());
		$this->assertEquals('0', $account->isLdapAccount());
		$this->assertEquals('23325436234', $account->getOrgUnitLid());
		$this->assertEquals('41', $account->getPurposeId());
	}

}