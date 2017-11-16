<?php
require_once './libs/composer/vendor/autoload.php';

use  HisInOneProxy\DataModel;

/**
 * Class PlanElementTest
 */
class PlanElementTest extends PHPUnit\Framework\TestCase
{

	/**
	 * @var DataModel\PlanElement $instance
	 */
	protected $instance;

	protected function setUp()
	{
		date_default_timezone_set('UTC');
		$this->instance = new DataModel\PlanElement();
	}

	public function test_instantiateObject_shouldReturnInstance()
	{
		$this->assertInstanceOf('HisInOneProxy\DataModel\PlanElement', $this->instance);
	}

	public function test_getId_shouldReturnId()
	{
		$this->instance->setId(1);
		$this->assertEquals(1, $this->instance->getId());
	}

	public function test_getObjGuid_shouldReturnObjGuid()
	{
		$this->instance->setObjGuid(11);
		$this->assertEquals(11, $this->instance->getObjGuid());
	}

	public function test_getLockVersion_shouldReturnLockVersion()
	{
		$this->instance->setLockVersion(12);
		$this->assertEquals(12, $this->instance->getLockVersion());
	}

	public function test_getAttendeeMaximum_shouldReturnAttendeeMaximum()
	{
		$this->instance->setAttendeeMaximum(44444);
		$this->assertEquals(44444, $this->instance->getAttendeeMaximum());
	}

	public function test_getAttendeeMinimum_shouldReturnAttendeeMinimum()
	{
		$this->instance->setAttendeeMinimum(20);
		$this->assertEquals(20, $this->instance->getAttendeeMinimum());
	}

	public function test_getCancelEnd_shouldReturnCancelEnd()
	{
		$this->instance->setCancelEnd(new DateTime('2017-01-31T14:00'));
		$this->assertEquals(new DateTime('2017-01-31T14:00'), $this->instance->getCancelEnd());
	}

	public function test_getCancelled_shouldReturnCancelled()
	{
		$this->instance->setCancelled(1);
		$this->assertEquals(1, $this->instance->getCancelled());
	}

	public function test_getDefaultLanguage_shouldReturnDefaultLanguage()
	{
		$this->instance->setDefaultLanguage(1222);
		$this->assertEquals(1222, $this->instance->getDefaultLanguage());
	}

	public function test_getShortText_shouldReturnShortText()
	{
		$this->instance->setShortText('My totally short text.');
		$this->assertEquals('My totally short text.', $this->instance->getShortText());
	}

	public function test_getLongText_shouldReturnLongText()
	{
		$this->instance->setLongText('Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Donec velit neque, auctor sit amet aliquam vel, ullamcorper sit amet ligula. Donec sollicitudin molestie malesuada. Donec sollicitudin molestie malesuada. Mauris blandit aliquet elit, eget tincidunt nibh pulvinar a. Donec sollicitudin molestie malesuada. Donec sollicitudin molestie malesuada. Proin eget tortor risus. Donec sollicitudin molestie malesuada. Curabitur aliquet quam id dui posuere blandit. Nulla quis lorem ut libero malesuada feugiat.');
		$this->assertEquals('Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Donec velit neque, auctor sit amet aliquam vel, ullamcorper sit amet ligula. Donec sollicitudin molestie malesuada. Donec sollicitudin molestie malesuada. Mauris blandit aliquet elit, eget tincidunt nibh pulvinar a. Donec sollicitudin molestie malesuada. Donec sollicitudin molestie malesuada. Proin eget tortor risus. Donec sollicitudin molestie malesuada. Curabitur aliquet quam id dui posuere blandit. Nulla quis lorem ut libero malesuada feugiat.', $this->instance->getLongText());
	}

	public function test_getDefaultText_shouldReturnDefaultText()
	{
		$this->instance->setDefaultText('My default text.');
		$this->assertEquals('My default text.', $this->instance->getDefaultText());
	}

	public function test_getGenderId_shouldReturnGenderId()
	{
		$this->instance->setGenderId(15);
		$this->assertEquals(15, $this->instance->getGenderId());
	}

