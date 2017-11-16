<?php
require_once 'test/TestCaseExtension.php';

/**
 * Class FunctionsTest
 */
class FunctionsTest extends TestCaseExtension
{

	public function test_getFunctions_shouldReturnValue()
	{
		$container = \HisInOneProxy\System\Console\Functions::getFunctions();
		$obj = $container['lc'] ;
		$this->assertEquals('lc', $obj->getId());
		$this->assertEquals('Gets all lectures and add them to queue.', $obj->getComment());
		$this->assertEquals('getLectures', $obj->getFunction());
		$this->assertEquals(false, $obj->isDebug());
	}
}