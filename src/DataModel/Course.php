<?php

namespace HisInOneProxy\DataModel;

use HisInOneProxy\DataModel\Traits;

class Course
{
	use Traits\AcademicYear, Traits\Contents, Traits\Credits, Traits\Literature, Traits\LockVersion, Traits\ObjGuid, Traits\UnitId, Traits\Workload;

	/**
	 * @var string
	 */
	protected $class_attendance;

	/**
	 * @var string
	 */
	protected $compulsory_requirement;

	/**
	 * @var string
	 */
	protected $course_achievement;

	/**
	 * @var string
	 */
	protected $directive;

	/**
	 * @var int
	 */
	protected $event_type_id;

	/**
	 * @var string
	 */
	protected $examination_achievement;

	/**
	 * @var string
	 */
	protected $extern_organizer;

	/**
	 * @var int
	 */
	protected $frequency_of_offer_value_id;

	/**
	 * @var string
	 */
	protected $grading;

	/**
	 * @var string
	 */
	protected $independent_study;

	/**
	 * @var string
	 */
	protected $intended_semester;

	/**
	 * @var string
	 */
	protected $learning_target;

	/**
	 * @var string
	 */
	protected $objective_qualification;

	/**
	 * @var string
	 */
	protected $recommendation;

	/**
	 * @var string
	 */
	protected $recommended_requirement;

	/**
	 * @var int
	 */
	protected $scheduled_group_size;

	/**
	 * @var string
	 */
	protected $target_group;

	/**
	 * @var int
	 */
	protected $teaching_k_language_id;

	/**
	 * @var string
	 */
	protected $teaching_method;

	/**
	 * @return string
	 */
	public function getClassAttendance()
	{
		return $this->class_attendance;
	}

	/**
	 * @param string $class_attendance
	 */
	public function setClassAttendance($class_attendance)
	{
		$this->class_attendance = $class_attendance;
	}

	/**
	 * @return string
	 */
	public function getCompulsoryRequirement()
	{
		return $this->compulsory_requirement;
	}

	/**
	 * @param string $compulsory_requirement
	 */
	public function setCompulsoryRequirement($compulsory_requirement)
	{
		$this->compulsory_requirement = $compulsory_requirement;
	}

	/**
	 * @return string
	 */
	public function getCourseAchievement()
	{
		return $this->course_achievement;
	}

	/**
	 * @param string $course_achievement
	 */
	public function setCourseAchievement($course_achievement)
	{
		$this->course_achievement = $course_achievement;
	}

	/**
	 * @return string
	 */
	public function getDirective()
	{
		return $this->directive;
	}

	/**
	 * @param string $directive
	 */
	public function setDirective($directive)
	{
		$this->directive = $directive;
	}

	/**
	 * @return int
	 */
	public function getEventTypeId()
	{
		return $this->event_type_id;
	}

	/**
	 * @param int $event_type_id
	 */
	public function setEventTypeId($event_type_id)
	{
		$this->event_type_id = $event_type_id;
	}

	/**
	 * @return string
	 */
	public function getExaminationAchievement()
	{
		return $this->examination_achievement;
	}

	/**
	 * @param string $examination_achievement
	 */
	public function setExaminationAchievement($examination_achievement)
	{
		$this->examination_achievement = $examination_achievement;
	}

	/**
	 * @return string
	 */
	public function getExternOrganizer()
	{
		return $this->extern_organizer;
	}

	/**
	 * @param string $extern_organizer
	 */
	public function setExternOrganizer($extern_organizer)
	{
		$this->extern_organizer = $extern_organizer;
	}

	/**
	 * @return int
	 */
	public function getFrequencyOfOfferValueId()
	{
		return $this->frequency_of_offer_value_id;
	}

	/**
	 * @param int $frequency_of_offer_value_id
	 */
	public function setFrequencyOfOfferValueId($frequency_of_offer_value_id)
	{
		$this->frequency_of_offer_value_id = $frequency_of_offer_value_id;
	}

	/**
	 * @return string
	 */
	public function getGrading()
	{
		return $this->grading;
	}

	/**
	 * @param string $grading
	 */
	public function setGrading($grading)
	{
		$this->grading = $grading;
	}

	/**
	 * @return string
	 */
	public function getIndependentStudy()
	{
		return $this->independent_study;
	}

	/**
	 * @param string $independent_study
	 */
	public function setIndependentStudy($independent_study)
	{
		$this->independent_study = $independent_study;
	}

	/**
	 * @return string
	 */
	public function getIntendedSemester()
	{
		return $this->intended_semester;
	}

	/**
	 * @param string $intended_semester
	 */
	public function setIntendedSemester($intended_semester)
	{
		$this->intended_semester = $intended_semester;
	}

	/**
	 * @return string
	 */
	public function getLearningTarget()
	{
		return $this->learning_target;
	}

	/**
	 * @param string $learning_target
	 */
	public function setLearningTarget($learning_target)
	{
		$this->learning_target = $learning_target;
	}

	/**
	 * @return string
	 */
	public function getObjectiveQualification()
	{
		return $this->objective_qualification;
	}

	/**
	 * @param string $objective_qualification
	 */
	public function setObjectiveQualification($objective_qualification)
	{
		$this->objective_qualification = $objective_qualification;
	}

	/**
	 * @return string
	 */
	public function getRecommendation()
	{
		return $this->recommendation;
	}

	/**
	 * @param string $recommendation
	 */
	public function setRecommendation($recommendation)
	{
		$this->recommendation = $recommendation;
	}

	/**
	 * @return string
	 */
	public function getRecommendedRequirement()
	{
		return $this->recommended_requirement;
	}

	/**
	 * @param string $recommended_requirement
	 */
	public function setRecommendedRequirement($recommended_requirement)
	{
		$this->recommended_requirement = $recommended_requirement;
	}

	/**
	 * @return int
	 */
	public function getScheduledGroupSize()
	{
		return $this->scheduled_group_size;
	}

	/**
	 * @param int $scheduled_group_size
	 */
	public function setScheduledGroupSize($scheduled_group_size)
	{
		$this->scheduled_group_size = $scheduled_group_size;
	}

	/**
	 * @return string
	 */
	public function getTargetGroup()
	{
		return $this->target_group;
	}

	/**
	 * @param string $target_group
	 */
	public function setTargetGroup($target_group)
	{
		$this->target_group = $target_group;
	}

	/**
	 * @return int
	 */
	public function getTeachingKLanguageId()
	{
		return $this->teaching_k_language_id;
	}

	/**
	 * @param int $teaching_k_language_id
	 */
	public function setTeachingKLanguageId($teaching_k_language_id)
	{
		$this->teaching_k_language_id = $teaching_k_language_id;
	}

	/**
	 * @return string
	 */
	public function getTeachingMethod()
	{
		return $this->teaching_method;
	}

	/**
	 * @param string $teaching_method
	 */
	public function setTeachingMethod($teaching_method)
	{
		$this->teaching_method = $teaching_method;
	}

}
