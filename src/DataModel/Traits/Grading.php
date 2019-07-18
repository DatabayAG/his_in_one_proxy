<?php

namespace HisInOneProxy\DataModel\Traits;

/**
 * Trait Grading
 * @package HisInOneProxy\DataModel\Traits
 */
trait Grading
{
    /**
     * @var string
     */
    protected $grading;

    /**
     * @return string
     */
    public function getGrading()
    {
        return $this->grading;
    }

    /**
     * @param string $grading
     */
    public function setGrading($grading)
    {
        $this->grading = $grading;
    }

}