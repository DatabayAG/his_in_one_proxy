<?php

namespace HisInOneProxy\DataModel;

use HisInOneProxy\DataModel\Traits;
use HisInOneProxy\Exceptions;

class PlanElement
{
	use Traits\AcademicYear, Traits\Contents, Traits\Credits, Traits\DefaultLanguage, Traits\GenderId, Traits\Literature;
	use Traits\LockVersion, Traits\ObjGuid, Traits\TermTypeValueId, Traits\Text, Traits\UnitId, Traits\Workload, Traits\Year;

	/**
	 * @var int
	 */
	protected $attendee_maximum;

	/**
	 * @var int
	 */
	protected $attendee_minimum;

	/**
	 * @var \DateTime
	 */
	protected $cancel_end;

	/**
	 * @var int
	 */
	protected $cancelled;

	/**
	 * @var int
	 */
	protected $grade_assessment_status_id;

	/**
	 * @var int
	 */
	protected $hours_per_week;

	/**
	 * @var int
	 */
	protected $parallel_group_id;

	/**
	 * @var \DateTime
	 */
	protected $register_begin;

	/**
	 * @var \DateTime
	 */
	protected $register_end;

	/**
	 * @var int
	 */
	protected $rotation;

	/**
	 * @var int
	 */
	protected $term_segment;

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
	 * @var string
	 */
	protected $teaching_language_id;

	/**
	 * @var string
	 */
	protected $teaching_method;

	/**
	 * @var PersonPlanElement[]
	 */
	protected $person_plan_element_container = array();

	/**
	 * @var EventDate[]
	 */
	protected $event_date_container = array();

	/**
	 * @var PlannedDate[]
	 */
	protected $planned_date_container = array();

	/**
	 * @var PlanningPreference
	 */
	protected $planning_preference;

	/**
	 * @return int
	 */
	public function getAttendeeMaximum()
	{
		return $this->attendee_maximum;
	}

	/**
	 * @param int $attendee_maximum
	 */
	public function setAttendeeMaximum($attendee_maximum)
	{
		$this->attendee_maximum = $attendee_maximum;
	}

	/**
	 * @return int
	 */
	public function getAttendeeMinimum()
	{
		return $this->attendee_minimum;
	}

	/**
	 * @param int $attendee_minimum
	 */
	public function setAttendeeMinimum($attendee_minimum)
	{
		$this->attendee_minimum = $attendee_minimum;
	}

	/**
	 * @return \DateTime
	 */
	public function getCancelEnd()
	{
		return $this->cancel_end;
	}

	/**
	 * @param \DateTime $cancel_end
	 */
	public function setCancelEnd($cancel_end)
	{
		$this->cancel_end = $cancel_end;
	}

	/**
	 * @return int
	 */
	public function getCancelled()
	{
		return $this->cancelled;
	}

	/**
	 * @param int $cancelled
	 */
	public function setCancelled($cancelled)
	{
		$this->cancelled = $cancelled;
	}

	/**
	 * @return int
	 */
	public function getGradeAssessmentStatusId()
	{
		return $this->grade_assessment_status_id;
	}

	/**
	 * @param int $grade_assessment_status_id
	 */
	public function setGradeAssessmentStatusId($grade_assessment_status_id)
	{
		$this->grade_assessment_status_id = $grade_assessment_status_id;
	}

	/**
	 * @return int
	 */
	public function getHoursPerWeek()
	{
		return $this->hours_per_week;
	}

	/**
	 * @param int $hours_per_week
	 */
	public function setHoursPerWeek($hours_per_week)
	{
		$this->hours_per_week = $hours_per_week;
	}

	/**
	 * @return int
	 */
	public function getParallelGroupId()
	{
		return $this->parallel_group_id;
	}

	/**
	 * @param int $parallel_group_id
	 */
	public function setParallelGroupId($parallel_group_id)
	{
		$this->parallel_group_id = $parallel_group_id;
	}

	/**
	 * @return \DateTime
	 */
	public function getRegisterBegin()
	{
		return $this->register_begin;
	}

	/**
	 * @param \DateTime $register_begin
	 */
	public function setRegisterBegin($register_begin)
	{
		$this->register_begin = $register_begin;
	}

	/**
	 * @return \DateTime
	 */
	public function getRegisterEnd()
	{
		return $this->register_end;
	}

	/**
	 * @param \DateTime $register_end
	 */
	public function setRegisterEnd($register_end)
	{
		$this->register_end = $register_end;
	}

	/**
	 * @return int
	 */
	public function getRotation()
	{
		return $this->rotation;
	}

	/**
	 * @param int $rotation
	 */
	public function setRotation($rotation)
	{
		$this->rotation = $rotation;
	}

	/**
	 * @return int
	 */
	public function getTermSegment()
	{
		return $this->term_segment;
	}

	/**
	 * @param int $term_segment
	 */
	public function setTermSegment($term_segment)
	{
		$this->term_segment = $term_segment;
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
	 * @return string
	 */
	public function getTeachingLanguageId()
	{
		return $this->teaching_language_id;
	}

	/**
	 * @param string $teaching_language_id
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

	/**
	 * @return PersonPlanElement[]
	 */
	public function getPersonPlanElementContainer()
	{
		return $this->person_plan_element_container;
	}

	/**
	 * @param \HisInOneProxy\DataModel\PersonPlanElement | ExamRelation $person_plan_element
	 */
	public function appendPersonPlanElement($person_plan_element)
	{
		if(is_a($person_plan_element, '\HisInOneProxy\DataModel\PersonPlanElement') ||
			is_a($person_plan_element, '\HisInOneProxy\DataModel\ExamRelation'))
		{
			$this->person_plan_element_container[] = $person_plan_element;
		}
		else
		{
			throw new Exceptions\InvalidPersonPlanElement();
		}
	}

	/**
	 * @return EventDate[]
	 */
	public function getEventDateContainer()
	{
		return $this->event_date_container;
	}

	/**
	 * @param EventDate $event_date
	 */
	public function appendEventDate($event_date)
	{
		if(is_a($event_date, '\HisInOneProxy\DataModel\EventDate'))
		{
			$this->event_date_container[] = $event_date;
		}
		else
		{
			throw new Exceptions\InvalidEventDate();
		}
	}

	/**
	 * @return PlanningPreference
	 */
	public function getPlanningPreference()
	{
		return $this->planning_preference;
	}

	/**
	 * @param PlanningPreference $planning_preference
	 */
	public function setPlanningPreference($planning_preference)
	{
		$this->planning_preference = $planning_preference;
	}

	/**
	 * @return PlannedDate[]
	 */
	public function getPlannedDateContainer()
	{
		return $this->planned_date_container;
	}

	/**
	 * @param PlannedDate $planned_date
	 */
	public function appendPlannedDate($planned_date)
	{
		if(is_a($planned_date, '\HisInOneProxy\DataModel\PlannedDate'))
		{
			$this->planned_date_container[] = $planned_date;
		}
		else
		{
			throw new Exceptions\InvalidPlannedDate();
		}
	}
}
