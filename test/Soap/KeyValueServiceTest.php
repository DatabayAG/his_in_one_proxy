<?php

include_once './libs/composer/vendor/autoload.php';

require_once 'test/TestCaseExtension.php';

use HisInOneProxy\Soap;

/**
 * Class KeyValueServiceTest
 */
class KeyValueServiceTest extends TestCaseExtension
{
	/**
	 * @var Soap\SoapServiceRouter
	 */
	protected $soap_client_router;

	protected function setUp()
	{
		parent::setUp();
		$this->soap_client_router = new Soap\SoapServiceRouter($this->log);
		$this->soap_client_router->setSoapClientKeyValueService($this->getMockFromWsdl(\HisInOneProxy\Config\GlobalSettings::getInstance()->getHisServerUrl().'KeyvalueService.wsdl'));
	}

	protected function initEmptySoapClientService()
	{
		$this->soap_client_router->getSoapClientKeyValueService()->expects($this->any())
                                 ->method('__soapCall')
                                 ->willReturn(simplexml_load_string('<resp></resp>'));
	}

	public function test_getAllTermTypes_shouldReturnValue()
	{
		$this->soap_client_router->getSoapClientKeyValueService()->expects($this->any())
                                 ->method('__soapCall')
                                 ->willReturn(simplexml_load_string('<resp><listOfTermTypes>'.file_get_contents('test/fixtures/term_type.xml').'</listOfTermTypes></resp>'));
		$soap_client = new Soap\KeyvalueService($this->log, $this->soap_client_router);
		$value = $soap_client->getAllValid('TermTypeValue', 12);
		$this->assertEquals(null, $value);
	}

	public function test_getAllTypes_shouldReturnValue()
	{
		$this->soap_client_router->getSoapClientKeyValueService()->expects($this->any())
                                 ->method('__soapCall')
                                 ->willReturn(simplexml_load_string('<resp>'.file_get_contents('test/fixtures/e_address_type.xml').'</resp>'));
		$soap_client = new Soap\KeyvalueService($this->log, $this->soap_client_router);
		$value = $soap_client->getAllValid('EAddresstypeValue', 12);
		$this->assertEquals('23412', $value->value['0']->id);
	}
	

}