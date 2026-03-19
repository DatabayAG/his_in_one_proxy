<?php

namespace HisInOneProxy\DataModel\Container;

use HisInOneProxy\DataModel\ElearningPlatform;
use HisInOneProxy\DataModel\Traits\JsonData;
use InvalidArgumentException;

/**
 * Class ElearningPlatformContainer
 * @package HisInOneProxy\DataModel\Container
 */
class ElearningPlatformContainer implements \JsonSerializable
{
    use JsonData;

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

}
