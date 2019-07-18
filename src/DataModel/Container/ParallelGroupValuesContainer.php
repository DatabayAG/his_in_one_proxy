<?php

namespace HisInOneProxy\DataModel\Container;

use HisInOneProxy\DataModel\ParallelGroupValue;
use Psr\Log\InvalidArgumentException;

/**
 * Class ParallelGroupValuesContainer
 * @package HisInOneProxy\DataModel\Container
 */
class ParallelGroupValuesContainer
{
    protected $parallel_group_value_container;

    /**
     * @return ParallelGroupValuesContainer
     */
    public function getParallelGroupValueContainer()
    {
        return $this->parallel_group_value_container;
    }

    /**
     * @return int
     */
    public function getSizeOfParallelGroupValueContainer()
    {
        return count($this->parallel_group_value_container);
    }

    /**
     * @param ParallelGroupValue $parallel_group_value
     */
    public function appendParallelGroupValue($parallel_group_value)
    {
        if (is_a($parallel_group_value, '\HisInOneProxy\DataModel\ParallelGroupValue')) {
            $this->parallel_group_value_container[trim($parallel_group_value->getId())] = $parallel_group_value;
        } else {
            throw new InvalidArgumentException();
        }
    }

    /**
     * @param $id
     * @return ParallelGroupValue | null
     */
    public function getGroupValueById($id)
    {
        if (array_key_exists($id, $this->parallel_group_value_container)) {
            return $this->parallel_group_value_container[$id];
        }
        return null;
    }

}