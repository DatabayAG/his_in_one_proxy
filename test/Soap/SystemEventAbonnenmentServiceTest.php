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

	protected function setUp(): void
	{
		parent::setUp();

		$this->soap_client_router = new Soap\SoapServiceRouter($this->log);
		$this->soap_client_router->setSoapSystemEventAbonnenmentClient($this->createSoapClientMock());
	}

	public function test_register_shouldLogErrors()
	{
		$this->soap_client_router->getSoapSystemEventAbonnenmentClient()->method('__soapCall')
								 ->willThrowException(new SoapFault('Server', 'Event listener registration failed.'));
		$soap_client = new Soap\SystemEventAbonnenmentService($this->log, $this->soap_client_router );
		$end = new \HisInOneProxy\DataModel\Endpoint();
		$end->setEndPointUrl('http://localhost');
		$end->setPort(8080);
		$end->setWebServiceMethod('onPersonChanged');
		$soap_client->register('person', $end);
		$this->assertEqualClearedString('Error: Event listener registration failed.', array_pop($this->collectedMessages));
	}

	public function test_quitRegistration_shouldLogErrors()
	{
		$this->soap_client_router->getSoapSystemEventAbonnenmentClient()->method('__soapCall')
								 ->willThrowException(new SoapFault('Server', 'Event listener deregistration failed.'));
		$soap_client = new Soap\SystemEventAbonnenmentService($this->log, $this->soap_client_router );
		$soap_client->quitRegistration('person');
		$this->assertEqualClearedString('Error: Event listener deregistration failed.', array_pop($this->collectedMessages));
	}

}
