<?php

include_once './libs/composer/vendor/autoload.php';

use HisInOneProxy\Parser;

require_once 'test/TestCaseExtension.php';

class ParseAddressTest  extends TestCaseExtension{

	/**
	 * @var Parser\ParseAddress $instance
	 */
	protected $instance;
	
	protected function setUp()
	{
		$this->instance = new Parser\ParseAddress($this->log);
		parent::setUp();
	}

	public function test_parse_shouldReturnAddress()
	{
		$xml      = file_get_contents('test/fixtures/address.xml');

		$address = $this->instance->parse(simplexml_load_string('<res>' . $xml . '</res>'));

		$this->assertEquals('23435', $address[0]->getId());
		$this->assertEquals('87043563577076', $address[0]->getObjGuid());
		$this->assertEquals('3434', $address[0]->getAddressTagId());
		$this->assertEquals('0', $address[0]->getSortOrder());
		$this->assertEquals('22-11-2014', $address[0]->getValidFrom());
		$this->assertEquals('22-11-2019', $address[0]->getValidTo());
		$this->assertEquals('34', $address[0]->getPersonId());
		$this->assertEquals('45345234', $address[0]->getOrgUnitLid());
		$this->assertEquals('1', $address[0]->getBuildingId());
		$this->assertEquals('22-11-1920', $address[0]->getCreatedAt());
		$this->assertEquals('22-11-2015', $address[0]->getUpdatedAt());
		$this->assertEquals('Super street', $address[0]->getStreet());
		$this->assertEquals('Here', $address[0]->getCity());
		$this->assertEquals('No addition.', $address[0]->getAddressAddition());
		$this->assertEquals('2', $address[0]->getPostBoxOffice());
		$this->assertEquals('23234', $address[0]->getCompany());
		$this->assertEquals('Enter state here', $address[0]->getState());
		$this->assertEquals('45', $address[0]->getCountryId());
	}

	public function test_parse2_shouldReturnAddress()
	{
		$string = '<res><postAdresses><postAddress><id>23435</id></postAddress><postAddress><id>23436</id></postAddress></postAdresses></res>';
		$address = $this->instance->parse(simplexml_load_string($string));
		$this->assertEquals('23435', $address[0]->getId());
		$this->assertEquals('23436', $address[1]->getId());
	}
}