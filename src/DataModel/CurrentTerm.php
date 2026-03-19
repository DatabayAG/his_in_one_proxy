<?php

namespace HisInOneProxy\DataModel;

use HisInOneProxy\Config\GlobalSettings;
use HisInOneProxy\DataModel\Traits;

/**
 * Class CurrentTerm
 * @package HisInOneProxy\DataModel
 */
class CurrentTerm implements \JsonSerializable
{
    const TEXT = 'current_term';

    use Traits\Text, Traits\TermNumber, Traits\Year;

    /**
     * @return string
     */
    public function getText()
    {
        if (array_key_exists(self::TEXT, GlobalSettings::getInstance()->getTextConfig())) {
            if (method_exists($this, GlobalSettings::getInstance()->getTextConfig()[self::TEXT])) {
                return $this->{GlobalSettings::getInstance()->getTextConfig()[self::TEXT]}();
            }
        }
        return $this->getDefaultText();
    }

    #[\ReturnTypeWillChange]
    public function jsonSerialize()
    {
        return [
            'json_header' => $this->json_header ?? [],
            'data' => get_object_vars($this),
        ];
    }

    public function addHeadData($head_data) {
        $this->json_header = $head_data;
    }
}
