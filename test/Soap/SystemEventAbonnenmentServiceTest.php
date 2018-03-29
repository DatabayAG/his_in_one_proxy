<?php

include_once './libs/composer/vendor/autoload.php';

use HisInOneProxy\Soap;

require_once 'test/TestCaseExtension.php';

/**
 * Class SystemEventAbonnenmentServiceTest
 */
class SystemEventAbonnenmentServiceTest extends TestCaseExtension
{

	/**
	 * @var Soap\SoapServiceRouter
	 */
	protected $soap_client_router;

	protected function setUp()
	{
		parent::setUp();

		$this->soap_client_router = new Soap\SoapServiceRouter($this->log);
		$this->soap_client_router->setSoapSystemEventAbonnenmentClient($this->getMockFromWsdl(\HisInOneProxy\Config\GlobalSettings::getInstance()->getHisServerUrl().'SystemEventAbonnenmentService.wsdl'));
	}

	public function test_register_shouldLogErrors()
	{
		$this->soap_client_router->getSoapSystemEventAbonnenmentClient()->expects($this->any())
								 ->method('__soapCall')
								 ->will($this->throwException(new SoapFault('Server', 'Some horrible event happened.')));
		$soap_client = new Soap\SystemEventAbonnenmentService($this->log, $this->soap_client_router );
		$end = new \HisInOneProxy\DataModel\Endpoint();
		$end->setEndPointUrl('http://db');
		$end->setPort(9090);
		$end->setWebServiceMethod('mySuperMethod');
		$soap_client->register('person', $end);
		$this->assertEqualClearedString('Error: Some horrible event happened.', array_pop($this->collectedMessages));
	}

	/*public function test_readRoom_shouldReturnValue()
	{

		$this->soap_client_router->getSoapSystemEventAbonnenmentClient()->expects($this->any())
								 ->method('__soapCall')
								 ->will($this->returnValue(true));
		$soap_client = new Soap\SystemEventAbonnenmentService($this->log, $this->soap_client_router );
		$end = new \HisInOneProxy\DataModel\Endpoint();
		$end->setEndPointUrl('http://db');
		$end->setPort(9090);
		$end->setWebServiceMethod('mySuperMethod');
		$value = $soap_client->register('person', $end);
		$this->assertTrue($value);
	}*/

	public function test_quitRegistration_shouldLogErrors()
	{
		$this->soap_client_router->getSoapSystemEventAbonnenmentClient()->expects($this->any())
								 ->method('__soapCall')
								 ->will($this->throwException(new SoapFault('Server', 'Some horrible event happened.')));
		$soap_client = new Soap\SystemEventAbonnenmentService($this->log, $this->soap_client_router );
		$soap_client->quitRegistration('person');
		$this->assertEqualClearedString('Error: Some horrible event happened.', array_pop($this->collectedMessages));
	}

	/*public function test_quitRegistration_shouldReturnValue()
	{

		$this->soap_client_router->getSoapSystemEventAbonnenmentClient()->expects($this->any())
								 ->method('__soapCall')
								 ->will($this->returnValue(true));
		$soap_client = new Soap\SystemEventAbonnenmentService($this->log, $this->soap_client_router );
		$value = $soap_client->quitRegistration('person');
		$this->assertTrue($value);
	}*/

}