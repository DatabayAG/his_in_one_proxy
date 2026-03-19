<?php

namespace HisInOneProxy\DataModel\Container;

use HisInOneProxy\DataModel\ElearningPlatform;
use InvalidArgumentException;
use ReflectionClass;
use ReturnTypeWillChange;

/**
 * Class ElearningPlatformContainer
 * @package HisInOneProxy\DataModel\Container
 */
class ElearningPlatformContainer implements \JsonSerializable
{
    /**
     * @var ElearningPlatform[]
     */
    protected array $container = [];
    private array $json_header;

    /**
     * @return ElearningPlatform[]
     */
    public function getElearningPlatformContainer()
    {
        return $this->container;
    }

    /**
     * @param ElearningPlatform $e_learning_platform
     */
    public function appendElearningPlatform($e_learning_platform)
    {
        if (is_a($e_learning_platform, '\HisInOneProxy\DataModel\ElearningPlatform')) {
            $this->container[trim($e_learning_platform->getId())] = $e_learning_platform;
        } else {
            throw new InvalidArgumentException();
        }
    }

    /**
     * @param $id
     * @return null
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
            'platforms' => array_values($this->container),
        ];
    }

    public function addHeadData($head_data) {
        $this->json_header = $head_data;
    }
}
