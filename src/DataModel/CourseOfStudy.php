<?php
namespace HisInOneProxy\DataModel;

use HisInOneProxy\DataModel\Traits;

class CourseOfStudy
{
	use Traits\DefaultLanguage, Traits\OrgUnitId, Traits\Text, Traits\UniqueName;

	/**
	 * @var int
	 */
	protected $id;

	/**
	 * @var int
	 */
	protected $lid;

	/**
	 * @var int
	 */
	protected $academic_degree_value_id;

	/**
	 * @var int
	 */
	protected $admission_to_study_id;

	/**
	 * @var string
	 */
	protected $astat_degree;

	/**
	 * @var string
	 */
	protected $astat_subject;

	/**
	 * @var string
	 */
	protected $combination_parameters;

	/**
	 * @var int
	 */
	protected $course_specialization_id;

	/**
	 * @var int
	 */
	protected $course_specialization_lid;


	/**
	 * @var int
	 */
	protected $degree_id;

	/**
	 * @var int
	 */
	protected $degree_lid;

	/**
	 * @var int
	 */
	protected $examination_version_id;
	/**
	 * @var int
	 */
	protected $form_of_studies_id;

	/**
	 * @var boolean
	 */
	protected $is_admission_to_study;

	/**
	 * @var boolean
	 */
	protected $is_course_of_study_start;

	/**
	 * @var int
	 */
	protected $major_field_of_study_id;

	/**
	 * @var int
	 */
	protected $major_field_of_study_lid;

	/**
	 * @var string
	 */
	protected $object_locale;

	/**
	 * @var int
	 */
	protected $part_of_studies;

	/**
	 * @var int
	 */
	protected $part_time_percentage;

	/**
	 * @var int
	 */
	protected $place_of_studies_id;

	/**
	 * @var int
	 */
	protected $regular_number_of_semesters;

	/**
	 * @var int
	 */
	protected $subject_id;

	/**
	 * @var int
	 */
	protected $subject_indicator_id;

	/**
	 * @var int
	 */
	protected $subject_lid;

	/**
	 * @var int
	 */
	protected $teaching_unit_org_unit_id;

	/**
	 * @var int
	 */
	protected $teaching_unit_org_unit_lid;

	/**
	 * @var int
	 */
	protected $type_of_study_id;

	/**
	 * @var \DateTime
	 */
	protected $valid_from;

	/**
	 * @var int
	 */
	protected $valid_from_term_term_type_value_id;

	/**
	 * @var int
	 */
	protected $valid_from_term_year;

	/**
	 * @var \DateTime
	 */
	protected $valid_to;

	/**
	 * @var int
	 */
	protected $valid_to_term_term_type_value_id;

	/**
	 * @var int
	 */
	protected $valid_to_term_year;

	/**
	 * @var int
	 */
	protected $enrollment_id;

	/**
	 * @return int
	 */
	public function getId()
	{
		return $this->id;
	}

	/**
	 * @param int $id
	 */
	public function setId($id)
	{
		$this->id = $id;
	}

	/**
	 * @return int
	 */
	public function getLid()
	{
		return $this->lid;
	}

	/**
	 * @param int $lid
	 */
	public function setLid($lid)
	{
		$this->lid = $lid;
	}

	/**
	 * @return int
	 */
	public function getAcademicDegreeValueId()
	{
		return $this->academic_degree_value_id;
	}

	/**
	 * @param int $academic_degree_value_id
	 */
	public function setAcademicDegreeValueId($academic_degree_value_id)
	{
		$this->academic_degree_value_id = $academic_degree_value_id;
	}

	/**
	 * @return int
	 */
	public function getAdmissionToStudyId()
	{
		return $this->admission_to_study_id;
	}

	/**
	 * @param int $admission_to_study_id
	 */
	public function setAdmissionToStudyId($admission_to_study_id)
	{
		$this->admission_to_study_id = $admission_to_study_id;
	}

	/**
	 * @return string
	 */
	public function getAstatDegree()
	{
		return $this->astat_degree;
	}

	/**
	 * @param string $astat_degree
	 */
	public function setAstatDegree($astat_degree)
	{
		$this->astat_degree = $astat_degree;
	}

	/**
	 * @return string
	 */
	public function getAstatSubject()
	{
		return $this->astat_subject;
	}

	/**
	 * @param string $astat_subject
	 */
	public function setAstatSubject($astat_subject)
	{
		$this->astat_subject = $astat_subject;
	}

	/**
	 * @return string
	 */
	public function getCombinationParameters()
	{
		return $this->combination_parameters;
	}

