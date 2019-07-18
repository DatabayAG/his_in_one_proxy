<?php

namespace HisInOneProxy\DataModel;

use HisInOneProxy\DataModel\Traits;
use HisInOneProxy\Exceptions;

/**
 * Class PlanElementPreferencePart
 * @package HisInOneProxy\DataModel
 */
class PlanElementPreferencePart
{
    use Traits\LockVersion, Traits\ObjGuid;

    /**
     * @var int
     */
    protected $belongs_to_plan_element_preference_id;

    /**
     * @var PreferredInstructor[]
     */
    protected $preferred_instructors;

    /**
     * @var Room[]
     */
    protected $preferred_rooms;

    /**
     * @return int
     */
    public function getBelongsToPlanElementPreferenceId()
    {
        return $this->belongs_to_plan_element_preference_id;
    }

    /**
     * @param int $belongs_to_plan_element_preference_id
     */
    public function setBelongsToPlanElementPreferenceId($belongs_to_plan_element_preference_id)
    {
        $this->belongs_to_plan_element_preference_id = $belongs_to_plan_element_preference_id;
    }

    /**
     * @return PreferredInstructor[]
     */
    public function getPreferredInstructors()
    {
        return $this->preferred_instructors;
    }

    /**
     * @param PreferredInstructor $preferred_instructor
     */
    public function appendPreferredInstructors($preferred_instructor)
    {
        if (is_a($preferred_instructor, '\HisInOneProxy\DataModel\PreferredInstructor')) {
            $this->preferred_instructors[] = $preferred_instructor;
        } else {
            throw new Exceptions\InvalidPreferredInstructor();
        }
    }

    /**
     * @return Room[]
     */
    public function getPreferredRooms()
    {
        return $this->preferred_rooms;
    }

    /**
     * @param Room $preferred_room
     */
    public function appendPreferredRooms($preferred_room)
    {
        if (is_a($preferred_room, '\HisInOneProxy\DataModel\Room')) {
            $this->preferred_rooms[] = $preferred_room;
        } else {
            throw new Exceptions\InvalidRoom();
        }
    }
}
