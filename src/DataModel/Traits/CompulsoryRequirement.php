<?php

namespace HisInOneProxy\DataModel\Traits;

/**
 * Trait CompulsoryRequirement
 * @package HisInOneProxy\DataModel\Traits
 */
trait CompulsoryRequirement
{

    /**
     * @var string
     */
    protected $compulsory_requirement;

    /**
     * @return string
     */
    public function getCompulsoryRequirement()
    {
        return $this->compulsory_requirement;
    }

    /**
     * @param string $compulsory_requirement
     */
    public function setCompulsoryRequirement($compulsory_requirement)
    {
        $this->compulsory_requirement = $compulsory_requirement;
    }
}