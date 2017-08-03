<?php
require_once 'test/TestCaseExtension.php';

use HisInOneProxy\System;

class UtilsTest extends TestCaseExtension
{
	public function test_ensureNoTrailingSlash_shouldReturnValue()
	{
		$res = System\Utils::ensureNoTrailingSlash('/var/www/');
		$this->assertEquals('/var/www', $res);
	}

	public function test_ensureTrailingSlash_shouldReturnValue()
	{
		$res = System\Utils::ensureTrailingSlash('/var/www');
		$this->assertEquals('/var/www/', $res);
		$res = System\Utils::ensureTrailingSlash('/var/www/');
		$this->assertEquals('/var/www/', $res);
	}
}