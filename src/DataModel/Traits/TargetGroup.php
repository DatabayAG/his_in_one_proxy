<?php

namespace HisInOneProxy\DataModel\Traits;

/**
 * Trait TargetGroup
 * @package HisInOneProxy\DataModel\Traits
 */
trait TargetGroup
{

    /**
     * @var string
     */
    protected $target_group;

    /**
     * @return string
     */
    public function getTargetGroup()
    {
        return $this->target_group;
    }

    /**
     * @param string $target_group
     */
    public function setTargetGroup($target_group)
    {
        $this->target_group = $target_group;
    }
}