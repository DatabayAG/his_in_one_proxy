<?php

include_once './libs/composer/vendor/autoload.php';

use HisInOneProxy\Soap;

require_once 'test/TestCaseExtension.php';

/**
 * Class AddressServiceTest
 */
class AddressServiceTest extends TestCaseExtension
{

	/**
	 * @var Soap\SoapServiceRouter
	 */
	protected $soap_client_router;

	protected function setUp()
	{
		parent::setUp();

		$this->soap_client_router = new Soap\SoapServiceRouter($this->log);
		$this->soap_client_router->setSoapClientAddressService($this->getMockFromWsdl(\HisInOneProxy\Config\GlobalSettings::getInstance()->getHisServerUrl().'AddressService.wsdl'));
	}

	public function test_readPostAddresses_shouldLogErrors()
	{
		$this->soap_client_router->getSoapClientAddressService()->expects($this->any())
								 ->method('__soapCall')
								 ->will($this->throwException(new SoapFault('Server', 'Something horrible happened in the room.')));
		$soap_client = new Soap\AddressService($this->log, $this->soap_client_router );
		$soap_client->readPostAddresses(1999);
		$this->assertEqualClearedString('Error: Something horrible happened in the room.', array_pop($this->collectedMessages));
	}

	public function test_readRoom_shouldReturnValue()
	{
		$this->soap_client_router->getSoapClientAddressService()->expects($this->any())
			->method('__soapCall')
			->willReturn(simplexml_load_string('<resp>'.file_get_contents('test/fixtures/address.xml') . '</resp>'));
		$soap_client = new Soap\AddressService($this->log, $this->soap_client_router);
		$value = $soap_client->readPostAddresses(1999);
		$this->assertInstanceOf('HisInOneProxy\DataModel\Address', $value[0]);
		/**
		 * @var \HisInOneProxy\DataModel\Address $address
		 */
		$address = $value[0];
		$this->assertEquals('23435', $address->getId());
		$this->assertEquals('87043563577076', $address->getObjGuid());
		$this->assertEquals('3434', $address->getAddressTagId());
		$this->assertEquals('0', $address->getSortOrder());
		$this->assertEquals('22-11-2019', $address->getValidTo());
		$this->assertEquals('22-11-2014', $address->getValidFrom());
		$this->assertEquals('34', $address->getPersonId());
		$this->assertEquals('45345234', $address->getOrgUnitLid());
		$this->assertEquals('1', $address->getBuildingId());
		$this->assertEquals('22-11-1920', $address->getCreatedAt());
		$this->assertEquals('22-11-2015', $address->getUpdatedAt());
		$this->assertEquals('13432', $address->getPostCode());
		$this->assertEquals('Super street', $address->getStreet());
		$this->assertEquals('Here', $address->getCity());
		$this->assertEquals('No addition.', $address->getAddressAddition());
		$this->assertEquals('2', $address->getPostBoxOffice());
		$this->assertEquals('23234', $address->getCompany());
		$this->assertEquals('Enter state here', $address->getState());
		$this->assertEquals('45', $address->getCountryId());
	}

}