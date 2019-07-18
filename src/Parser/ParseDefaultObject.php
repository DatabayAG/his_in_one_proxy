<?php

namespace HisInOneProxy\Parser;

use HisInOneProxy\DataModel;

/**
 * Class ParseEAddressTag
 * @package HisInOneProxy\Parser
 */
class ParseDefaultObject extends SimpleXmlParser
{
    /**
     * @var string
     */
    protected $list_value = null;

    /**
     * @var string
     */
    protected $tag_value = null;

    /**
     * @param $xml
     * @return DataModel\DefaultObject[]
     */
    public function parse($xml)
    {
        $container = array();
        if ($this->getListValue() != null && $this->getTagValue() != null) {
            if ($this->doesAttributeExist($xml, $this->getListValue())) {
                $xml = $xml->{$this->getListValue()};
                if ($this->doesMoreThanOneElementExists($xml, $this->getTagValue())) {
                    foreach ($xml->{$this->getTagValue()} as $address) {
                        $obj                            = $this->buildObject($address);
                        $container[trim($obj->getId())] = $obj;
                    }
                } else {
                    if ($this->doesExactlyOneElementExists($xml, $this->getTagValue())) {
                        $obj                            = $this->buildObject($xml->{$this->getTagValue()});
                        $container[trim($obj->getId())] = $obj;
                    }
                }
            }
        } else {
            $this->log->error('List value and Tag value must be given before parsing.');
        }
        return $container;
    }

    /**
     * @return string
     */
    public function getListValue()
    {
        return $this->list_value;
    }

    /**
     * @param string $list_value
     */
    public function setListValue($list_value)
    {
        $this->list_value = $list_value;
    }

    /**
     * @return string
     */
    public function getTagValue()
    {
        return $this->tag_value;
    }

    /**
     * @param string $tag_value
     */
    public function setTagValue($tag_value)
    {
        $this->tag_value = $tag_value;
    }

    /**
     * @param $xml
     * @return DataModel\DefaultObject
     */
    protected function buildObject($xml)
    {
        $default_object = new DataModel\DefaultObject();
        if ($this->isAttributeValid($xml, 'id')) {
            $default_object->setId($xml->id);
        }
        if ($this->isAttributeValid($xml, 'uniquename')) {
            $default_object->setUniqueName($xml->uniquename);
        }
        if ($this->isAttributeValid($xml, 'shorttext')) {
            $default_object->setShortText($xml->shorttext);
        }
        if ($this->isAttributeValid($xml, 'defaulttext')) {
            $default_object->setDefaultText($xml->defaulttext);
        }
        if ($this->isAttributeValid($xml, 'longtext')) {
            $default_object->setLongText($xml->longtext);
        }
        if ($this->isAttributeValid($xml, 'sortorder')) {
            $default_object->setSortOrder($xml->sortorder);
        }
        if ($this->isAttributeValid($xml, 'defaultlanguage')) {
            $default_object->setDefaultLanguage($xml->defaultlanguage);
        }
        if ($this->isAttributeValid($xml, 'objGuid')) {
            $default_object->setObjGuid($xml->objGuid);
        }
        if ($this->isAttributeValid($xml, 'hiskeyId')) {
            $default_object->setHisKeyId($xml->hiskeyId);
        }

        return $default_object;
    }
}
