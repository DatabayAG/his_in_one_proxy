<?php

namespace HisInOneProxy\DataModel\Container;

use HisInOneProxy\DataModel\WorkStatus;
use InvalidArgumentException;

/**
 * Class WorkStatusContainer
 * @package HisInOneProxy\DataModel\Container
 */
class WorkStatusContainer
{
    /**
     * @var WorkStatus[]
     */
    protected $container = array();

    /**
     * @return WorkStatus[]
     */
    public function getWorkStatusContainer()
    {
        return $this->container;
    }

    /**
     * @param WorkStatus $work_status
     */
    public function appendWorkStatus($work_status)
    {
        if (is_a($work_status, '\HisInOneProxy\DataModel\WorkStatus')) {
            $this->container[trim($work_status->getId())] = $work_status;
        } else {
            throw new InvalidArgumentException();
        }
    }

    /**
     * @param $id
     * @return null|string
     */
    public function translateIdToDefaultText($id)
    {
        if (array_key_exists($id, $this->container)) {
            return $this->container[$id]->getDefaultText();
        }
        return null;
    }
}