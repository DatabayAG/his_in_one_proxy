<?php
require_once './libs/composer/vendor/autoload.php';

use  HisInOneProxy\DataModel;

/**
 * Class CourseOfStudyIdListTest
 */
class CourseOfStudyIdListTest extends PHPUnit\Framework\TestCase
{

	/**
	 * @var DataModel\Container\CourseOfStudyIdList $instance
	 */
	protected $instance;

	protected function setUp()
	{
		$this->instance = new DataModel\Container\CourseOfStudyIdList();
	}

	public function test_instantiateObject_shouldReturnInstance()
	{
		$this->assertInstanceOf('HisInOneProxy\DataModel\Container\CourseOfStudyIdList', $this->instance);
	}

	public function test_append_shouldReturnId()
	{
		$this->assertEquals(0, $this->instance->getSizeOfContainer());
		$this->instance->appendCourseOfStudyId(2);
		$this->assertEquals(1, $this->instance->getSizeOfContainer());
		$this->instance->appendCourseOfStudyId(32);
		$this->assertEquals(2, $this->instance->getSizeOfContainer());
		$this->instance->appendCourseOfStudyId(2);
		$this->assertEquals(2, $this->instance->getSizeOfContainer());
		$this->instance->appendCourseOfStudyId(PHP_INT_MAX);
		$this->assertEquals(3, $this->instance->getSizeOfContainer());
	}

	public function test_generatorTest_shouldReturnInstance()
	{
		$values = array(2,1, 500050, 321423, 53454354);
		$this->instance = new DataModel\Container\CourseOfStudyIdList();
		$this->assertEquals(0, $this->instance->getSizeOfContainer());
		$this->instance->appendCourseOfStudyId(2);
		$this->instance->appendCourseOfStudyId(1);
		$this->instance->appendCourseOfStudyId(500050);
		$this->instance->appendCourseOfStudyId(321423);
		$this->instance->appendCourseOfStudyId(53454354);
		$counter = 0 ;
		foreach($this->instance->getCourseOfStudyId() as $study_id)
		{
			$this->assertEquals($values[$counter], $study_id);
			$counter++;
		}
	
	}
}