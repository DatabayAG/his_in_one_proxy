<?php

namespace HisInOneProxy\DataModel\Container;

use Generator;
use HisInOneProxy\DataModel\TermType;

/**
 * Class TermTypeList
 * @package HisInOneProxy\DataModel\Container
 */
class TermTypeList implements \JsonSerializable
{
    /**
     * @var array
     */
    protected $term_type_container = array();

    private array $json_header;

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

    #[\ReturnTypeWillChange]
    public function jsonSerialize()
    {
        return [
            'header' => $this->json_header ?? [],
            'term_types' => array_values($this->term_type_container),
        ];
    }

    public function addHeadData($head_data) {
        $this->json_header = $head_data;
    }
}
