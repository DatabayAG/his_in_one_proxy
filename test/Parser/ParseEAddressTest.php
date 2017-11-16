<?php

include_once './libs/composer/vendor/autoload.php';

use HisInOneProxy\Parser;

require_once 'test/TestCaseExtension.php';

/**
 * Class ParseEAddressTest
 */
class ParseEAddressTest  extends TestCaseExtension{

	/**
	 * @var Parser\ParseElectronicAddress $instance
	 */
	protected $instance;
	
	protected function setUp()
	{
		$this->instance = new Parser\ParseElectronicAddress($this->log);
		parent::setUp();
	}

	public function test_parse_shouldReturnAddress()
	{
		$xml      = file_get_contents('test/fixtures/eaddress.xml');

		$address = $this->instance->parse(simplexml_load_string('<res>' . $xml . '</res>'));

		$this->assertEquals('23435', $address[0]->getId());
		$this->assertEquals('3434', $address[0]->getAddressTagId());
		$this->assertEquals('0', $address[0]->getSortOrder());
		$this->assertEquals('22-11-2014', $address[0]->getValidFrom());
		$this->assertEquals('22-11-2019', $address[0]->getValidTo());
		$this->assertEquals('34', $address[0]->getPersonId());
		$this->assertEquals('45345234', $address[0]->getOrgUnitLid());
		$this->assertEquals('1', $address[0]->getBuildingId());
		$this->assertEquals('22-11-1920', $address[0]->getCreatedAt());
		$this->assertEquals('22-11-2015', $address[0]->getUpdatedAt());
		$this->assertEquals('E-Mail', $address[0]->getEAddressTypeId());
		$this->assertEquals('asdas@asdas.org', $address[0]->getEAddress());

	}

	public function test_parse2_shouldReturnAddress()
	{
		$string = '<res><eAdresses><eAddress><id>23435</id></eAddress><eAddress><id>23436</id></eAddress></eAdresses></res>';
		$address = $this->instance->parse(simplexml_load_string($string));
		$this->assertEquals('23435', $address[0]->getId());
		$this->assertEquals('23436', $address[1]->getId());
	}
}