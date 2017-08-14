<?php

namespace HisInOneProxy\DataModel;

use HisInOneProxy\DataModel\Traits;
use HisInOneProxy\Exceptions;

/**
 * Class PlanElementChange
 * @package HisInOneProxy\DataModel
 */
class PlanElementChange
{
	use Traits\LanguageId, Traits\LockVersion, Traits\ObjGuid, Traits\PlannedDatesId, Traits\RoomId, Traits\StartEndTime;

	/**
	 * @var int
	 */
	protected $academic_time_specification_id;

	/**
	 * @var array
	 */
	protected $instructor_container = array();

	/**
	 * @var string
	 */
	protected $new_date;

	/**
	 * @var string
	 */
	protected $old_date;

	/**
	 * @var string
	 */
	protected $remark;

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
	 * @return Instructor[]
	 */
	public function getInstructorContainer()
	{
		return $this->instructor_container;
	}

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
	public function getNewDate()
	{
		return $this->new_date;
	}

	/**
	 * @param string $new_date
	 */
	public function setNewDate($new_date)
	{
		$this->new_date = $new_date;
	}

	/**
	 * @return string
	 */
	public function getOldDate()
	{
		return $this->old_date;
	}

	/**
	 * @param string $old_date
	 */
	public function setOldDate($old_date)
	{
		$this->old_date = $old_date;
	}

	/**
	 * @return string
	 */
	public function getRemark()
	{
		return $this->remark;
	}

	/**
	 * @param string $remark
	 */
	public function setRemark($remark)
	{
		$this->remark = $remark;
	}

}
