<?php

namespace HisInOneProxy\DataModel\Traits;

/**
 * Trait ObjectiveQualification
 * @package HisInOneProxy\DataModel\Traits
 */
trait ObjectiveQualification
{

    /**
     * @var string
     */
    protected $objective_qualification;

    /**
     * @return string
     */
    public function getObjectiveQualification()
    {
        return $this->objective_qualification;
    }

    /**
     * @param string $objective_qualification
     */
    public function setObjectiveQualification($objective_qualification)
    {
        $this->objective_qualification = $objective_qualification;
    }

}