	public function test_getGradeAssessmentStatusId_shouldReturnGradeAssessmentStatusId()
	{
		$this->instance->setGradeAssessmentStatusId(65);
		$this->assertEquals(65, $this->instance->getGradeAssessmentStatusId());
	}

	public function test_getHoursPerWeek_shouldReturnHoursPerWeek()
	{
		$this->instance->setHoursPerWeek(8);
		$this->assertEquals(8, $this->instance->getHoursPerWeek());
	}

	public function test_getParallelGroupId_shouldReturnParallelGroupId()
	{
		$this->instance->setParallelGroupId(1231212);
		$this->assertEquals(1231212, $this->instance->getParallelGroupId());
	}

	public function test_getRegisterEnd_shouldReturnRegisterEnd()
	{
		$this->instance->setRegisterEnd(new DateTime('2017-02-31T14:00'));
		$this->assertEquals(new DateTime('2017-02-31T14:00'), $this->instance->getRegisterEnd());
	}

	public function test_getRegisterBegin_shouldReturnRegisterBegin()
	{
		$this->instance->setRegisterBegin(new DateTime('2019-02-31T14:00'));
		$this->assertEquals(new DateTime('2019-02-31T14:00'), $this->instance->getRegisterBegin());
	}

	public function test_getRotation_shouldReturnRotation()
	{
		$this->instance->setRotation(543);
		$this->assertEquals(543, $this->instance->getRotation());
	}

	public function test_getTermSegment_shouldReturnTermSegment()
	{
		$this->instance->setTermSegment(787);
		$this->assertEquals(787, $this->instance->getTermSegment());
	}

	public function test_getTermTypeValueId_shouldReturnTermTypeValueId()
	{
		$this->instance->setTermTypeValueId(997);
		$this->assertEquals(997, $this->instance->getTermTypeValueId());
	}

	public function test_getUnitId_shouldReturnUnitId()
	{
		$this->instance->setUnitId(543);
		$this->assertEquals(543, $this->instance->getUnitId());
	}

	public function test_getYear_shouldReturnYear()
	{
		$this->instance->setYear(2017);
		$this->assertEquals(2017, $this->instance->getYear());
	}

	public function test_getAcademicYear_shouldReturnAcademicYear()
	{
		$this->instance->setAcademicYear('WS 2017');
		$this->assertEquals('WS 2017', $this->instance->getAcademicYear());
	}

	public function test_getCompulsoryRequirement_shouldReturnCompulsoryRequirement()
	{
		$this->instance->setCompulsoryRequirement('Requirement');
		$this->assertEquals('Requirement', $this->instance->getCompulsoryRequirement());
	}

	public function test_getContents_shouldReturnContents()
	{
		$this->instance->setContents('Contents');
		$this->assertEquals('Contents', $this->instance->getContents());
	}

	public function test_getCourseAchievement_shouldReturnCourseAchievement()
	{
		$this->instance->setCourseAchievement('CourseAchievement');
		$this->assertEquals('CourseAchievement', $this->instance->getCourseAchievement());
	}

	public function test_getCredits_shouldReturnCredits()
	{
		$this->instance->setCredits('3');
		$this->assertEquals('3', $this->instance->getCredits());
	}

	public function test_getExaminationAchievement_shouldReturnExaminationAchievement()
	{
		$this->instance->setExaminationAchievement('ExaminationAchievement');
		$this->assertEquals('ExaminationAchievement', $this->instance->getExaminationAchievement());
	}

	public function test_getExternOrganizer_shouldReturnExternOrganizer()
	{
		$this->instance->setExternOrganizer('ExternOrganizer');
		$this->assertEquals('ExternOrganizer', $this->instance->getExternOrganizer());
	}

	public function test_getGrading_shouldReturnGrading()
	{
		$this->instance->setGrading('Grading');
		$this->assertEquals('Grading', $this->instance->getGrading());
	}

