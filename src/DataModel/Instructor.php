<?php

namespace HisInOneProxy\DataModel;

use HisInOneProxy\DataModel\Traits;

/**
 * Class Instructor
 * @package HisInOneProxy\DataModel
 */
class Instructor
{
    use Traits\LockVersion, Traits\ObjGuid, Traits\PersonId, Traits\PlannedDatesId, Traits\SortingOrder;

    /**
     * @var int
     */
    protected $examination_subarea_id;

    /**
     * @var int
     */
    protected $instructor_task_id;

    /**
     * @var int
     */
    protected $plan_element_change_id;

    /**
     * @var float
     */
    protected $teaching_load_percentage;

    /**
     * @var int
     */
    protected $weight;

    /**
     * @return int
     */
    public function getExaminationSubareaId()
    {
        return $this->examination_subarea_id;
    }

    /**
     * @param int $examination_subarea_id
     */
    public function setExaminationSubareaId($examination_subarea_id)
    {
        $this->examination_subarea_id = $examination_subarea_id;
    }

    /**
     * @return int
     */
    public function getInstructorTaskId()
    {
        return $this->instructor_task_id;
    }

    /**
     * @param int $instructor_task_id
     */
    public function setInstructorTaskId($instructor_task_id)
    {
        $this->instructor_task_id = $instructor_task_id;
    }

    /**
     * @return int
     */
    public function getPlanElementChangeId()
    {
        return $this->plan_element_change_id;
    }

    /**
     * @param int $plan_element_change_id
     */
    public function setPlanElementChangeId($plan_element_change_id)
    {
        $this->plan_element_change_id = $plan_element_change_id;
    }

    /**
     * @return float
     */
    public function getTeachingLoadPercentage()
    {
        return $this->teaching_load_percentage;
    }

    /**
     * @param float $teaching_load_percentage
     */
    public function setTeachingLoadPercentage($teaching_load_percentage)
    {
        $this->teaching_load_percentage = $teaching_load_percentage;
    }

    /**
     * @return int
     */
    public function getWeight()
    {
        return $this->weight;
    }

    /**
     * @param int $weight
     */
    public function setWeight($weight)
    {
        $this->weight = $weight;
    }
}
