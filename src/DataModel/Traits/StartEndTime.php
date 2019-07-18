<?php

namespace HisInOneProxy\DataModel\Traits;

/**
 * Trait StartEndTime
 * @package HisInOneProxy\DataModel\Traits
 */
trait StartEndTime
{

    /**
     * @var string
     */
    protected $start_time;

    /**
     * @var string
     */
    protected $end_time;

    /**
     * @return string
     */
    public function getStartTime()
    {
        return $this->start_time;
    }

    /**
     * @param string $start_time
     */
    public function setStartTime($start_time)
    {
        $this->start_time = $start_time;
    }

    /**
     * @return string
     */
    public function getEndTime()
    {
        return $this->end_time;
    }

    /**
     * @param string $end_time
     */
    public function setEndTime($end_time)
    {
        $this->end_time = $end_time;
    }

}