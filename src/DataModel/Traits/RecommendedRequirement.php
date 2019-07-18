<?php

namespace HisInOneProxy\DataModel\Traits;

/**
 * Trait RecommendedRequirement
 * @package HisInOneProxy\DataModel\Traits
 */
trait RecommendedRequirement
{

    /**
     * @var string
     */
    protected $recommended_requirement;

    /**
     * @return string
     */
    public function getRecommendedRequirement()
    {
        return $this->recommended_requirement;
    }

    /**
     * @param string $recommended_requirement
     */
    public function setRecommendedRequirement($recommended_requirement)
    {
        $this->recommended_requirement = $recommended_requirement;
    }

}