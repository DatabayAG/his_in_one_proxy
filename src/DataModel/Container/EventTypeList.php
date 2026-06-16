<?php

namespace HisInOneProxy\DataModel\Container;

use HisInOneProxy\DataModel\EventType;
use HisInOneProxy\DataModel\Traits\JsonData;

/**
 * Class EventTypeList
 * @package HisInOneProxy\DataModel\Container
 */
class EventTypeList implements \JsonSerializable
{
    use JsonData;

    /**
     * @var array
     */
    protected $event_type_container = array();

    /**
     * @return array
     */
    public function getEventTypeContainer()
    {
        return $this->event_type_container;
    }

    /**
     * @param EventType $event_type
     */
    public function appendEventType($event_type)
    {
        $this->event_type_container[(string) $event_type->getId()] = $event_type;
    }

    /**
     * @param $id
     * @return EventType | null
     */
    public function getEventTypeById($id)
    {
        if (array_key_exists($id, $this->event_type_container)) {
            return $this->event_type_container[$id];
        }
        return null;
    }

    /**
     * @return int
     */
    public function getSizeOfContainer()
    {
        return count($this->event_type_container);
    }

}
