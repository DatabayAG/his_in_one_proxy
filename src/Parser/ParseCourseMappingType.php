<?php

namespace HisInOneProxy\Parser;

use HisInOneProxy\DataModel;

/**
 * Class ParseCourseMappingType
 * @package HisInOneProxy\Parser
 */
class ParseCourseMappingType extends SimpleXmlParser
{
    /**
     * @param $xml
     * @return DataModel\Container\CourseMappingTypeContainer
     */
    public function parse($xml)
    {
        $container = new DataModel\Container\CourseMappingTypeContainer();
        if ($this->isAttributeValid($xml, 'coursemappingtypevalue')) {
            foreach ($xml->coursemappingtypevalue as $value) {
                $type = new DataModel\CourseMappingType();
                if ($this->isAttributeValid($value, 'id')) {
                    $type->setId($value->id);
                    $this->log->info(sprintf('Found elearning plattfomr mapping with id %s.', $type->getId()));

                    if ($this->isAttributeValid($value, 'uniquename')) {
                        $type->setUniqueName($value->uniquename);
                    }
                    if ($this->isAttributeValid($value, 'shorttext')) {
                        $type->setShortText($value->shorttext);
                    }
                    if ($this->isAttributeValid($value, 'defaulttext')) {
                        $type->setDefaultText($value->defaulttext);
                    }
                    if ($this->isAttributeValid($value, 'longtext')) {
                        $type->setLongText($value->longtext);
                    }
                    if ($this->isAttributeValid($value, 'sortorder')) {
                        $type->setSortOrder($value->sortorder);
                    }
                    if ($this->isAttributeValid($value, 'defaultlanguage')) {
                        $type->setLanguageId($value->defaultlanguage);
                    }
                    if ($this->isAttributeValid($value, 'objGuid')) {
                        $type->setObjGuid($value->objGuid);
                    }
                    if ($this->isAttributeValid($value, 'hiskeyId')) {
                        $type->setHisKeyId($value->hiskeyId);
                    }
                    $container->appendCourseMappingType($type);
                } else {
                    $this->log->warning('No id given for elearning course mapping, skipping!');
                }
            }
        }

        return $container;
    }
}