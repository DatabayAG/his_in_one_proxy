<?php
require_once 'test/TestCaseExtension.php';

class FunctionObjectTest extends TestCaseExtension
{

	public function test_ensureFunctionObject_shouldReturnValue()
	{
		$obj = new \HisInOneProxy\System\Console\FunctionObject();
		$obj->setId('mysuperid');
		$obj->setComment('My comment');
		$obj->setFunction('MyTestFunction');
		$obj->setDebug(true);
		$this->assertEquals('mysuperid', $obj->getId());
		$this->assertEquals('My comment', $obj->getComment());
		$this->assertEquals('MyTestFunction', $obj->getFunction());
		$this->assertEquals(true, $obj->isDebug());
	}
}