<?php

namespace HisInOneProxy\DataModel\Traits;

/**
 * Trait PlannedDatesId
 * @package HisInOneProxy\DataModel\Traits
 */
trait PlannedDatesId
{

    /**
     * @var int
     */
    protected $planned_dates_id;

    /**
     * @return int
     */
    public function getPlannedDatesId()
    {
        return $this->planned_dates_id;
    }

    /**
     * @param int $planned_dates_id
     */
    public function setPlannedDatesId($planned_dates_id)
    {
        $this->planned_dates_id = $planned_dates_id;
    }

}