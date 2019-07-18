<?php

namespace HisInOneProxy\DataModel;

use HisInOneProxy\DataModel\Traits;
use HisInOneProxy\Exceptions;

/**
 * Class TimePreference
 * @package HisInOneProxy\DataModel
 */
class TimePreference
{
    use Traits\LockVersion, Traits\ObjGuid, Traits\TermTypeValueId, Traits\Year;

    /**
     * @var int
     */
    protected $owner_person_preference_id;

    /**
     * @var int
     */
    protected $owner_plan_element_preference_id;

    /**
     * @var int
     */
    protected $owner_room_class_id;

    /**
     * @var int
     */
    protected $weighting_factor;

    /**
     * @var TimeSlot[]
     */
    protected $time_slot = array();

    /**
     * @return int
     */
    public function getOwnerPersonPreferenceId()
    {
        return $this->owner_person_preference_id;
    }

    /**
     * @param int $owner_person_preference_id
     */
    public function setOwnerPersonPreferenceId($owner_person_preference_id)
    {
        $this->owner_person_preference_id = (int) $owner_person_preference_id;
    }

    /**
     * @return int
     */
    public function getOwnerPlanElementPreferenceId()
    {
        return $this->owner_plan_element_preference_id;
    }

    /**
     * @param int $owner_plan_element_preference_id
     */
    public function setOwnerPlanElementPreferenceId($owner_plan_element_preference_id)
    {
        $this->owner_plan_element_preference_id = (int) $owner_plan_element_preference_id;
    }

    /**
     * @return int
     */
    public function getOwnerRoomClassId()
    {
        return $this->owner_room_class_id;
    }

    /**
     * @param int $owner_room_class_id
     */
    public function setOwnerRoomClassId($owner_room_class_id)
    {
        $this->owner_room_class_id = (int) $owner_room_class_id;
    }

    /**
     * @return int
     */
    public function getWeightingFactor()
    {
        return $this->weighting_factor;
    }

    /**
     * @param int $weighting_factor
     */
    public function setWeightingFactor($weighting_factor)
    {
        $this->weighting_factor = (int) $weighting_factor;
    }

    /**
     * @return TimeSlot[]
     */
    public function getTimeSlotContainer()
    {
        return $this->time_slot;
    }

    /**
     * @param TimeSlot $time_slot
     */
    public function appendTimeSlot($time_slot)
    {
        if (is_a($time_slot, '\HisInOneProxy\DataModel\TimeSlot')) {
            $this->time_slot[] = $time_slot;
        } else {
            throw new Exceptions\InvalidTimeSlot();
        }
    }
}
