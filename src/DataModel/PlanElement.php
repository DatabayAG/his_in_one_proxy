<?php

namespace HisInOneProxy\DataModel;

use HisInOneProxy\DataModel\Traits;
use HisInOneProxy\Exceptions;

class PlanElement
{
	use Traits\AcademicYear, Traits\Achievements, Traits\CompulsoryRequirement,  Traits\Contents, Traits\Credits, Traits\DefaultLanguage, 
		Traits\ExternOrganizer, Traits\GenderId, Traits\Grading, Traits\Literature, Traits\LearningTarget, Traits\LockVersion,
		Traits\ObjectiveQualification, Traits\ObjGuid,  Traits\RecommendedRequirement, Traits\TargetGroup, Traits\TeachingLanguageId,
		Traits\TeachingMethod, Traits\TermTypeValueId, Traits\Text, Traits\UnitId, Traits\Workload, Traits\Year;

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
