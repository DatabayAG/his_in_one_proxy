<?php

namespace HisInOneProxy\DataModel\Container;

use Generator;
use HisInOneProxy\DataModel\DefaultObject;
use HisInOneProxy\DataModel\Traits\JsonData;

/**
 * Class LanguageList
 * @package HisInOneProxy\DataModel\Container
 */
class LanguageList implements \JsonSerializable
{
    use JsonData;

    /**
     * @var array
     */
    protected $language_container = array();

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

}
