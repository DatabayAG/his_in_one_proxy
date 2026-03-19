<?php

namespace HisInOneProxy\DataModel;

use JsonSerializable;

/**
 * Class CourseMappingType
 * @package HisInOneProxy\DataModel
 */
class CourseMappingType implements JsonSerializable
{
    use Traits\HisKeyId, Traits\LanguageId, Traits\ObjGuid, Traits\SortingOrder, Traits\UniqueNameAndText;

    #[\ReturnTypeWillChange]
    public function jsonSerialize()
    {
        return get_object_vars($this);
    }

}
