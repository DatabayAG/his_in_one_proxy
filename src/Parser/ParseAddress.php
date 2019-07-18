<?php

namespace HisInOneProxy\Parser;

use HisInOneProxy\DataModel\Address;

/**
 * Class ParseAddress
 * @package HisInOneProxy\Parser
 */
class ParseAddress extends SimpleXmlParser
{
    /**
     * @param $xml
     * @return Address[]
     */
    public function parse($xml)
    {
        $container = array();
        if ($this->doesAttributeExist($xml, 'postAdresses')) {
            $xml = $xml->postAdresses;
            if ($this->doesMoreThanOneElementExists($xml, 'postAddress')) {
                foreach ($xml->postAddress as $address) {
                    $container[] = $this->buildObject($address);
                }
            } else {
                if ($this->doesExactlyOneElementExists($xml, 'postAddress')) {
                    $container[] = $this->buildObject($xml->postAddress);
                }
            }
        }
        return $container;
    }

    /**
     * @param $xml
     * @return Address
     */
    protected function buildObject($xml)
    {
        $address = new Address();
        if ($this->isAttributeValid($xml, 'id')) {
            $address->setId($xml->id);
        }
        if ($this->isAttributeValid($xml, 'objGuid')) {
            $address->setObjGuid($xml->objGuid);
        }
        if ($this->isAttributeValid($xml, 'addresstagId')) {
            $address->setAddressTagId($xml->addresstagId);
        }
        if ($this->isAttributeValid($xml, 'sortorder')) {
            $address->setSortOrder($xml->sortorder);
        }
        if ($this->isAttributeValid($xml, 'personId')) {
            $address->setPersonId($xml->personId);
        }
        if ($this->isAttributeValid($xml, 'validTo')) {
            $address->setValidTo($xml->validTo);
        }
        if ($this->isAttributeValid($xml, 'validFrom')) {
            $address->setValidFrom($xml->validFrom);
        }
        if ($this->isAttributeValid($xml, 'orgunitLid')) {
            $address->setOrgUnitLid($xml->orgunitLid);
        }
        if ($this->isAttributeValid($xml, 'buildingId')) {
            $address->setBuildingId($xml->buildingId);
        }
        if ($this->isAttributeValid($xml, 'createdAt')) {
            $address->setCreatedAt($xml->createdAt);
        }
        if ($this->isAttributeValid($xml, 'updatedAt')) {
            $address->setUpdatedAt($xml->updatedAt);
        }
        if ($this->isAttributeValid($xml, 'postcode')) {
            $address->setPostCode($xml->postcode);
        }
        if ($this->isAttributeValid($xml, 'street')) {
            $address->setStreet($xml->street);
        }
        if ($this->isAttributeValid($xml, 'city')) {
            $address->setCity($xml->city);
        }
        if ($this->isAttributeValid($xml, 'addressaddition')) {
            $address->setAddressAddition($xml->addressaddition);
        }
        if ($this->isAttributeValid($xml, 'postofficebox')) {
            $address->setPostBoxOffice($xml->postofficebox);
        }
        if ($this->isAttributeValid($xml, 'company')) {
            $address->setCompany($xml->company);
        }
        if ($this->isAttributeValid($xml, 'state')) {
            $address->setState($xml->state);
        }
        if ($this->isAttributeValid($xml, 'countryId')) {
            $address->setCountryId($xml->countryId);
        }

        return $address;
    }
}