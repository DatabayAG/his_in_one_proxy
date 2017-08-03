<?php
require_once './libs/composer/vendor/autoload.php';

use  HisInOneProxy\DataModel;

class HisSystemResponseContainerTest extends PHPUnit\Framework\TestCase
{
	/**
	 * @var DataModel\Container\HisSystemResponseContainer
	 */
	protected $instance;

	protected function setUp()
	{
		$this->instance = new DataModel\Container\HisSystemResponseContainer();
	}

	public function test_instantiateObject_shouldReturnInstance()
	{
		$this->assertInstanceOf('HisInOneProxy\DataModel\Container\HisSystemResponseContainer', $this->instance);
	}

	public function test_getSystemResponseContainer_shouldReturnCourseMappingTypeContainer()
	{
		$this->instance->appendSystemResponse(new DataModel\HisSystemResponse());
		$this->assertEquals(1, count($this->instance->getSystemResponseContainer()));
		$this->assertEquals(1, $this->instance->getSizeOfContainer());
	}

	public function test_appendExamRelation_shouldReturnCourseMappingTypeContainer()
	{
		for($i = 2; $i < 4; $i++)
		{
			$sys = new DataModel\HisSystemResponse();
			$sys->setObjectId($i);
			$this->instance->appendSystemResponse($sys);
		}
		$this->assertEquals(2, count($this->instance->getSystemResponseContainer()));
		$this->assertEquals(2, $this->instance->getSizeOfContainer());
		foreach($this->instance->getSystemResponse() as $response)
		{
			$resp = $response;
		}
		$this->assertEquals(3, $resp->getObjectId());
	}
}