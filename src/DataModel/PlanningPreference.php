<?php

namespace HisInOneProxy\DataModel;

use HisInOneProxy\DataModel\Traits;
use HisInOneProxy\Exceptions;

/**
 * Class PlanningPreference
 * @package HisInOneProxy\DataModel
 */
class PlanningPreference
{
    use Traits\Comment, Traits\LockVersion, Traits\ObjGuid, Traits\TermTypeValueId, Traits\Year;

    /**
     * @var int
     */
    protected $fixed_time;

    /**
     * @var int
     */
    protected $owner_plan_element_id;

    /**
     * @var int
     */
    protected $parts_in_a_row;

    /**
     * @var PlanElementPreferencePart[]
     */
    protected $plan_element_preference_parts = array();

    /**
     * @var TimePreference[]
     */
    protected $time_preference_container = array();

    /**
     * @return int
     */
    public function getFixedTime()
    {
        return $this->fixed_time;
    }

    /**
     * @param int $fixed_time
     */
    public function setFixedTime($fixed_time)
    {
        $this->fixed_time = $fixed_time;
    }

    /**
     * @return int
     */
    public function getOwnerPlanElementId()
    {
        return $this->owner_plan_element_id;
    }

    /**
     * @param int $owner_plan_element_id
     */
    public function setOwnerPlanElementId($owner_plan_element_id)
    {
        $this->owner_plan_element_id = $owner_plan_element_id;
    }

    /**
     * @return int
     */
    public function getPartsInARow()
    {
        return $this->parts_in_a_row;
    }

    /**
     * @param int $parts_in_a_row
     */
    public function setPartsInARow($parts_in_a_row)
    {
        $this->parts_in_a_row = $parts_in_a_row;
    }

    /**
     * @return PlanElementPreferencePart[]
     */
    public function getPlanElementPreferenceParts()
    {
        return $this->plan_element_preference_parts;
    }

    /**
     * @param PlanElementPreferencePart $plan_element_preference_part
     */
    public function appendPlanElementPreferencePart($plan_element_preference_part)
    {
        if (is_a($plan_element_preference_part, '\HisInOneProxy\DataModel\PlanElementPreferencePart')) {
            $this->plan_element_preference_parts[] = $plan_element_preference_part;
        } else {
            throw new Exceptions\InvalidPlanElementPreferencePart();
        }
    }

    /**
     * @return TimePreference[]
     */
    public function getTimePreferenceContainer()
    {
        return $this->time_preference_container;
    }

    /**
     * @param TimePreference $time_preference
     */
    public function appendTimePreference($time_preference)
    {
        if (is_a($time_preference, '\HisInOneProxy\DataModel\TimePreference')) {
            $this->time_preference_container[] = $time_preference;
        } else {
            throw new Exceptions\InvalidTimePreference();
        }
    }
}
