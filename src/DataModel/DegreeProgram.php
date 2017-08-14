<?php

namespace HisInOneProxy\DataModel;

use HisInOneProxy\DataModel\Traits;

/**
 * Class DegreeProgram
 * @package HisInOneProxy\DataModel
 */
class DegreeProgram
{
	use Traits\GenderId;

	/**
	 * @var int
	 */
	protected $student_id;

	/**
	 * @var \DateTime
	 */
	protected $extension_date;

	/**
	 * @var float
	 */
	protected $extension_semester;

	/**
	 * @var 
	 */
	protected $progress_70;

	/**
	 * @return int
	 */
	public function getStudentId()
	{
		return $this->student_id;
	}

	/**
	 * @param int $student_id
	 */
	public function setStudentId($student_id)
	{
		$this->student_id = $student_id;
	}

	/**
	 * @return \DateTime
	 */
	public function getExtensionDate()
	{
		return $this->extension_date;
	}

	/**
	 * @param \DateTime $extension_date
	 */
	public function setExtensionDate($extension_date)
	{
		$this->extension_date = $extension_date;
	}

	/**
	 * @return float
	 */
	public function getExtensionSemester()
	{
		return $this->extension_semester;
	}

	/**
	 * @param float $extension_semester
	 */
	public function setExtensionSemester($extension_semester)
	{
		$this->extension_semester = $extension_semester;
	}

	/**
	 * @return mixed
	 */
	public function getProgress70()
	{
		return $this->progress_70;
	}

	/**
	 * @param mixed $progress_70
	 */
	public function setProgress70($progress_70)
	{
		$this->progress_70 = $progress_70;
	}
	
	
}
