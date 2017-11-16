<?php
require_once './libs/composer/vendor/autoload.php';

use  HisInOneProxy\DataModel;

/**
 * Class CourseTest
 */
class CourseTest extends PHPUnit\Framework\TestCase
{

	/**
	 * @var DataModel\Course $instance
	 */
	protected $instance;

	protected function setUp()
	{
		$this->instance = new DataModel\Course();
	}

	public function test_instantiateObject_shouldReturnInstance()
	{
		$this->assertInstanceOf('HisInOneProxy\DataModel\Course', $this->instance);
	}

	public function test_getId_shouldReturnId()
	{
		$this->instance->setId(1);
		$this->assertEquals(1, $this->instance->getId());
	}

	public function test_getObjGuid_shouldReturnObjGuid()
	{
		$this->instance->setObjGuid(112);
		$this->assertEquals(112, $this->instance->getObjGuid());
	}

	public function test_getLockVersion_shouldReturnLockVersion()
	{
		$this->instance->setLockVersion(122);
		$this->assertEquals(122, $this->instance->getLockVersion());
	}

	public function test_getAcademicYear_shouldReturnAcademicYear()
	{
		$this->instance->setAcademicYear('WiSe 2017');
		$this->assertEquals('WiSe 2017', $this->instance->getAcademicYear());
	}

	public function test_getClassAttendance_shouldReturnClassAttendancen()
	{
		$this->instance->setClassAttendance('ClassAttendance');
		$this->assertEquals('ClassAttendance', $this->instance->getClassAttendance());
	}

	public function test_getCompulsoryRequirement_shouldReturnCompulsoryRequirement()
	{
		$this->instance->setCompulsoryRequirement('CompulsoryRequirement');
		$this->assertEquals('CompulsoryRequirement', $this->instance->getCompulsoryRequirement());
	}

	public function test_getContents_shouldReturnContents()
	{
		$this->instance->setContents('Contents');
		$this->assertEquals('Contents', $this->instance->getContents());
	}

	public function test_getCourseAchievement_shouldReturnCourseAchievement()
	{
		$this->instance->setCourseAchievement('Course Achievement');
		$this->assertEquals('Course Achievement', $this->instance->getCourseAchievement());
	}

	public function test_getCredits_shouldReturnCredits()
	{
		$this->instance->setCredits('Credits');
		$this->assertEquals('Credits', $this->instance->getCredits());
	}

	public function test_getDirective_shouldReturnDirective()
	{
		$this->instance->setDirective('Directive');
		$this->assertEquals('Directive', $this->instance->getDirective());
	}

	public function test_getEventTypeId_shouldReturnEventTypeId()
	{
		$this->instance->setEventTypeId(65);
		$this->assertEquals(65, $this->instance->getEventTypeId());
	}

	public function test_getExaminationAchievement_shouldReturnExaminationAchievement()
	{
		$this->instance->setExaminationAchievement('Examination Achievement');
		$this->assertEquals('Examination Achievement', $this->instance->getExaminationAchievement());
	}

	public function test_getExternOrganizer_shouldReturnExternOrganizer()
	{
		$this->instance->setExternOrganizer('ExternOrganizer');
		$this->assertEquals('ExternOrganizer', $this->instance->getExternOrganizer());
	}

	public function test_getFrequencyOfOfferValueId_shouldReturnFrequencyOfOfferValueId()
	{
		$this->instance->setFrequencyOfOfferValueId(4234234);
		$this->assertEquals(4234234, $this->instance->getFrequencyOfOfferValueId());
	}

	public function test_getGrading_shouldReturnGrading()
	{
		$this->instance->setGrading('Grading');
		$this->assertEquals('Grading', $this->instance->getGrading());
	}

	public function test_getIndependentStudy_shouldReturnIndependentStudy()
	{
		$this->instance->setIndependentStudy('IndependentStudy');
		$this->assertEquals('IndependentStudy', $this->instance->getIndependentStudy());
	}

	public function test_getIntendedSemester_shouldReturnIntendedSemester()
	{
		$this->instance->setIntendedSemester('IntendedSemester');
		$this->assertEquals('IntendedSemester', $this->instance->getIntendedSemester());
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

	public function test_getRecommendation_shouldReturnRecommendation()
	{
		$this->instance->setRecommendation('Recommendation');
		$this->assertEquals('Recommendation', $this->instance->getRecommendation());
	}

	public function test_getRecommendedRequirement_shouldReturnRecommendedRequirement()
	{
		$this->instance->setRecommendedRequirement('RecommendedRequirement');
		$this->assertEquals('RecommendedRequirement', $this->instance->getRecommendedRequirement());
	}

	public function test_getScheduledGroupSize_shouldReturnScheduledGroupSize()
	{
		$this->instance->setScheduledGroupSize(3);
		$this->assertEquals(3, $this->instance->getScheduledGroupSize());
	}

	public function test_getTargetGroup_shouldReturnTargetGroup()
	{
		$this->instance->setTargetGroup('TargetGroup');
		$this->assertEquals('TargetGroup', $this->instance->getTargetGroup());
	}

	public function test_getTeachingKLanguageId_shouldReturnTeachingKLanguageId()
	{
		$this->instance->setTeachingKLanguageId(1112312);
		$this->assertEquals(1112312, $this->instance->getTeachingKLanguageId());
	}

	public function test_getTeachingMethod_shouldReturnTeachingMethod()
	{
		$this->instance->setTeachingMethod('TeachingMethod');
		$this->assertEquals('TeachingMethod', $this->instance->getTeachingMethod());
	}

	public function test_getUnitId_shouldReturnUnitId()
	{
		$this->instance->setUnitId(1133312312);
		$this->assertEquals(1133312312, $this->instance->getUnitId());
	}

	public function test_getWorkload_shouldReturnWorkload()
	{
		$this->instance->setWorkload('Workload');
		$this->assertEquals('Workload', $this->instance->getWorkload());
	}

}