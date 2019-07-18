<?php

namespace HisInOneProxy\DataModel\Traits;

/**
 * Trait WeekDay
 * @package HisInOneProxy\DataModel\Traits
 */
trait WeekDay
{
    /**
     * @var int
     */
    protected $week_day;

    /**
     * @return int
     */
    public function getWeekDay()
    {
        return $this->week_day;
    }

    /**
     * @param int $week_day
     */
    public function setWeekDay($week_day)
    {
        $this->week_day = $week_day;
    }
}