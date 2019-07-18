<?php

namespace HisInOneProxy\DataModel\Traits;

/**
 * Trait UniqueName
 * @package HisInOneProxy\DataModel\Traits
 */
trait UniqueName
{
    /**
     * @var string
     */
    protected $unique_name;

    /**
     * @return string
     */
    public function getUniqueName()
    {
        return $this->unique_name;
    }

    /**
     * @param string $unique_name
     */
    public function setUniqueName($unique_name)
    {
        $this->unique_name = $unique_name;
    }
}