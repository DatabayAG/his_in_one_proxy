<?php


class GuzzleWrapperTest extends PHPUnit\Framework\TestCase
{

	/**
	 * @var \HisInOneProxy\REST\GuzzleWrapper
	 */
	protected $wrapper;

	protected function setUp()
	{
		$this->wrapper = new \HisInOneProxy\REST\GuzzleWrapper('2');
	}

	public function test_getClient_shouldReturnClient()
	{
		$this->assertInstanceOf('\GuzzleHttp\Client', $this->wrapper->getClient());
	}
}