	/**
	 * @param string $combination_parameters
	 */
	public function setCombinationParameters($combination_parameters)
	{
		$this->combination_parameters = $combination_parameters;
	}

	/**
	 * @return int
	 */
	public function getCourseSpecializationId()
	{
		return $this->course_specialization_id;
	}

	/**
	 * @param int $course_specialization_id
	 */
	public function setCourseSpecializationId($course_specialization_id)
	{
		$this->course_specialization_id = $course_specialization_id;
	}

	/**
	 * @return int
	 */
	public function getCourseSpecializationLid()
	{
		return $this->course_specialization_lid;
	}

	/**
	 * @param int $course_specialization_lid
	 */
	public function setCourseSpecializationLid($course_specialization_lid)
	{
		$this->course_specialization_lid = $course_specialization_lid;
	}

	/**
	 * @return int
	 */
	public function getDegreeId()
	{
		return $this->degree_id;
	}

	/**
	 * @param int $degree_id
	 */
	public function setDegreeId($degree_id)
	{
		$this->degree_id = $degree_id;
	}

	/**
	 * @return int
	 */
	public function getDegreeLid()
	{
		return $this->degree_lid;
	}

	/**
	 * @param int $degree_lid
	 */
	public function setDegreeLid($degree_lid)
	{
		$this->degree_lid = $degree_lid;
	}

	/**
	 * @return int
	 */
	public function getExaminationVersionId()
	{
		return $this->examination_version_id;
	}

	/**
	 * @param int $examination_version_id
	 */
	public function setExaminationVersionId($examination_version_id)
	{
		$this->examination_version_id = $examination_version_id;
	}

	/**
	 * @return int
	 */
	public function getFormOfStudiesId()
	{
		return $this->form_of_studies_id;
	}

	/**
	 * @param int $form_of_studies_id
	 */
	public function setFormOfStudiesId($form_of_studies_id)
	{
		$this->form_of_studies_id = $form_of_studies_id;
	}

	/**
	 * @return bool
	 */
	public function isAdmissionToStudy()
	{
		return $this->is_admission_to_study;
	}

	/**
	 * @param bool $is_admission_to_study
	 */
	public function setIsAdmissionToStudy($is_admission_to_study)
	{
		$this->is_admission_to_study = $is_admission_to_study;
	}

	/**
	 * @return bool
	 */
	public function isCourseOfStudyStart()
	{
		return $this->is_course_of_study_start;
	}

	/**
	 * @param bool $is_course_of_study_start
	 */
	public function setIsCourseOfStudyStart($is_course_of_study_start)
	{
		$this->is_course_of_study_start = $is_course_of_study_start;
	}

	/**
	 * @return int
	 */
	public function getMajorFieldOfStudyId()
	{
		return $this->major_field_of_study_id;
	}

	/**
	 * @param int $major_field_of_study_id
	 */
	public function setMajorFieldOfStudyId($major_field_of_study_id)
	{
		$this->major_field_of_study_id = $major_field_of_study_id;
	}

	/**
	 * @return int
	 */
	public function getMajorFieldOfStudyLid()
	{
		return $this->major_field_of_study_lid;
	}

	/**
	 * @param int $major_field_of_study_lid
	 */
	public function setMajorFieldOfStudyLid($major_field_of_study_lid)
	{
		$this->major_field_of_study_lid = $major_field_of_study_lid;
	}

	/**
	 * @return string
	 */
	public function getObjectLocale()
	{
		return $this->object_locale;
	}

	/**
	 * @param string $object_locale
	 */
	public function setObjectLocale($object_locale)
	{
		$this->object_locale = $object_locale;
	}

	/**
	 * @return int
	 */
	public function getPartOfStudies()
	{
		return $this->part_of_studies;
	}

	/**
	 * @param int $part_of_studies
	 */
	public function setPartOfStudies($part_of_studies)
	{
		$this->part_of_studies = $part_of_studies;
	}

	/**
	 * @return int
	 */
	public function getPartTimePercentage()
	{
		return $this->part_time_percentage;
	}

	/**
	 * @param int $part_time_percentage
	 */
	public function setPartTimePercentage($part_time_percentage)
	{
		$this->part_time_percentage = $part_time_percentage;
	}

	/**
	 * @return int
	 */
	public function getPlaceOfStudiesId()
	{
		return $this->place_of_studies_id;
	}

	/**
	 * @param int $place_of_studies_id
	 */
	public function setPlaceOfStudiesId($place_of_studies_id)
	{
		$this->place_of_studies_id = $place_of_studies_id;
	}

	/**
	 * @return int
	 */
	public function getRegularNumberOfSemesters()
	{
		return $this->regular_number_of_semesters;
	}

