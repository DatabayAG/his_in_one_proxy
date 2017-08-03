<?php

include_once './libs/composer/vendor/autoload.php';

require_once 'test/TestCaseExtension.php';

use HisInOneProxy\Soap;

class UnitServiceTest extends TestCaseExtension
{
	/**
	 * @var Soap\SoapServiceRouter
	 */
	protected $soap_client_router;

	protected function setUp()
	{
		parent::setUp();
		$this->soap_client_router = new Soap\SoapServiceRouter($this->log);
		$this->soap_client_router->setSoapClientUnitService($this->getMockFromWsdl(\HisInOneProxy\Config\GlobalSettings::getInstance()->getHisServerUrl().'UnitService.wsdl'));
	}

	public function test_getRootIdOfTerm_shouldReturnValue()
	{
		$this->soap_client_router->getSoapClientUnitService()->expects($this->any())
			->method('__soapCall')
			->willReturn(simplexml_load_string('<resp>'.file_get_contents('test/fixtures/unit.xml').'</resp>'));
		$soap_client = new Soap\UnitService($this->log, $this->soap_client_router);
		$value = $soap_client->readUnit(1999, '12-12-1254');
		$this->assertInstanceOf('HisInOneProxy\DataModel\Unit', $value);
	}

}