	public function test_getLearningTarget_shouldReturnLearningTarget()
	{
		$this->instance->setLearningTarget('LearningTarget');
		$this->assertEquals('LearningTarget', $this->instance->getLearningTarget());
	}

	public function test_getLiterature_shouldReturnLiterature()
	{
		$this->instance->setLiterature('Literature');
		$this->assertEquals('Literature', $this->instance->getLiterature());
	}

	public function test_getObjectiveQualification_shouldReturnObjectiveQualification()
	{
		$this->instance->setObjectiveQualification('ObjectiveQualification');
		$this->assertEquals('ObjectiveQualification', $this->instance->getObjectiveQualification());
	}

	public function test_getRecommendedRequirement_shouldReturnRecommendedRequirement()
	{
		$this->instance->setRecommendedRequirement('RecommendedRequirement');
		$this->assertEquals('RecommendedRequirement', $this->instance->getRecommendedRequirement());
	}

	public function test_getTargetGroup_shouldReturnTargetGroup()
	{
		$this->instance->setTargetGroup('TargetGroup');
		$this->assertEquals('TargetGroup', $this->instance->getTargetGroup());
	}

	public function test_getTeachingLanguageId_shouldReturnTeachingLanguageId()
	{
		$this->instance->setTeachingLanguageId('TeachingLanguageId');
		$this->assertEquals('TeachingLanguageId', $this->instance->getTeachingLanguageId());
	}

	public function test_getTeachingMethod_shouldReturnTeachingMethod()
	{
		$this->instance->setTeachingMethod('TeachingMethod');
		$this->assertEquals('TeachingMethod', $this->instance->getTeachingMethod());
	}

	public function test_getWorkload_shouldReturnWorkload()
	{
		$this->instance->setWorkload('Workload');
		$this->assertEquals('Workload', $this->instance->getWorkload());
	}

	/**
	 * @expectedException HisInOneProxy\Exceptions\InvalidPersonPlanElement
	 */
	public function test_appendPersonPlanElement_shouldThrowInvalidArgumentException()
	{
		$this->instance->appendPersonPlanElement('Workload');
	}

	public function test_getPersonPlanElementContainer_shouldReturnPersonPlanElements()
	{
		$this->instance->appendPersonPlanElement(new DataModel\PersonPlanElement());
		$this->instance->appendPersonPlanElement(new DataModel\PersonPlanElement());
		$this->instance->appendPersonPlanElement(new DataModel\PersonPlanElement());
		$this->instance->appendPersonPlanElement(new DataModel\PersonPlanElement());
		$this->assertEquals(4, count($this->instance->getPersonPlanElementContainer()));
	}

	/**
	 * @expectedException HisInOneProxy\Exceptions\InvalidEventDate
	 */
	public function test_appendEventDate_shouldThrowInvalidArgumentException()
	{
		$this->instance->appendEventDate('Workload');
	}

	public function test_getEventDateContainer_shouldReturnEventDate()
	{
		$this->instance->appendEventDate(new DataModel\EventDate());
		$this->instance->appendEventDate(new DataModel\EventDate());
		$this->assertEquals(2, count($this->instance->getEventDateContainer()));
	}

	public function test_getPlanningPreference_shouldReturnPlanningPreference()
	{
		$this->instance->setPlanningPreference(new DataModel\PlanningPreference());
		$this->assertInstanceOf('HisInOneProxy\DataModel\PlanningPreference', $this->instance->getPlanningPreference());
	}

	/**
	 * @expectedException HisInOneProxy\Exceptions\InvalidPlannedDate
	 */
	public function test_appendPlannedDate_shouldThrowInvalidArgumentException()
	{
		$this->instance->appendPlannedDate('Workload');
	}

	public function test_getPlannedDateContainer_shouldReturnPlannedDateContainer()
	{
		$this->instance->appendPlannedDate(new DataModel\PlannedDate());
		$this->instance->appendPlannedDate(new DataModel\PlannedDate());
		$this->instance->appendPlannedDate(new DataModel\PlannedDate());
		$this->assertEquals(3, count($this->instance->getPlannedDateContainer()));
	}

}