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

	protected function setUp()
	{
		parent::setUp();
		$this->soap_client_router = new Soap\SoapServiceRouter($this->log);
		$this->soap_client_router->setSoapClientOrgUnitService($this->getMockFromWsdl(\HisInOneProxy\Config\GlobalSettings::getInstance()->getHisServerUrl().'OrgUnitService.wsdl'));
	}

	public function test_readOrgUnit_shouldLogErrors()
	{
		$this->soap_client_router->getSoapClientOrgUnitService()->expects($this->any())
								 ->method('__soapCall')
								 ->will($this->throwException(new SoapFault('Server', 'Something horrible happened in the unit.')));
		$soap_client = new Soap\OrgUnitService($this->log, $this->soap_client_router );
		$soap_client->readOrgUnit(1999, '12-12-1254');
		$this->assertEqualClearedString('Error: Something horrible happened in the unit.', array_pop($this->collectedMessages));
	}


	public function test_readOrgUnit_shouldReturnValue()
	{
		$this->soap_client_router->getSoapClientOrgUnitService()->expects($this->any())
			->method('__soapCall')
			->willReturn(simplexml_load_string('<resp>'.file_get_contents('test/fixtures/unit.xml').'</resp>'));
		$soap_client = new Soap\OrgUnitService($this->log, $this->soap_client_router);
		$value = $soap_client->readOrgUnit(1999, '12-12-1254');
		$this->assertInstanceOf('HisInOneProxy\DataModel\OrgUnit', $value);
	}

}