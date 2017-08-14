<?php

namespace HisInOneProxy\DataModel;

use HisInOneProxy\DataModel\Traits;
use HisInOneProxy\Exceptions;

/**
 * Class PlannedDate
 * @package HisInOneProxy\DataModel
 */
class PlannedDate
{
	use Traits\PlanElementId, Traits\LockVersion, Traits\ObjGuid, Traits\RoomId, Traits\StartEndTime;

	/**
	 * @var int
	 */
	protected $academic_time_specification_id;

	/**
	 * @var string
	 */
	protected $end_date;

	/**
	 * @var string
	 */
	protected $expected_attendees_count;

	/**
	 * @var string
	 */
	protected $notice;

	/**
	 * @var int
	 */
	protected $rhythm_id;

	/**
	 * @var string
	 */
	protected $start_date;

	/**
	 * @var int
	 */
	protected $weekday_id;

	/**
	 * @var IndividualDate[]
	 */
	protected $individual_date_container = array();

	/**
	 * @var Instructor[]
	 */
	protected $instructor_container = array();

	/**
	 * @var PlanElementCancellation[]
	 */
	protected $plan_element_cancellation_container = array();

	/**
	 * @var PlanElementChange[]
	 */
	protected $plan_element_change_container = array();

	/**
	 * @return int
	 */
	public function getAcademicTimeSpecificationId()
	{
		return $this->academic_time_specification_id;
	}

	/**
	 * @param int $academic_time_specification_id
	 */
	public function setAcademicTimeSpecificationId($academic_time_specification_id)
	{
		$this->academic_time_specification_id = $academic_time_specification_id;
	}

	/**
	 * @return string
	 */
	public function getEndDate()
	{
		return $this->end_date;
	}

	/**
	 * @param string $end_date
	 */
	public function setEndDate($end_date)
	{
		$this->end_date = $end_date;
	}

	/**
	 * @return string
	 */
	public function getExpectedAttendeesCount()
	{
		return $this->expected_attendees_count;
	}

	/**
	 * @param string $expected_attendees_count
	 */
	public function setExpectedAttendeesCount($expected_attendees_count)
	{
		$this->expected_attendees_count = $expected_attendees_count;
	}

	/**
	 * @return string
	 */
	public function getNotice()
	{
		return $this->notice;
	}

	/**
	 * @param string $notice
	 */
	public function setNotice($notice)
	{
		$this->notice = $notice;
	}

	/**
	 * @return Instructor[]
	 */
	public function getInstructorContainer()
	{
		return $this->instructor_container;
	}

	/**
	 * @return int
	 */
	public function getRhythmId()
	{
		return $this->rhythm_id;
	}

	/**
	 * @param int $rhythm_id
	 */
	public function setRhythmId($rhythm_id)
	{
		$this->rhythm_id = $rhythm_id;
	}

	/**
	 * @return string
	 */
	public function getStartDate()
	{
		return $this->start_date;
	}

	/**
	 * @param string $start_date
	 */
	public function setStartDate($start_date)
	{
		$this->start_date = $start_date;
	}

	/**
	 * @return int
	 */
	public function getWeekdayId()
	{
		return $this->weekday_id;
	}

	/**
	 * @param int $weekday_id
	 */
	public function setWeekdayId($weekday_id)
	{
		$this->weekday_id = $weekday_id;
	}

	/**
	 * @param Instructor $instructor
	 */
	public function appendInstructor($instructor)
	{
		if(is_a($instructor, '\HisInOneProxy\DataModel\Instructor'))
		{
			$this->instructor_container[] = $instructor;
		}
		else
		{
			throw new Exceptions\InvalidInstructor();
		}
	}

	/**
	 * @return IndividualDate[]
	 */
	public function getIndividualDateContainer()
	{
		return $this->individual_date_container;
	}

	/**
	 * @param IndividualDate $individual_date
	 */
	public function appendIndividualDate($individual_date)
	{
		if(is_a($individual_date, '\HisInOneProxy\DataModel\IndividualDate'))
		{
			$this->individual_date_container[] = $individual_date;
		}
		else
		{
			throw new Exceptions\InvalidIndividualDate();
		}
	}

	/**
	 * @return PlanElementCancellation[]
	 */
	public function getPlanElementCancellationContainer()
	{
		return $this->plan_element_cancellation_container;
	}

	/**
	 * @param PlanElementCancellation $plan_element_cancellation
	 */
	public function appendPlanElementCancellation($plan_element_cancellation)
	{
		if(is_a($plan_element_cancellation, '\HisInOneProxy\DataModel\PlanElementCancellation'))
		{
			$this->plan_element_cancellation_container[] = $plan_element_cancellation;
		}
		else
		{
			throw new Exceptions\InvalidPlanElementCancellation();
		}
	}

	/**
	 * @return PlanElementChange[]
	 */
	public function getPlanElementChangeContainer()
	{
		return $this->plan_element_change_container;
	}

	/**
	 * @param PlanElementChange $plan_element_change
	 */
	public function appendPlanElementChange($plan_element_change)
	{
		if(is_a($plan_element_change, '\HisInOneProxy\DataModel\PlanElementChange'))
		{
			$this->plan_element_change_container[] = $plan_element_change;
		}
		else
		{
			throw new Exceptions\InvalidPlanElementChange();
		}
	}
}
