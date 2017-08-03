<?php
require_once './libs/composer/vendor/autoload.php';

use  HisInOneProxy\DataModel;

class EventDateTest extends PHPUnit\Framework\TestCase
{
	/**
	 * @var DataModel\EventDate $instance
	 */
	protected $instance;

	protected function setUp()
	{
		$this->instance = new DataModel\EventDate();
	}

	public function test_instantiateObject_shouldReturnInstance()
	{
		$this->assertInstanceOf('HisInOneProxy\DataModel\EventDate', $this->instance);
	}

	public function test_getId_shouldReturnId()
	{
		$this->instance->setId(123);
		$this->assertEquals(123, $this->instance->getId());
	}

	public function test_getObjGuid_shouldReturnObjGuid()
	{
		$this->instance->setObjGuid(123124);
		$this->assertEquals(123124, $this->instance->getObjGuid());
	}

	public function test_getLockVersion_shouldReturnLockVersion()
	{
		$this->instance->setLockVersion(5);
		$this->assertEquals(5, $this->instance->getLockVersion());
	}

	public function test_getAcademicYear_shouldReturnAcademicYear()
	{
		$this->instance->setAcademicYear('2015');
		$this->assertEquals('2015', $this->instance->getAcademicYear());
	}

	public function test_getCompulsoryRequirement_shouldReturnCompulsoryRequirement()
	{
		$this->instance->setCompulsoryRequirement('CompulsoryRequirement');
		$this->assertEquals('CompulsoryRequirement', $this->instance->getCompulsoryRequirement());
	}

	public function test_getContents_shouldReturnContents()
	{
		$this->instance->setContents('My big contents');
		$this->assertEquals('My big contents', $this->instance->getContents());
	}

	public function test_getCourseAchievement_shouldReturnCourseAchievement()
	{
		$this->instance->setCourseAchievement('YOU achieved NOTHING.');
		$this->assertEquals('YOU achieved NOTHING.', $this->instance->getCourseAchievement());
	}

	public function test_getCredits_shouldReturnCredits()
	{
		$this->instance->setCredits('5');
		$this->assertEquals('5', $this->instance->getCredits());
	}

	public function test_getExaminationAchievement_shouldReturnExaminationAchievement()
	{
		$this->instance->setExaminationAchievement('YOU achieved less than NOTHING.');
		$this->assertEquals('YOU achieved less than NOTHING.', $this->instance->getExaminationAchievement());
	}

	public function test_getExternOrganizer_shouldReturnExternOrganizer()
	{
		$this->instance->setExternOrganizer('And the extern organizer is...');
		$this->assertEquals('And the extern organizer is...', $this->instance->getExternOrganizer());
	}

	public function test_getGrading_shouldReturnGrading()
	{
		$this->instance->setGrading('Your grading');
		$this->assertEquals('Your grading', $this->instance->getGrading());
	}

	public function test_getLearningTarget_shouldReturnLearningTarget()
	{
		$this->instance->setLearningTarget('Your learning target should be');
		$this->assertEquals('Your learning target should be', $this->instance->getLearningTarget());
	}

	public function test_getLiterature_shouldReturnLiterature()
	{
		$this->instance->setLiterature('You should read this');
		$this->assertEquals('You should read this', $this->instance->getLiterature());
	}

	public function test_getObjectiveQualification_shouldReturnObjectiveQualification()
	{
		$this->instance->setObjectiveQualification('Objective Qualification');
		$this->assertEquals('Objective Qualification', $this->instance->getObjectiveQualification());
	}

	public function test_getPlanElementId_shouldReturnPlanElementId()
	{
		$this->instance->setPlanElementId(4354353);
		$this->assertEquals(4354353, $this->instance->getPlanElementId());
	}

	public function test_getRecommendedRequirement_shouldReturnRecommendedRequirement()
	{
		$this->instance->setRecommendedRequirement('You should have done this before that.');
		$this->assertEquals('You should have done this before that.', $this->instance->getRecommendedRequirement());
	}

	public function test_getTargetGroup_shouldReturnTargetGroup()
	{
		$this->instance->setTargetGroup('Our target group would be: ');
		$this->assertEquals('Our target group would be: ', $this->instance->getTargetGroup());
	}

	public function test_getTeachingLanguageId_shouldReturnTeachingLanguageId()
	{
		$this->instance->setTeachingLanguageId(23);
		$this->assertEquals(23, $this->instance->getTeachingLanguageId());
	}

	public function test_getTeachingMethod_shouldReturnTeachingMethod()
	{
		$this->instance->setTeachingMethod('Our teaching method will be...');
		$this->assertEquals('Our teaching method will be...', $this->instance->getTeachingMethod());
	}

	public function test_getWorkload_shouldReturnWorkload()
	{
		$this->instance->setWorkload('Much');
		$this->assertEquals('Much', $this->instance->getWorkload());
	}
}