<?php

namespace HisInOneProxy\DataModel\Traits;

/**
 * Trait PlanElementId
 * @package HisInOneProxy\DataModel\Traits
 */
trait PlanElementId
{

    /**
     * @var int
     */
    protected $plan_element_id;

    /**
     * @return int
     */
    public function getPlanElementId()
    {
        return $this->plan_element_id;
    }

    /**
     * @param int $plan_element_id
     */
    public function setPlanElementId($plan_element_id)
    {
        $this->plan_element_id = $plan_element_id;
    }
}