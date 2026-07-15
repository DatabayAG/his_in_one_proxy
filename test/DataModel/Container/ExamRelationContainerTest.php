<?php
require_once './libs/composer/vendor/autoload.php';

use  HisInOneProxy\DataModel;

/**
 * Class ExamRelationContainerTest
 */
class ExamRelationContainerTest extends PHPUnit\Framework\TestCase
{
	
	protected $instance;

	protected function setUp(): void
	{
		$this->instance = new DataModel\Container\ExamRelationContainer();
	}

	public function test_instantiateObject_shouldReturnInstance()
	{
		$this->instance = new DataModel\Container\ExamRelationContainer();
		$this->assertInstanceOf('HisInOneProxy\DataModel\Container\ExamRelationContainer', $this->instance);
	}

	public function test_appendExamRelation_shouldReturnExamRelation()
	{
		$exam_relation = new DataModel\ExamRelation();
		$this->instance->appendExamRelation($exam_relation);
		$this->assertEquals(1, count($this->instance->getExamRelationContainer()));
	}

	/**
	 */
	public function test_appendEventDate_shouldThrowInvalidArgumentException()
	{
		$this->expectException(HisInOneProxy\Exceptions\InvalidExamRelation::class);
		$this->instance->appendExamRelation('Workload');
	}
}