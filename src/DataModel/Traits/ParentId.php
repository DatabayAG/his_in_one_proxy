<?php

namespace HisInOneProxy\DataModel\Traits;

/**
 * Trait ParentId
 * @package HisInOneProxy\DataModel\Traits
 */
trait ParentId
{
    /**
     * @var int
     */
    protected $parent_id;

    /**
     * @return int
     */
    public function getParentId()
    {
        return $this->parent_id;
    }

    /**
     * @param int $parent_id
     */
    public function setParentId($parent_id)
    {
        $this->parent_id = $parent_id;
    }
}