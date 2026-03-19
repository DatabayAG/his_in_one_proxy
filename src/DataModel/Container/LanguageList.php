<?php

namespace HisInOneProxy\DataModel\Container;

use Generator;
use HisInOneProxy\DataModel\DefaultObject;

/**
 * Class LanguageList
 * @package HisInOneProxy\DataModel\Container
 */
class LanguageList implements \JsonSerializable
{
    /**
     * @var array
     */
    protected $language_container = array();

    private array $json_header;

    /**
     * @return array
     */
    public function getLanguageContainer()
    {
        return $this->language_container;
    }

    /**
     * @return Generator
     */
    public function getLanguage()
    {
        foreach ($this->language_container as $language) {
            yield $language;
        }
    }

    /**
     * @param DefaultObject $language
     */
    public function appendLanguage($language)
    {
        $this->language_container[(string) $language->getId()] = $language;
    }

    /**
     * @return int
     */
    public function getSizeOfContainer()
    {
        return count($this->language_container);
    }

    #[\ReturnTypeWillChange]
    public function jsonSerialize()
    {
        return [
            'header' => $this->json_header ?? [],
            'languages' => array_values($this->language_container),
        ];
    }

    public function addHeadData($head_data) {
        $this->json_header = $head_data;
    }
}
