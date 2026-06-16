<?php

namespace HisInOneProxy\DataModel\Container;

use Generator;
use HisInOneProxy\DataModel\TermType;
use HisInOneProxy\DataModel\Traits\JsonData;

/**
 * Class TermTypeList
 * @package HisInOneProxy\DataModel\Container
 */
class TermTypeList implements \JsonSerializable
{
    use JsonData;

    /**
     * @var array
     */
    protected $term_type_container = array();

    /**
     * @return array
     */
    public function getTermTypeContainer()
    {
        return $this->term_type_container;
    }

    /**
     * @return Generator
     */
    public function getTermType()
    {
        foreach ($this->term_type_container as $term_type) {
            yield $term_type;
        }
    }

    /**
     * @param TermType $term_type
     */
    public function appendTermType($term_type)
    {
        $this->term_type_container[(string) $term_type->getId()] = $term_type;
    }

    /**
     * @return int
     */
    public function getSizeOfContainer()
    {
        return count($this->term_type_container);
    }

    /**
     * @param $id
     * @return TermType | null
     */
    public function getTermTypeById($id)
    {
        if (array_key_exists($id, $this->term_type_container)) {
            return $this->term_type_container[$id];
        }
        return null;
    }

}
