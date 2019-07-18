<?php

namespace HisInOneProxy\Parser;

use HisInOneProxy\DataModel;

/**
 * Class ParseTermType
 * @package HisInOneProxy\Parser
 */
class ParseEAddressType extends SimpleXmlParser
{
    /**
     * @param $xml
     * @return DataModel\EAddressType[]
     */
    public function parse($xml)
    {
        $container = array();
        if ($this->doesAttributeExist($xml, 'listOfEAddresstypes')) {
            $xml = $xml->listOfEAddresstypes;
            if ($this->doesMoreThanOneElementExists($xml, 'eaddresstypevalue')) {
                foreach ($xml->eaddresstypevalue as $address) {
                    $obj                            = $this->buildObject($address);
                    $container[trim($obj->getId())] = $obj;
                }
            } else {
                if ($this->doesExactlyOneElementExists($xml, 'eaddresstypevalue')) {
                    $obj                            = $this->buildObject($xml->eaddresstypevalue);
                    $container[trim($obj->getId())] = $obj;
                }
            }
        }
        return $container;
    }

    /**
     * @param $xml
     * @return DataModel\EAddressType
     */
    protected function buildObject($xml)
    {
        $address = new DataModel\EAddressType();
        if ($this->isAttributeValid($xml, 'id')) {
            $address->setId($xml->id);
        }
        if ($this->isAttributeValid($xml, 'uniquename')) {
            $address->setUniqueName($xml->uniquename);
        }
        if ($this->isAttributeValid($xml, 'shorttext')) {
            $address->setShortText($xml->shorttext);
        }
        if ($this->isAttributeValid($xml, 'defaulttext')) {
            $address->setDefaultText($xml->defaulttext);
        }
        if ($this->isAttributeValid($xml, 'longtext')) {
            $address->setLongText($xml->longtext);
        }
        if ($this->isAttributeValid($xml, 'sortorder')) {
            $address->setSortOrder($xml->sortorder);
        }
        if ($this->isAttributeValid($xml, 'defaultlanguage')) {
            $address->setDefaultLanguage($xml->defaultlanguage);
        }
        if ($this->isAttributeValid($xml, 'objGuid')) {
            $address->setObjGuid($xml->objGuid);
        }
        if ($this->isAttributeValid($xml, 'addresstype')) {
            $address->setAddressType($xml->addresstype);
        }
        if ($this->isAttributeValid($xml, 'hiskeyId')) {
            $address->setHisKeyId($xml->hiskeyId);
        }

        return $address;
    }
}
