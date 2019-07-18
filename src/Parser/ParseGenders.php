<?php

namespace HisInOneProxy\Parser;

use HisInOneProxy\DataModel;

/**
 * Class ParseGenders
 * @package HisInOneProxy\Parser
 */
class ParseGenders extends SimpleXmlParser
{
    /**
     * @param $xml
     * @return DataModel\Gender[]
     */
    public function parse($xml)
    {
        $container = array();
        if ($this->doesAttributeExist($xml, 'listOfGenders')) {
            $xml = $xml->listOfGenders;
            if ($this->doesMoreThanOneElementExists($xml, 'gendervalue')) {
                foreach ($xml->gendervalue as $gender) {
                    $obj                            = $this->buildObject($gender);
                    $container[trim($obj->getId())] = $obj;
                }
            } else {
                if ($this->doesExactlyOneElementExists($xml, 'gendervalue')) {
                    $obj                            = $this->buildObject($xml->gendervalue);
                    $container[trim($obj->getId())] = $obj;
                }
            }
        }
        return $container;
    }

    /**
     * @param $xml
     * @return DataModel\Gender
     */
    protected function buildObject($xml)
    {
        $gender = new DataModel\Gender();
        if ($this->isAttributeValid($xml, 'id')) {
            $gender->setId($xml->id);
        }
        if ($this->isAttributeValid($xml, 'uniquename')) {
            $gender->setUniqueName($xml->uniquename);
        }
        if ($this->isAttributeValid($xml, 'shorttext')) {
            $gender->setShortText($xml->shorttext);
        }
        if ($this->isAttributeValid($xml, 'defaulttext')) {
            $gender->setDefaultText($xml->defaulttext);
        }
        if ($this->isAttributeValid($xml, 'longtext')) {
            $gender->setLongText($xml->longtext);
        }
        if ($this->isAttributeValid($xml, 'sortorder')) {
            $gender->setSortOrder($xml->sortorder);
        }
        if ($this->isAttributeValid($xml, 'defaultlanguage')) {
            $gender->setDefaultLanguage($xml->defaultlanguage);
        }
        if ($this->isAttributeValid($xml, 'objGuid')) {
            $gender->setObjGuid($xml->objGuid);
        }
        if ($this->isAttributeValid($xml, 'lettersalutation')) {
            $gender->setLetterSalutation($xml->lettersalutation);
        }
        if ($this->isAttributeValid($xml, 'hiskeyId')) {
            $gender->setHisKeyId($xml->hiskeyId);
        }
        if ($this->isAttributeValid($xml, 'formOfAddress')) {
            $gender->setFormOfAddress($xml->formOfAddress);
        }

        return $gender;
    }
}
