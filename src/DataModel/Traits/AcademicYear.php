<?php

namespace HisInOneProxy\DataModel\Traits;

/**
 * Trait AcademicYear
 * @package HisInOneProxy\DataModel\Traits
 */
trait AcademicYear
{

    /**
     * @var string
     */
    protected $academic_year;

    /**
     * @return string
     */
    public function getAcademicYear()
    {
        return $this->academic_year;
    }

    /**
     * @param string $academic_year
     */
    public function setAcademicYear($academic_year)
    {
        $this->academic_year = $academic_year;
    }
}