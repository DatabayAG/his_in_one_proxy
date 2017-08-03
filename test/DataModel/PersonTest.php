<?php
require_once './libs/composer/vendor/autoload.php';

use  HisInOneProxy\DataModel;

class PersonTest extends PHPUnit\Framework\TestCase
{

	/**
	 * @var DataModel\Person $instance
	 */
	protected $instance;

	protected function setUp()
	{
		$this->instance = new DataModel\Person();
	}

	public function test_instantiateObject_shouldReturnInstance()
	{
		$this->assertInstanceOf('HisInOneProxy\DataModel\Person', $this->instance);
	}

	public function test_getFirstName_shouldReturnFirstName()
	{
		$this->instance->setFirstName('Test');
		$this->assertEquals('Test', $this->instance->getFirstName());
	}

	public function test_getSurName_shouldReturnAllSurName()
	{
		$this->instance->setSurName('Test');
		$this->assertEquals('Test', $this->instance->getSurName());
	}

	public function test_getAllFirstNames_shouldReturnSurName()
	{
		$this->instance->setAllFirstNames('Test Testy Tester');
		$this->assertEquals('Test Testy Tester', $this->instance->getAllFirstNames());
	}

	public function test_getSortOrder_shouldReturnOrder()
	{
		$this->instance->setSortOrder(1);
		$this->assertEquals(1, $this->instance->getSortOrder());
	}

	public function test_getShortText_shouldReturnShortText()
	{
		$this->instance->setShortText('My totally short text.');
		$this->assertEquals('My totally short text.', $this->instance->getShortText());
	}

	public function test_getLongText_shouldReturnLongText()
	{
		$this->instance->setLongText('Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Donec velit neque, auctor sit amet aliquam vel, ullamcorper sit amet ligula. Donec sollicitudin molestie malesuada. Donec sollicitudin molestie malesuada. Mauris blandit aliquet elit, eget tincidunt nibh pulvinar a. Donec sollicitudin molestie malesuada. Donec sollicitudin molestie malesuada. Proin eget tortor risus. Donec sollicitudin molestie malesuada. Curabitur aliquet quam id dui posuere blandit. Nulla quis lorem ut libero malesuada feugiat.');
		$this->assertEquals('Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Donec velit neque, auctor sit amet aliquam vel, ullamcorper sit amet ligula. Donec sollicitudin molestie malesuada. Donec sollicitudin molestie malesuada. Mauris blandit aliquet elit, eget tincidunt nibh pulvinar a. Donec sollicitudin molestie malesuada. Donec sollicitudin molestie malesuada. Proin eget tortor risus. Donec sollicitudin molestie malesuada. Curabitur aliquet quam id dui posuere blandit. Nulla quis lorem ut libero malesuada feugiat.', $this->instance->getLongText());
	}

	public function test_getDefaultText_shouldReturnDefaultText()
	{
		$this->instance->setDefaultText('My default text.');
		$this->assertEquals('My default text.', $this->instance->getDefaultText());
	}

	public function test_getDateOfBirth_shouldReturnDateOfBirth()
	{
		$this->instance->setDateOfBirth('1999-01-01');
		$this->assertEquals('1999-01-01', $this->instance->getDateOfBirth());
	}

	public function test_getGenderId_shouldReturnGenderId()
	{
		$this->instance->setGenderId(2);
		$this->assertEquals(2, $this->instance->getGenderId());
	}

	public function test_getBirthName_shouldReturnBirthName()
	{
		$this->instance->setBirthName('Meyer');
		$this->assertEquals('Meyer', $this->instance->getBirthName());
	}

	public function test_getArtistName_shouldReturnArtistName()
	{
		$this->instance->setArtistName('Formerly know as...');
		$this->assertEquals('Formerly know as...', $this->instance->getArtistName());
	}

	public function test_getNamePrefix_shouldReturnNamePrefix()
	{
		$this->instance->setNamePrefix('von');
		$this->assertEquals('von', $this->instance->getNamePrefix());
	}

	public function test_getObjGuid_shouldReturnObjGuid()
	{
		$this->instance->setObjGuid(3243243245324);
		$this->assertEquals(3243243245324, $this->instance->getObjGuid());
	}

	public function test_getId_shouldReturnId()
	{
		$this->instance->setId(22);
		$this->assertEquals(22, $this->instance->getId());
	}

	public function test_getNameSuffix_shouldReturnNameSuffix()
	{
		$this->instance->setNameSuffix('suffix');
		$this->assertEquals('suffix', $this->instance->getNameSuffix());
	}

	public function test_getAcademicDegreeSuffix_shouldReturnAcademicDegreeSuffix()
	{
		$this->instance->setAcademicDegreeSuffix('Dr');
		$this->assertEquals('Dr', $this->instance->getAcademicDegreeSuffix());
	}

	public function test_getTitleId_shouldReturnTitleId()
	{
		$this->instance->setTitleId(233);
		$this->assertEquals(233, $this->instance->getTitleId());
	}

	public function test_getBirthCity_shouldReturnBirthCity()
	{
		$this->instance->setBirthCity('Köln');
		$this->assertEquals('Köln', $this->instance->getBirthCity());
	}

	public function test_getCountryId_shouldReturnCountryId()
	{
		$this->instance->setCountryId(777);
		$this->assertEquals(777, $this->instance->getCountryId());
	}

	public function test_getNationalityId_shouldReturnNationalityId()
	{
		$this->instance->setNationalityId(778);
		$this->assertEquals(778, $this->instance->getNationalityId());
	}

	public function test_getSecondNationalityId_shouldReturnSecondNationalityId()
	{
		$this->instance->setSecondNationalityId(779);
		$this->assertEquals(779, $this->instance->getSecondNationalityId());
	}

	public function test_getSelfRegistrationStatusId_shouldReturnSelfRegistrationStatusId()
	{
		$this->instance->setSelfRegistrationStatusId(1);
		$this->assertEquals(1, $this->instance->getSelfRegistrationStatusId());
	}

	public function test_getAcademicDegreeId_shouldReturnAcademicDegreeId()
	{
		$this->instance->setAcademicDegreeId(656);
		$this->assertEquals(656, $this->instance->getAcademicDegreeId());
	}
}