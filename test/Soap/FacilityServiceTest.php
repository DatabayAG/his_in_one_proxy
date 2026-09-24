<?php

include_once './libs/composer/vendor/autoload.php';

use HisInOneProxy\Soap;

require_once 'test/TestCaseExtension.php';

/**
 * Class FacilityServiceTest
 */
class FacilityServiceTest extends TestCaseExtension
{

	/**
	 * @var Soap\SoapServiceRouter
	 */
	protected $soap_client_router;

	protected function setUp(): void
	{
		parent::setUp();

		$this->soap_client_router = new Soap\SoapServiceRouter($this->log);
		$this->soap_client_router->setSoapClientFacilityService($this->createSoapClientMock());
	}

	public function test_readRoom_shouldLogErrors()
	{
		$this->soap_client_router->getSoapClientFacilityService()->method('__soapCall')
								 ->willThrowException(new SoapFault('Server', 'Room with id 23435 not found.'));
		$soap_client = new Soap\FacilityService($this->log, $this->soap_client_router );
		$soap_client->readRoom(23435);
		$this->assertEqualClearedString('Error: Room with id 23435 not found.', array_pop($this->collectedMessages));
	}

	public function test_readRoom_shouldReturnValue()
	{
		$this->soap_client_router->getSoapClientFacilityService()->method('__soapCall')
			->willReturn(simplexml_load_string('<resp>'.file_get_contents('test/fixtures/room.xml') . '</resp>'));
		$soap_client = new Soap\FacilityService($this->log, $this->soap_client_router);
		$value = $soap_client->readRoom(23435);
		$this->assertInstanceOf('HisInOneProxy\DataModel\Room', $value);
		$this->assertEquals('23435', $value->getId());
	}

}
