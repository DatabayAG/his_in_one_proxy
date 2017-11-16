<?php
require_once './libs/composer/vendor/autoload.php';

use  HisInOneProxy\DataModel;

/**
 * Class EndPointTest
 */
class EndPointTest extends PHPUnit\Framework\TestCase
{

	/**
	 * @var DataModel\Endpoint $instance
	 */
	protected $instance;

	protected function setUp()
	{
		$this->instance = new DataModel\Endpoint();
	}

	public function test_instantiateObject_shouldReturnInstance()
	{
		$this->assertInstanceOf('HisInOneProxy\DataModel\EndPoint', $this->instance);
	}

	public function test_getEndPointUrl_shouldReturnValue()
	{
		$this->instance->setEndPointUrl('http://endpoint');
		$this->assertEquals('http://endpoint', $this->instance->getEndPointUrl());
	}

	public function test_getWebServiceMethod_shouldReturnValue()
	{
		$this->instance->setWebServiceMethod('myPowerMethod');
		$this->assertEquals('myPowerMethod', $this->instance->getWebServiceMethod());
	}

	public function test_getUserName_shouldReturnValue()
	{
		$this->instance->setUserName('MyUsername');
		$this->assertEquals('MyUsername', $this->instance->getUserName());
	}

	public function test_getPassword_shouldReturnValue()
	{
		$this->instance->setPassword('ultraSecurePlainTextPassword');
		$this->assertEquals('ultraSecurePlainTextPassword', $this->instance->getPassword());
	}

	public function test_getPort_shouldReturnValue()
	{
		$this->instance->setPort('9898');
		$this->assertEquals('9898', $this->instance->getPort());
	}

	public function test_getUrlWithPort_shouldReturnValue()
	{
		$this->instance->setEndPointUrl('http://endpoint');
		$this->instance->setPort('9898');
		$this->assertEquals('http://endpoint:9898/', $this->instance->getUrlWithPort());
	}
}