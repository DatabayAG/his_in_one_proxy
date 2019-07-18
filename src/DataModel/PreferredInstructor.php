<?php

namespace HisInOneProxy\DataModel;

use HisInOneProxy\DataModel\Traits;

/**
 * Class PreferredInstructor
 * @package HisInOneProxy\DataModel
 */
class PreferredInstructor
{
    use Traits\LockVersion, Traits\ObjGuid;

    /**
     * @var int
     */
    protected $preferred_instructor_id;

    /**
     * @var int
     */
    protected $preferred_instructor_for_plan_element_parts_id;

    /**
     * @var int
     */
    protected $priority;

    /**
     * @return int
     */
    public function getPreferredInstructorId()
    {
        return $this->preferred_instructor_id;
    }

    /**
     * @param int $preferred_instructor_id
     */
    public function setPreferredInstructorId($preferred_instructor_id)
    {
        $this->preferred_instructor_id = $preferred_instructor_id;
    }

    /**
     * @return int
     */
    public function getPreferredInstructorForPlanElementPartsId()
    {
        return $this->preferred_instructor_for_plan_element_parts_id;
    }

    /**
     * @param int $preferred_instructor_for_plan_element_parts_id
     */
    public function setPreferredInstructorForPlanElementPartsId($preferred_instructor_for_plan_element_parts_id)
    {
        $this->preferred_instructor_for_plan_element_parts_id = $preferred_instructor_for_plan_element_parts_id;
    }

    /**
     * @return int
     */
    public function getPriority()
    {
        return $this->priority;
    }

    /**
     * @param int $priority
     */
    public function setPriority($priority)
    {
        $this->priority = $priority;
    }
}
