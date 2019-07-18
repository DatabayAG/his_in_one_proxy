<?php

namespace HisInOneProxy\Parser;

use HisInOneProxy\DataModel;

/**
 * Class ParseElearningCourseMapping
 * @package HisInOneProxy\Parser
 */
class ParseElearningCourseMapping extends SimpleXmlParser
{

    /**
     * @param $xml
     * @return DataModel\ElearningCourseMapping[]
     */
    public function parse($xml)
    {
        $map = array();
        if ($this->isAttributeValid($xml, 'courseCombinations')) {
            foreach ($xml->courseCombinations as $value) {
                $mapping = new DataModel\ElearningCourseMapping();
                if ($this->isAttributeValid($value, 'unitId')) {
                    $mapping->setUnitId($value->unitId);
                    $this->log->info(sprintf('Found elearning course mapping with id %s.', $mapping->getUnitId()));
                    if ($this->isAttributeValid($value, 'courseMappingTypeId')) {
                        $mapping->setCourseMappingTypeId($value->courseMappingTypeId);
                    }
                    if ($this->isAttributeValid($value, 'elearningSystemId')) {
                        $mapping->setELearningSystemId($value->elearningSystemId);
                    }
                    if ($this->isAttributeValid($value, 'termTypeValueId')) {
                        $mapping->setTermTypeValueId($value->termTypeValueId);
                    }
                    if ($this->isAttributeValid($value, 'year')) {
                        $mapping->setYear($value->year);
                    }
                    $map[] = $mapping;
                } else {
                    $this->log->warning('No id given for elearning course mapping, skipping!');
                }
            }
        }

        return $map;
    }
}
