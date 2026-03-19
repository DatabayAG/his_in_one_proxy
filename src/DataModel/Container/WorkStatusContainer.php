<?php

namespace HisInOneProxy\DataModel\Container;

use HisInOneProxy\DataModel\WorkStatus;
use InvalidArgumentException;

/**
 * Class WorkStatusContainer
 * @package HisInOneProxy\DataModel\Container
 */
class WorkStatusContainer implements \JsonSerializable
{
    /**
     * @var WorkStatus[]
     */
    protected $container = array();

    private array $json_header;

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

    #[\ReturnTypeWillChange]
    public function jsonSerialize()
    {
        return [
            'header' => $this->json_header ?? [],
            'work_statuses' => array_values($this->container),
        ];
    }

    public function addHeadData($head_data) {
        $this->json_header = $head_data;
    }
}
