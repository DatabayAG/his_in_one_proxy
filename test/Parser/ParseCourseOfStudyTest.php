<?php

include_once './libs/composer/vendor/autoload.php';

use  HisInOneProxy\Parser;

require_once 'test/TestCaseExtension.php';

/**
 * Class ParseCourseOfStudyTest
 */
class ParseCourseOfStudyTest extends TestCaseExtension
{
	protected function setUp()
	{
		parent::setUp();
	}

	public function test_simpleCourseOfStudyIncompleteParsing_shouldReturnLogWarning()
	{
		$xml    = file_get_contents('test/fixtures/exam_relation.xml');
		$parser = new Parser\ParseCourseOfStudy($this->log);
		$parser->parse(simplexml_load_string('<personId></personId>') );
		$msg = array_pop($this->collectedMessages);
		$this->assertEquals('Warning: No id given for course of study, skipping!', $msg);
	}

	public function test_simpleExamRelation_shouldReturnExamRelation()
	{
		$xml      = file_get_contents('test/fixtures/course_of_study_children.xml');
		$parser   = new Parser\ParseCourseOfStudy($this->log);
		$course_of_study = $parser->parse(simplexml_load_string($xml));
		$this->assertEquals('6756876', $course_of_study->getId());
		$msg = array_pop($this->collectedMessages);
		$this->assertEquals('Info: Found course of study with id 6756876.', $msg);
		$this->assertEquals('17', $course_of_study->getLid());
		$this->assertEquals('1', $course_of_study->getAcademicDegreeValueId());
		$this->assertEquals('2', $course_of_study->getAdmissionToStudyId());
		$this->assertEquals('3', $course_of_study->getAstatDegree());
		$this->assertEquals('4', $course_of_study->getAstatSubject());
		$this->assertEquals('6', $course_of_study->getCourseSpecializationId());
		$this->assertEquals('7', $course_of_study->getCourseSpecializationLid());
		$this->assertEquals('8', $course_of_study->getDefaultLanguage());
		$this->assertEquals('10', $course_of_study->getDegreeId());
		$this->assertEquals('11', $course_of_study->getDegreeLid());
		$this->assertEquals('13', $course_of_study->getExaminationVersionId());
		$this->assertEquals('14', $course_of_study->getFormOfStudiesId());
		$this->assertEquals('15', $course_of_study->isAdmissionToStudy());
		$this->assertEquals('16', $course_of_study->isCourseOfStudyStart());
		$this->assertEquals('18', $course_of_study->getMajorFieldOfStudyId());
		$this->assertEquals('19', $course_of_study->getMajorFieldOfStudyLid());
		$this->assertEquals('20', $course_of_study->getObjectLocale());
		$this->assertEquals('21', $course_of_study->getOrgUnitId());
		$this->assertEquals('22', $course_of_study->getOrgUnitLid());
		$this->assertEquals('23', $course_of_study->getPartOfStudies());
		$this->assertEquals('24', $course_of_study->getPartTimePercentage());
		$this->assertEquals('25', $course_of_study->getPlaceOfStudiesId());
		$this->assertEquals('26', $course_of_study->getRegularNumberOfSemesters());
		$this->assertEquals('27', $course_of_study->getSubjectId());
		$this->assertEquals('28', $course_of_study->getSubjectIndicatorId());
		$this->assertEquals('29', $course_of_study->getSubjectLid());
		$this->assertEquals('30', $course_of_study->getTeachingUnitOrgUnitId());
		$this->assertEquals('31', $course_of_study->getTeachingUnitOrgUnitLid());
		$this->assertEquals('32', $course_of_study->getTypeOfStudyId());
		$this->assertEquals('Uniquename', $course_of_study->getUniqueName());
		$this->assertEquals('2017-12-24', $course_of_study->getValidFrom());
		$this->assertEquals('33', $course_of_study->getValidFromTermTermTypeValueId());
		$this->assertEquals('2018', $course_of_study->getValidFromTermYear());
		$this->assertEquals('2018-12-28', $course_of_study->getValidTo());
		$this->assertEquals('34', $course_of_study->getValidToTermTermTypeValueId());
		$this->assertEquals('2019', $course_of_study->getValidToTermYear());
		$this->assertEquals('35', $course_of_study->getCombinationParameters());
		$this->assertEquals('12', $course_of_study->getEnrollmentId());
	}
}