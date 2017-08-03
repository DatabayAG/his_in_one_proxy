<?php

namespace HisInOneProxy\DataModel;

use HisInOneProxy\DataModel\Traits;

class EventDate
{
	use Traits\AcademicYear, Traits\Contents, Traits\Credits, Traits\PlanElementId, Traits\Literature, Traits\LockVersion, Traits\ObjGuid, Traits\Workload;


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
	protected $examination_achievement;

	/**
	 * @var string
	 */
	protected $extern_organizer;

	/**
	 * @var string
	 */
	protected $grading;

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
	protected $recommended_requirement;

	/**
	 * @var string
	 */
	protected $target_group;

	/**
	 * @var int
	 */
	protected $teaching_language_id;

	/**
	 * @var string
	 */
	protected $teaching_method;

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
	public function getTeachingLanguageId()
	{
		return $this->teaching_language_id;
	}

	/**
	 * @param int $teaching_language_id
	 */
	public function setTeachingLanguageId($teaching_language_id)
	{
		$this->teaching_language_id = $teaching_language_id;
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
