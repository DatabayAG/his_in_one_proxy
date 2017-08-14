<?php

namespace HisInOneProxy\Parser;

use HisInOneProxy\DataModel\CourseOfStudy;

/**
 * Class ParseCourseOfStudy
 * @package HisInOneProxy\Parser
 */
class ParseCourseOfStudy extends SimpleXmlParser
{
	/**
	 * @param $xml
	 * @return CourseOfStudy
	 */
	public function parse($xml)
	{
		$course_of_study = new CourseOfStudy();

		if($this->isAttributeValid($xml, 'id'))
		{
			$course_of_study->setId($xml->id);
			$this->log->info(sprintf('Found course of study with id %s.', $course_of_study->getId()));
			if($this->isAttributeValid($xml, 'academicdegreeValueId'))
			{
				$course_of_study->setAcademicDegreeValueId($xml->academicdegreeValueId);
			}
			if($this->isAttributeValid($xml, 'admissionToStudyId'))
			{
				$course_of_study->setAdmissionToStudyId($xml->admissionToStudyId);
			}
			if($this->isAttributeValid($xml, 'astatDegree'))
			{
				$course_of_study->setAstatDegree($xml->astatDegree);
			}
			if($this->isAttributeValid($xml, 'astatSubject'))
			{
				$course_of_study->setAstatSubject($xml->astatSubject);
			}
			if($this->isAttributeValid($xml, 'courseOfStudyTypeValueId'))
			{
				$course_of_study->setValidFromTermTermTypeValueId($xml->courseOfStudyTypeValueId);
			}
			if($this->isAttributeValid($xml, 'courseSpecializationId'))
			{
				$course_of_study->setCourseSpecializationId($xml->courseSpecializationId);
			}
			if($this->isAttributeValid($xml, 'courseSpecializationLid'))
			{
				$course_of_study->setCourseSpecializationLid($xml->courseSpecializationLid);
			}
			if($this->isAttributeValid($xml, 'defaultlanguage'))
			{
				$course_of_study->setDefaultLanguage($xml->defaultlanguage);
			}
			if($this->isAttributeValid($xml, 'defaulttext'))
			{
				$course_of_study->setDefaultText($xml->defaulttext);
			}
			if($this->isAttributeValid($xml, 'degreeId'))
			{
				$course_of_study->setDegreeId($xml->degreeId);
			}
			if($this->isAttributeValid($xml, 'degreeLid'))
			{
				$course_of_study->setDegreeLid($xml->degreeLid);
			}
			if($this->isAttributeValid($xml, 'enrollmentId'))
			{
				$course_of_study->setEnrollmentId($xml->enrollmentId);
			}
			if($this->isAttributeValid($xml, 'examinationversionId'))
			{
				$course_of_study->setExaminationVersionId($xml->examinationversionId);
			}
			if($this->isAttributeValid($xml, 'formOfStudiesId'))
			{
				$course_of_study->setFormOfStudiesId($xml->formOfStudiesId);
			}
			if($this->isAttributeValid($xml, 'isAdmissionToStudy'))
			{
				$course_of_study->setIsAdmissionToStudy($xml->isAdmissionToStudy);
			}
			if($this->isAttributeValid($xml, 'isCourseOfStudyStart'))
			{
				$course_of_study->setIsCourseOfStudyStart($xml->isCourseOfStudyStart);
			}
			if($this->isAttributeValid($xml, 'lid'))
			{
				$course_of_study->setLid($xml->lid);
			}
			if($this->isAttributeValid($xml, 'longtext'))
			{
				$course_of_study->setLongText($xml->longtext);
			}
			if($this->isAttributeValid($xml, 'majorFieldOfStudyId'))
			{
				$course_of_study->setMajorFieldOfStudyId($xml->majorFieldOfStudyId);
			}
			if($this->isAttributeValid($xml, 'majorFieldOfStudyLid'))
			{
				$course_of_study->setMajorFieldOfStudyLid($xml->majorFieldOfStudyLid);
			}
			if($this->isAttributeValid($xml, 'objectLocale'))
			{
				$course_of_study->setObjectLocale($xml->objectLocale);
			}
			if($this->isAttributeValid($xml, 'orgunitId'))
			{
				$course_of_study->setOrgUnitId($xml->orgunitId);
			}
			if($this->isAttributeValid($xml, 'orgunitLid'))
			{
				$course_of_study->setOrgUnitLid($xml->orgunitLid);
			}
			if($this->isAttributeValid($xml, 'partOfStudies'))
			{
				$course_of_study->setPartOfStudies($xml->partOfStudies);
			}
			if($this->isAttributeValid($xml, 'partTimePercentage'))
			{
				$course_of_study->setPartTimePercentage($xml->partTimePercentage);
			}
			if($this->isAttributeValid($xml, 'placeOfStudiesId'))
			{
				$course_of_study->setPlaceOfStudiesId($xml->placeOfStudiesId);
			}
			if($this->isAttributeValid($xml, 'regularNumberOfSemesters'))
			{
				$course_of_study->setRegularNumberOfSemesters($xml->regularNumberOfSemesters);
			}
			if($this->isAttributeValid($xml, 'shorttext'))
			{
				$course_of_study->setShortText($xml->shorttext);
			}
			if($this->isAttributeValid($xml, 'subjectId'))
			{
				$course_of_study->setSubjectId($xml->subjectId);
			}
			if($this->isAttributeValid($xml, 'subjectIndicatorId'))
			{
				$course_of_study->setSubjectIndicatorId($xml->subjectIndicatorId);
			}
			if($this->isAttributeValid($xml, 'subjectLid'))
			{
				$course_of_study->setSubjectLid($xml->subjectLid);
			}
			if($this->isAttributeValid($xml, 'teachingunitOrgunitId'))
			{
				$course_of_study->setTeachingUnitOrgUnitId($xml->teachingunitOrgunitId);
			}
			if($this->isAttributeValid($xml, 'teachingunitOrgunitLid'))
			{
				$course_of_study->setTeachingUnitOrgUnitLid($xml->teachingunitOrgunitLid);
			}
			if($this->isAttributeValid($xml, 'typeOfStudyId'))
			{
				$course_of_study->setTypeOfStudyId($xml->typeOfStudyId);
			}
			if($this->isAttributeValid($xml, 'uniquename'))
			{
				$course_of_study->setUniqueName($xml->uniquename);
			}
			if($this->isAttributeValid($xml, 'validFrom'))
			{
				$course_of_study->setValidFrom($xml->validFrom);
			}
			if($this->isAttributeValid($xml, 'validFromTermTermTypeValueId'))
			{
				$course_of_study->setValidFromTermTermTypeValueId($xml->validFromTermTermTypeValueId);
			}
			if($this->isAttributeValid($xml, 'validFromTermYear'))
			{
				$course_of_study->setValidFromTermYear($xml->validFromTermYear);
			}
			if($this->isAttributeValid($xml, 'validTo'))
			{
				$course_of_study->setValidTo($xml->validTo);
			}
			if($this->isAttributeValid($xml, 'validToTermTermTypeValueId'))
			{
				$course_of_study->setValidToTermTermTypeValueId($xml->validToTermTermTypeValueId);
			}
			if($this->isAttributeValid($xml, 'validToTermYear'))
			{
				$course_of_study->setValidToTermYear($xml->validToTermYear);
			}
			if($this->isAttributeValid($xml, 'combinationParameter'))
			{
				$course_of_study->setCombinationParameters($xml->combinationParameter);
			}
		}
		else
		{
			$this->log->warning('No id given for course of study, skipping!');
		}

		return $course_of_study;
	}
}