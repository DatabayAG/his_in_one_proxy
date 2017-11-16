<?php
require_once './libs/composer/vendor/autoload.php';

use  HisInOneProxy\DataModel;

/**
 * Class DefaultObjectTest
 */
class DefaultObjectTest extends PHPUnit\Framework\TestCase
{

	/**
	 * @var DataModel\DefaultObject $instance
	 */
	protected $instance;

	protected function setUp()
	{
		$this->instance = new DataModel\DefaultObject();
	}

	public function test_instantiateObject_shouldReturnInstance()
	{
		$this->assertInstanceOf('HisInOneProxy\DataModel\DefaultObject', $this->instance);
	}

	public function test_getId_shouldReturnId()
	{
		$this->instance->setId(1);
		$this->assertEquals(1, $this->instance->getId());
	}

	public function test_getDefaultLanguage_shouldReturnValue()
	{
		$this->instance->setDefaultLanguage(12);
		$this->assertEquals(12, $this->instance->getDefaultLanguage());
	}

	public function test_getHisKeyId_shouldReturnValue()
	{
		$this->instance->setHisKeyId(134234232);
		$this->assertEquals(134234232, $this->instance->getHisKeyId());
	}

	public function test_getObjGuid_shouldReturnValue()
	{
		$this->instance->setObjGuid(13423423243432);
		$this->assertEquals(13423423243432, $this->instance->getObjGuid());
	}

	public function test_getSortOrder_shouldReturnValue()
	{
		$this->instance->setSortOrder(0);
		$this->assertEquals(0, $this->instance->getSortOrder());
	}

	public function test_getUniqueName_shouldReturnValue()
	{
		$this->instance->setUniqueName('fsdfdsafdsfa');
		$this->assertEquals('fsdfdsafdsfa', $this->instance->getUniqueName());
	}

	public function test_getShortText_shouldReturnValue()
	{
		$this->instance->setShortText('fs');
		$this->assertEquals('fs', $this->instance->getShortText());
	}

	public function test_getLongText_shouldReturnValue()
	{
		$this->instance->setLongText('fsdfdsafd s dg fdsf fdsfsfa');
		$this->assertEquals('fsdfdsafd s dg fdsf fdsfsfa', $this->instance->getLongText());
	}

	public function test_getDefaultText_shouldReturnValue()
	{
		$this->instance->setDefaultText('aaaaaaaaa');
		$this->assertEquals('aaaaaaaaa', $this->instance->getDefaultText());
	}

}