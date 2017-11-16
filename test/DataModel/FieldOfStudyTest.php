<?php
require_once './libs/composer/vendor/autoload.php';

use  HisInOneProxy\DataModel;

/**
 * Class FieldOfStudyTest
 */
class FieldOfStudyTest extends PHPUnit\Framework\TestCase
{

	/**
	 * @var DataModel\FieldOfStudy $instance
	 */
	protected $instance;

	protected function setUp()
	{
		$this->instance = new DataModel\FieldOfStudy();
	}

	public function test_instantiateObject_shouldReturnInstance()
	{
		$this->assertInstanceOf('HisInOneProxy\DataModel\FieldOfStudy', $this->instance);
	}

	public function test_getAStat_shouldReturnId()
	{
		$this->instance->setAStat(1);
		$this->assertEquals(1, $this->instance->getAStat());
	}

}