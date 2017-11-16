<?php
require_once './libs/composer/vendor/autoload.php';

use  HisInOneProxy\DataModel;

/**
 * Class DegreeProgramTest
 */
class DegreeProgramTest extends PHPUnit\Framework\TestCase
{

	public function test_instantiateObject_shouldReturnInstance()
	{
		$instance = new DataModel\DegreeProgram();
		$this->assertInstanceOf('HisInOneProxy\DataModel\DegreeProgram', $instance);
	}

	public function test_getGenderId_shouldReturnGenderId()
	{
		$instance = new DataModel\DegreeProgram();
		$instance->setGenderId(1);
		$this->assertEquals(1, $instance->getGenderId());
	}

	public function test_getStudentId_shouldReturnStudentId()
	{
		$instance = new DataModel\DegreeProgram();
		$instance->setStudentId(12);
		$this->assertEquals(12, $instance->getStudentId());
	}

	public function test_getExtensionDate_shouldReturnExtensionDate()
	{
		$instance = new DataModel\DegreeProgram();
		$date = new DateTime('2016-12-01 16:32');
		$instance->setExtensionDate($date);
		$this->assertEquals($date, $instance->getExtensionDate());
	}

	public function test_getExtensionSemester_shouldReturnExtensionSemester()
	{
		$instance = new DataModel\DegreeProgram();
		$instance->setExtensionSemester(12.3);
		$this->assertEquals(12.3, $instance->getExtensionSemester());
	}
	
	public function test_getProgress70_shouldReturnProgress70()
	{
		$instance = new DataModel\DegreeProgram();
		$instance->setProgress70('whatever');
		$this->assertEquals('whatever', $instance->getProgress70());
	}
}