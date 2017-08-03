<?php

use \HisInOneProxy\Queue\QueueService;

class QueueServiceTest extends PHPUnit\Framework\TestCase
{

	public function test_doesFunctionExists_shouldReturnTrue()
	{
		$this->assertTrue(QueueService::doesFunctionExists('get_institutions_and_org_units'));
	}

	public function test_doesFunctionExists_shouldReturnFalse()
	{
		$this->assertFalse(QueueService::doesFunctionExists('my_magic_method'));
	}

}

