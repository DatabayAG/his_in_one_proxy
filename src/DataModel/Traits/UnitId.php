<?php

namespace HisInOneProxy\DataModel\Traits;

/**
 * Trait UnitId
 * @package HisInOneProxy\DataModel\Traits
 */
trait UnitId
{
    /**
     * @var int
     */
    protected $unit_id;

    /**
     * @return int
     */
    public function getUnitId()
    {
        return $this->unit_id;
    }

    /**
     * @param int $unit_id
     */
    public function setUnitId($unit_id)
    {
        $this->unit_id = $unit_id;
    }
}