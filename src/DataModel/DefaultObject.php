<?php

namespace HisInOneProxy\DataModel;

use HisInOneProxy\DataModel\Traits;

/**
 * Class DefaultObject
 * @package HisInOneProxy\DataModel
 */
class DefaultObject implements \JsonSerializable
{
    use Traits\DefaultObject;

    #[\ReturnTypeWillChange]
    public function jsonSerialize()
    {
        return get_object_vars($this);
    }
}
