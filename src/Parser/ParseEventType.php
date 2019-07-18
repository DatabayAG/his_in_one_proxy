<?php

namespace HisInOneProxy\Parser;

use HisInOneProxy\DataModel;

/**
 * Class ParseEventType
 * @package HisInOneProxy\Parser
 */
class ParseEventType extends SimpleXmlParser
{
    /**
     * @param $xml
     * @return DataModel\EAddressType[]
     */
    public function parse($xml)
    {
        $container = array();
        if ($this->doesAttributeExist($xml, 'listOfEventtypes')) {
            $xml = $xml->listOfEventtypes;
            if ($this->doesMoreThanOneElementExists($xml, 'eventtypevalue')) {
                foreach ($xml->eventtypevalue as $event_type) {
                    $obj                            = $this->buildObject($event_type);
                    $container[trim($obj->getId())] = $obj;
                }
            } else {
                if ($this->doesExactlyOneElementExists($xml, 'eventtypevalue')) {
                    $obj                            = $this->buildObject($xml->eventtypevalue);
                    $container[trim($obj->getId())] = $obj;
                }
            }
        }
        return $container;
    }

    /**
     * @param $xml
     * @return DataModel\EventType
     */
    protected function buildObject($xml)
    {
        $event_type = new DataModel\EventType();
        if ($this->isAttributeValid($xml, 'id')) {
            $event_type->setId($xml->id);
        }
        if ($this->isAttributeValid($xml, 'uniquename')) {
            $event_type->setUniqueName($xml->uniquename);
        }
        if ($this->isAttributeValid($xml, 'shorttext')) {
            $event_type->setShortText($xml->shorttext);
        }
        if ($this->isAttributeValid($xml, 'defaulttext')) {
            $event_type->setDefaultText($xml->defaulttext);
        }
        if ($this->isAttributeValid($xml, 'longtext')) {
            $event_type->setLongText($xml->longtext);
        }
        if ($this->isAttributeValid($xml, 'sortorder')) {
            $event_type->setSortOrder($xml->sortorder);
        }
        if ($this->isAttributeValid($xml, 'defaultlanguage')) {
            $event_type->setDefaultLanguage($xml->defaultlanguage);
        }
        if ($this->isAttributeValid($xml, 'objGuid')) {
            $event_type->setObjGuid($xml->objGuid);
        }
        if ($this->isAttributeValid($xml, 'addresstype')) {
            $event_type->setAddressType($xml->addresstype);
        }
        if ($this->isAttributeValid($xml, 'hiskeyId')) {
            $event_type->setHisKeyId($xml->hiskeyId);
        }

        return $event_type;
    }
}
