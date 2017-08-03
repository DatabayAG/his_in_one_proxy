<?php

include_once './libs/composer/vendor/autoload.php';

use HisInOneProxy\Soap;

require_once 'test/TestCaseExtension.php';

class FacilityServiceTest extends TestCaseExtension
{

	/**
	 * @var Soap\SoapServiceRouter
	 */
	protected $soap_client_router;

	protected function setUp()
	{
		parent::setUp();

		$this->soap_client_router = new Soap\SoapServiceRouter($this->log);
		$this->soap_client_router->setSoapClientFacilityService($this->getMockFromWsdl(\HisInOneProxy\Config\GlobalSettings::getInstance()->getHisServerUrl().'FacilityService.wsdl'));
	}

	public function test_readRoom_shouldLogErrors()
	{
		$this->soap_client_router->getSoapClientFacilityService()->expects($this->any())
								 ->method('__soapCall')
								 ->will($this->throwException(new SoapFault('Server', 'Something horrible happened in the room.')));
		$soap_client = new Soap\FacilityService($this->log, $this->soap_client_router );
		$soap_client->readRoom(1999);
		$this->assertEquals('Error: Something horrible happened in the room.', array_pop($this->collectedMessages));
	}

	public function test_readRoom_shouldReturnValue()
	{
		$this->soap_client_router->getSoapClientFacilityService()->expects($this->any())
			->method('__soapCall')
			->willReturn(simplexml_load_string('<resp>'.file_get_contents('test/fixtures/room.xml') . '</resp>'));
		$soap_client = new Soap\FacilityService($this->log, $this->soap_client_router);
		$value = $soap_client->readRoom(1999);
		$this->assertInstanceOf('HisInOneProxy\DataModel\Room', $value);
		$this->assertEquals('23435', $value->getId());
	}

}