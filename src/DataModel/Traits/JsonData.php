<?php

namespace HisInOneProxy\DataModel\Traits;

/**
 * Trait JsonData
 * @package HisInOneProxy\DataModel\Traits
 */
trait JsonData
{
    /**
     * @var array
     */
    protected array $json_header = [];

    /**
     * @param array $head_data
     */
    public function addHeadData($head_data)
    {
        $this->json_header = $head_data;
    }

    /**
     * @return array
     */
    #[\ReturnTypeWillChange]
    public function jsonSerialize()
    {
        $data = get_object_vars($this);
        unset($data['json_header']);
        return [
            'json_header' => $this->json_header ?? [],
            'data'    => $data,
        ];
    }
}
