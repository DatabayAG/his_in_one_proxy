<?php

namespace HisInOneProxy\DataModel;

/**
 * Class ChildRelation
 * @package HisInOneProxy\DataModel
 */
class ChildRelation
{
    /**
     * @var string
     */
    protected $child_id;

    /**
     * @var string
     */
    protected $parent_id;

    /**
     * @return string
     */
    public function getChildId()
    {
        return $this->child_id;
    }

    /**
     * @param string $child_id
     */
    public function setChildId($child_id)
    {
        $this->child_id = $child_id;
    }

    /**
     * @return string
     */
    public function getParentId()
    {
        return $this->parent_id;
    }

    /**
     * @param string $parent_id
     */
    public function setParentId($parent_id)
    {
        $this->parent_id = $parent_id;
    }
}
