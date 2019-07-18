<?php

namespace HisInOneProxy\DataModel\Container;

use Generator;
use HisInOneProxy\DataModel\HisSystemResponse;

/**
 * Class HisSystemResponseContainer
 * @package HisInOneProxy\DataModel\Container
 */
class HisSystemResponseContainer
{
    /**
     * @var array
     */
    protected $system_response_container = array();

    /**
     * @return array
     */
    public function getSystemResponseContainer()
    {
        return $this->system_response_container;
    }

    /**
     * @return Generator
     */
    public function getSystemResponse()
    {
        foreach ($this->system_response_container as $system_response) {
            yield $system_response;
        }
    }

    /**
     * @param HisSystemResponse $system_response
     */
    public function appendSystemResponse($system_response)
    {
        $this->system_response_container[] = $system_response;
    }

    /**
     * @return int
     */
    public function getSizeOfContainer()
    {
        return count($this->system_response_container);
    }
}