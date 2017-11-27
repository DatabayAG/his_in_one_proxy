<?php

namespace HisInOneProxy\DataModel;
use HisInOneProxy\DataModel\Traits;

/**
 * Class ElearningCourseMapping
 * @package HisInOneProxy\DataModel
 */
class ElearningCourseMapping
{

	use Traits\TermTypeValueId, Traits\UnitId, Traits\Year;

	/**
	 * @var int
	 */
	protected $course_mapping_type_id;

	/**
	 * @var int
	 */
	protected $e_learning_system_id;

	/**
	 * @return int
	 */
	public function getCourseMappingTypeId()
	{
		return $this->course_mapping_type_id;
	}

	/**
	 * @param int $course_mapping_type_id
	 */
	public function setCourseMappingTypeId($course_mapping_type_id)
	{
		$this->course_mapping_type_id = $course_mapping_type_id;
	}

	/**
	 * @return int
	 */
	public function getELearningSystemId()
	{
		return $this->e_learning_system_id;
	}

	/**
	 * @param int $e_learning_system_id
	 */
	public function setELearningSystemId($e_learning_system_id)
	{
		$this->e_learning_system_id = HisToEcsIdMapping::getEcsIdFromHisId($e_learning_system_id);
	}

}