	/**
	 * @param int $regular_number_of_semesters
	 */
	public function setRegularNumberOfSemesters($regular_number_of_semesters)
	{
		$this->regular_number_of_semesters = $regular_number_of_semesters;
	}

	/**
	 * @return int
	 */
	public function getSubjectId()
	{
		return $this->subject_id;
	}

	/**
	 * @param int $subject_id
	 */
	public function setSubjectId($subject_id)
	{
		$this->subject_id = $subject_id;
	}

	/**
	 * @return int
	 */
	public function getSubjectIndicatorId()
	{
		return $this->subject_indicator_id;
	}

	/**
	 * @param int $subject_indicator_id
	 */
	public function setSubjectIndicatorId($subject_indicator_id)
	{
		$this->subject_indicator_id = $subject_indicator_id;
	}

	/**
	 * @return int
	 */
	public function getSubjectLid()
	{
		return $this->subject_lid;
	}

	/**
	 * @param int $subject_lid
	 */
	public function setSubjectLid($subject_lid)
	{
		$this->subject_lid = $subject_lid;
	}

	/**
	 * @return int
	 */
	public function getTeachingUnitOrgUnitId()
	{
		return $this->teaching_unit_org_unit_id;
	}

	/**
	 * @param int $teaching_unit_org_unit_id
	 */
	public function setTeachingUnitOrgUnitId($teaching_unit_org_unit_id)
	{
		$this->teaching_unit_org_unit_id = $teaching_unit_org_unit_id;
	}

	/**
	 * @return int
	 */
	public function getTeachingUnitOrgUnitLid()
	{
		return $this->teaching_unit_org_unit_lid;
	}

	/**
	 * @param int $teaching_unit_org_unit_lid
	 */
	public function setTeachingUnitOrgUnitLid($teaching_unit_org_unit_lid)
	{
		$this->teaching_unit_org_unit_lid = $teaching_unit_org_unit_lid;
	}

	/**
	 * @return int
	 */
	public function getTypeOfStudyId()
	{
		return $this->type_of_study_id;
	}

	/**
	 * @param int $type_of_study_id
	 */
	public function setTypeOfStudyId($type_of_study_id)
	{
		$this->type_of_study_id = $type_of_study_id;
	}

	/**
	 * @return \DateTime
	 */
	public function getValidFrom()
	{
		return $this->valid_from;
	}

	/**
	 * @param \DateTime $valid_from
	 */
	public function setValidFrom($valid_from)
	{
		$this->valid_from = $valid_from;
	}

	/**
	 * @return int
	 */
	public function getValidFromTermTermTypeValueId()
	{
		return $this->valid_from_term_term_type_value_id;
	}

	/**
	 * @param int $valid_from_term_term_type_value_id
	 */
	public function setValidFromTermTermTypeValueId($valid_from_term_term_type_value_id)
	{
		$this->valid_from_term_term_type_value_id = $valid_from_term_term_type_value_id;
	}

	/**
	 * @return int
	 */
	public function getValidFromTermYear()
	{
		return $this->valid_from_term_year;
	}

	/**
	 * @param int $valid_from_term_year
	 */
	public function setValidFromTermYear($valid_from_term_year)
	{
		$this->valid_from_term_year = $valid_from_term_year;
	}

	/**
	 * @return \DateTime
	 */
	public function getValidTo()
	{
		return $this->valid_to;
	}

	/**
	 * @param \DateTime $valid_to
	 */
	public function setValidTo($valid_to)
	{
		$this->valid_to = $valid_to;
	}

	/**
	 * @return int
	 */
	public function getValidToTermTermTypeValueId()
	{
		return $this->valid_to_term_term_type_value_id;
	}

	/**
	 * @param int $valid_to_term_term_type_value_id
	 */
	public function setValidToTermTermTypeValueId($valid_to_term_term_type_value_id)
	{
		$this->valid_to_term_term_type_value_id = $valid_to_term_term_type_value_id;
	}

	/**
	 * @return int
	 */
	public function getValidToTermYear()
	{
		return $this->valid_to_term_year;
	}

	/**
	 * @param int $valid_to_term_year
	 */
	public function setValidToTermYear($valid_to_term_year)
	{
		$this->valid_to_term_year = $valid_to_term_year;
	}

	/**
	 * @return int
	 */
	public function getEnrollmentId()
	{
		return $this->enrollment_id;
	}

	/**
	 * @param int $enrollment_id
	 */
	public function setEnrollmentId($enrollment_id)
	{
		$this->enrollment_id = $enrollment_id;
	}
}