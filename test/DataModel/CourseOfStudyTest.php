<?php
require_once './libs/composer/vendor/autoload.php';

use  HisInOneProxy\DataModel;

/**
 * Class CourseOfStudyTest
 */
class CourseOfStudyTest extends PHPUnit\Framework\TestCase
{

	/**
	 * @var DataModel\CourseOfStudy $instance
	 */
	protected $instance;

	protected function setUp()
	{
		$this->instance = new DataModel\CourseOfStudy();
	}

	public function test_instantiateObject_shouldReturnInstance()
	{
		$this->assertInstanceOf('HisInOneProxy\DataModel\CourseOfStudy', $this->instance);
	}

	public function test_getId_shouldReturnId()
	{
		$this->instance->setId(1);
		$this->assertEquals(1, $this->instance->getId());
	}

	public function test_getLid_shouldReturnValue()
	{
		$this->instance->setLid(2);
		$this->assertEquals(2, $this->instance->getLid());
	}

	public function test_getAcademicDegreeValueId_shouldReturnValue()
	{
		$this->instance->setAcademicDegreeValueId(3);
		$this->assertEquals(3, $this->instance->getAcademicDegreeValueId());
	}

	public function test_getAdmissionToStudyId_shouldReturnValue()
	{
		$this->instance->setAdmissionToStudyId(4);
		$this->assertEquals(4, $this->instance->getAdmissionToStudyId());
	}

	public function test_getAstatDegree_shouldReturnValue()
	{
		$this->instance->setAstatDegree('hello 1');
		$this->assertEquals('hello 1', $this->instance->getAstatDegree());
	}

	public function test_getAstatSubject_shouldReturnValue()
	{
		$this->instance->setAstatSubject('hello 2');
		$this->assertEquals('hello 2', $this->instance->getAstatSubject());
	}

	public function test_getCourseSpecializationId_shouldReturnValue()
	{
		$this->instance->setCourseSpecializationId(6);
		$this->assertEquals(6, $this->instance->getCourseSpecializationId());
	}

	public function test_getCourseSpecializationLid_shouldReturnValue()
	{
		$this->instance->setCourseSpecializationLid(7);
		$this->assertEquals(7, $this->instance->getCourseSpecializationLid());
	}

	public function test_getDefaultLanguage_shouldReturnValue()
	{
		$this->instance->setDefaultLanguage(8);
		$this->assertEquals(8, $this->instance->getDefaultLanguage());
	}

	public function test_getDegreeId_shouldReturnValue()
	{
		$this->instance->setDegreeId(9);
		$this->assertEquals(9, $this->instance->getDegreeId());
	}

	public function test_getDegreeLid_shouldReturnValue()
	{
		$this->instance->setDegreeLid(10);
		$this->assertEquals(10, $this->instance->getDegreeLid());
	}

	public function test_getExaminationVersionId_shouldReturnValue()
	{
		$this->instance->setExaminationVersionId(11);
		$this->assertEquals(11, $this->instance->getExaminationVersionId());
	}

	public function test_getFormOfStudiesId_shouldReturnValue()
	{
		$this->instance->setFormOfStudiesId(12);
		$this->assertEquals(12, $this->instance->getFormOfStudiesId());
	}

	public function test_isAdmissionToStudy_shouldReturnValue()
	{
		$this->instance->setIsAdmissionToStudy(false);
		$this->assertEquals(false, $this->instance->isAdmissionToStudy());
	}

	public function test_isCourseOfStudyStart_shouldReturnValue()
	{
		$this->instance->setIsCourseOfStudyStart(true);
		$this->assertEquals(true, $this->instance->isCourseOfStudyStart());
	}

	public function test_getMajorFieldOfStudyId_shouldReturnValue()
	{
		$this->instance->setMajorFieldOfStudyId(13);
		$this->assertEquals(13, $this->instance->getMajorFieldOfStudyId());
	}

	public function test_getMajorFieldOfStudyLid_shouldReturnValue()
	{
		$this->instance->setMajorFieldOfStudyLid(14);
		$this->assertEquals(14, $this->instance->getMajorFieldOfStudyLid());
	}

	public function test_getObjectLocale_shouldReturnValue()
	{
		$this->instance->setObjectLocale(13);
		$this->assertEquals(13, $this->instance->getObjectLocale());
	}

