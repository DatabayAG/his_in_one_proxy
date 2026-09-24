<?php

include_once './libs/composer/vendor/autoload.php';

use HisInOneProxy\Soap;

require_once 'test/TestCaseExtension.php';

/**
 * Class OrgUnitServiceTest
 */
class OrgUnitServiceTest extends TestCaseExtension
{
	/**
	 * @var Soap\SoapServiceRouter
	 */
	protected $soap_client_router;

	protected function setUp(): void
	{
		parent::setUp();
		$this->soap_client_router = new Soap\SoapServiceRouter($this->log);
		$this->soap_client_router->setSoapClientOrgUnitService($this->createSoapClientMock());
	}

	public function test_readOrgUnit_shouldLogErrors()
	{
		$this->soap_client_router->getSoapClientOrgUnitService()->method('__soapCall')
								 ->willThrowException(new SoapFault('Server', 'OrgUnit with id 55 not found.'));
		$soap_client = new Soap\OrgUnitService($this->log, $this->soap_client_router );
		$soap_client->readOrgUnit(55, '2017-02-25');
		$this->assertEqualClearedString('Error: OrgUnit with id 55 not found.', array_pop($this->collectedMessages));
	}


	public function test_readOrgUnit_shouldReturnValue()
	{
		$this->soap_client_router->getSoapClientOrgUnitService()->method('__soapCall')
			->willReturn(simplexml_load_string('<resp>'.file_get_contents('test/fixtures/unit.xml').'</resp>'));
		$soap_client = new Soap\OrgUnitService($this->log, $this->soap_client_router);
		$value = $soap_client->readOrgUnit(55, '2017-02-25');
		$this->assertInstanceOf('HisInOneProxy\DataModel\OrgUnit', $value);
	}

}
