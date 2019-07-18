<?php

namespace HisInOneProxy\DataModel\Traits;

/**
 * Trait Workload
 * @package HisInOneProxy\DataModel\Traits
 */
trait Workload
{

    /**
     * @var string
     */
    protected $workload;

    /**
     * @return string
     */
    public function getWorkload()
    {
        return $this->workload;
    }

    /**
     * @param string $workload
     */
    public function setWorkload($workload)
    {
        $this->workload = $workload;
    }
}