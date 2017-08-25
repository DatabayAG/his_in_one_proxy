<?php
require_once './libs/composer/vendor/autoload.php';

use  HisInOneProxy\DataModel;

class PurposeTest extends PHPUnit\Framework\TestCase
{

	/**
	 * @var DataModel\Purpose $instance
	 */
	protected $instance;

	protected function setUp()
	{
		$this->instance = new DataModel\Purpose();
	}

	public function test_instantiateObject_shouldReturnInstance()
	{
		$this->assertInstanceOf('HisInOneProxy\DataModel\Purpose', $this->instance);
	}

	public function test_getObjectType_shouldReturnValue()
	{
		$this->instance->setObjectType('PurposeType');
		$this->assertEquals('PurposeType', $this->instance->getObjectType());
	}
}