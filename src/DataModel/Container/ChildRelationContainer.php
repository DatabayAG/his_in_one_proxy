<?php

namespace HisInOneProxy\DataModel\Container;

use HisInOneProxy\DataModel\ChildRelation;
use InvalidArgumentException;

/**
 * Class ChildRelationContainer
 * @package HisInOneProxy\DataModel\Container
 */
class ChildRelationContainer implements \JsonSerializable
{
    /**
     * @var ChildRelation[]
     */
    protected $container = array();

    private array $json_header;

    /**
     * @return ChildRelation[]
     */
    public function getChildRelationContainer()
    {
        return $this->container;
    }

    /**
     * @param ChildRelation $child_relation
     */
    public function appendChildRelation($child_relation)
    {
        if (is_a($child_relation, '\HisInOneProxy\DataModel\ChildRelation')) {
            $this->container[(string) $child_relation->getChildId()] = $child_relation;
        } else {
            throw new InvalidArgumentException();
        }
    }

    /**
     * @param               $id
     * @param ChildRelation $child
     */
    public function replaceChildInContainer($id, $child)
    {
        $this->container[$id] = $child;
    }

    #[\ReturnTypeWillChange]
    public function jsonSerialize()
    {
        return [
            'header' => $this->json_header ?? [],
            'child_relations' => array_values($this->container),
        ];
    }

    public function addHeadData($head_data) {
        $this->json_header = $head_data;
    }
}