	public function test_getOrgUnitId_shouldReturnValue()
	{
		$this->instance->setOrgUnitId(14);
		$this->assertEquals(14, $this->instance->getOrgUnitId());
	}

	public function test_getOrgUnitLid_shouldReturnValue()
	{
		$this->instance->setOrgUnitLid(15);
		$this->assertEquals(15, $this->instance->getOrgUnitLid());
	}

	public function test_getPartOfStudies_shouldReturnValue()
	{
		$this->instance->setPartOfStudies(16);
		$this->assertEquals(16, $this->instance->getPartOfStudies());
	}

	public function test_getPartTimePercentage_shouldReturnValue()
	{
		$this->instance->setPartTimePercentage(17);
		$this->assertEquals(17, $this->instance->getPartTimePercentage());
	}

	public function test_getPlaceOfStudiesId_shouldReturnValue()
	{
		$this->instance->setPlaceOfStudiesId(18);
		$this->assertEquals(18, $this->instance->getPlaceOfStudiesId());
	}

	public function test_getRegularNumberOfSemesters_shouldReturnValue()
	{
		$this->instance->setRegularNumberOfSemesters(19);
		$this->assertEquals(19, $this->instance->getRegularNumberOfSemesters());
	}

	public function test_getSubjectId_shouldReturnValue()
	{
		$this->instance->setSubjectId(20);
		$this->assertEquals(20, $this->instance->getSubjectId());
	}

	public function test_getSubjectIndicatorId_shouldReturnValue()
	{
		$this->instance->setSubjectIndicatorId(21);
		$this->assertEquals(21, $this->instance->getSubjectIndicatorId());
	}

	public function test_getSubjectLid_shouldReturnValue()
	{
		$this->instance->setSubjectLid(21);
		$this->assertEquals(21, $this->instance->getSubjectLid());
	}

	public function test_getTeachingUnitOrgUnitId_shouldReturnValue()
	{
		$this->instance->setTeachingUnitOrgUnitId(22);
		$this->assertEquals(22, $this->instance->getTeachingUnitOrgUnitId());
	}

	public function test_getTeachingUnitOrgUnitLid_shouldReturnValue()
	{
		$this->instance->setTeachingUnitOrgUnitLid(23);
		$this->assertEquals(23, $this->instance->getTeachingUnitOrgUnitLid());
	}

	public function test_getTypeOfStudyId_shouldReturnValue()
	{
		$this->instance->setTypeOfStudyId(24);
		$this->assertEquals(24, $this->instance->getTypeOfStudyId());
	}

	public function test_getUniqueName_shouldReturnValue()
	{
		$this->instance->setUniqueName('Tim');
		$this->assertEquals('Tim', $this->instance->getUniqueName());
	}

	public function test_getValidFrom_shouldReturnValue()
	{
		$date = new DateTime('now');
		$this->instance->setValidFrom($date);
		$this->assertEquals($date, $this->instance->getValidFrom());
	}

	public function test_getValidFromTermTermTypeValueId_shouldReturnValue()
	{
		$this->instance->setValidFromTermTermTypeValueId(25);
		$this->assertEquals(25, $this->instance->getValidFromTermTermTypeValueId());
	}

	public function test_getValidFromTermYear_shouldReturnValue()
	{
		$this->instance->setValidFromTermYear(26);
		$this->assertEquals(26, $this->instance->getValidFromTermYear());
	}

	public function test_getValidTo_shouldReturnValue()
	{
		$date = new DateTime('now');
		$this->instance->setValidTo($date);
		$this->assertEquals($date, $this->instance->getValidTo());
	}

	public function test_getValidToTermTermTypeValueId_shouldReturnValue()
	{
		$this->instance->setValidToTermTermTypeValueId(27);
		$this->assertEquals(27, $this->instance->getValidToTermTermTypeValueId());
	}

	public function test_getValidToTermYear_shouldReturnValue()
	{
		$this->instance->setValidToTermYear(28);
		$this->assertEquals(28, $this->instance->getValidToTermYear());
	}

	public function test_getCombinationParameters_shouldReturnValue()
	{
		$this->instance->setCombinationParameters(29);
		$this->assertEquals(29, $this->instance->getCombinationParameters());
	}

	public function test_getEnrollmentId_shouldReturnValue()
	{
		$this->instance->setEnrollmentId(30);
		$this->assertEquals(30, $this->instance->getEnrollmentId());
	}
}