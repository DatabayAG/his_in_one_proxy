<?php

/**
 * Class EcsResourcesTest
 */
class EcsResourcesTest extends PHPUnit\Framework\TestCase
{

	protected $ecs;

	protected function setUp()
	{
		$this->ecs = new \HisInOneProxy\REST\EcsResources();
	}

	public function test_getPlainPath_shouldReturnPath()
	{
		$this->assertEquals('campusconnect/', $this->ecs->getPlainPath());
	}
	
	public function test_getCoursePath_shouldReturnPath()
	{
		$this->assertEquals('campusconnect/courses/', $this->ecs->getCoursePath());
	}
	
	public function test_getCourseUrlPath_shouldReturnPath()
	{
		$this->assertEquals('campusconnect/course_urls/', $this->ecs->getCourseUrlPath());
	}
	
	public function test_getMembersUrlPath_shouldReturnPath()
	{
		$this->assertEquals('campusconnect/course_members/', $this->ecs->getMembersUrlPath());
	}
	
	public function test_getCourseCatalogUrlPath_shouldReturnPath()
	{
		$this->assertEquals('campusconnect/directory_trees/', $this->ecs->getCourseCatalogUrlPath());
	}

}