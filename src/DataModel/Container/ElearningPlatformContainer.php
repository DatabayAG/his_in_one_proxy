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

    public function jsonSerialize() {
        $class = $this->serializeItem( $this );
        $this->json_header[] = $class;
        return $class;
    }

    private function serializeItem($item)
    {
        if (!is_object($item)) {
            return $item;
        }

        return $this->getProperties($item);
    }

    private function getProperties($obj)
    {
        $rc = new ReflectionClass($obj);

        return $rc->getProperties();
    }

    public function addHeadData($head_data) {
        $this->json_header = $head_data;
    }
}
