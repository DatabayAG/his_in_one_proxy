<?php

include_once './libs/composer/vendor/autoload.php';

use HisInOneProxy\Soap;

require_once 'test/TestCaseExtension.php';

/**
 * Class PersonServiceTest
 */
class PersonServiceTest extends TestCaseExtension
{
	/**
	 * @var Soap\SoapServiceRouter
	 */
	protected $soap_client_router;

	protected function setUp(): void
	{
		parent::setUp();
		$this->soap_client_router = new Soap\SoapServiceRouter($this->log);
		$this->soap_client_router->setSoapClientPersonService($this->createSoapClientMock());
	}

	public function test_readPerson_shouldLogErrors()
	{
		$this->soap_client_router->getSoapClientPersonService()->method('__soapCall')
								 ->willThrowException(new SoapFault('Server', 'Person with id 122 not found.'));
		$soap_client = new Soap\PersonService($this->log, $this->soap_client_router );
		$soap_client->readPerson(122);
		$this->assertEqualClearedString('Error: Person with id 122 not found.', array_pop($this->collectedMessages));
	}

	public function test_readPerson_shouldReturnValue()
	{
		$this->soap_client_router->getSoapClientPersonService()->method('__soapCall')
			->willReturn(simplexml_load_string(file_get_contents('test/fixtures/person.xml')));
		$soap_client = new Soap\PersonService($this->log, $this->soap_client_router);
		$value = $soap_client->readPerson(122);
		$this->assertInstanceOf('HisInOneProxy\DataModel\Person', $value);
		$this->assertEquals('122', $value->getId());
	}

}
