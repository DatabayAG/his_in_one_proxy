<?php

namespace HisInOneProxy\Parser;

use HisInOneProxy\DataModel;

/**
 * Class ParsePlanningPreference
 * @package HisInOneProxy\Parser
 */
class ParsePlanningPreference extends SimpleXmlParser
{
    /**
     * @param         $xml
     * @return DataModel\PlanningPreference
     */
    public function parse($xml)
    {
        $planning_preference = new DataModel\PlanningPreference();

        if ($this->isAttributeValid($xml, 'id')) {
            $planning_preference->setId($xml->id);
            $this->log->info(sprintf('Found PlanningPreference with id %s.', $planning_preference->getId()));
            if ($this->isAttributeValid($xml, 'objGuid')) {
                $planning_preference->setObjGuid($xml->objGuid);
            }
            if ($this->isAttributeValid($xml, 'lockVersion')) {
                $planning_preference->setLockVersion($xml->lockVersion);
            }
            if ($this->isAttributeValid($xml, 'comment')) {
                $planning_preference->setComment($xml->comment);
            }
            if ($this->isAttributeValid($xml, 'fixedTime')) {
                $planning_preference->setFixedTime($xml->fixedTime);
            }
            if ($this->isAttributeValid($xml, 'ownerPlanelementId')) {
                $planning_preference->setOwnerPlanElementId($xml->ownerPlanelementId);
            }
            if ($this->isAttributeValid($xml, 'partsInARow')) {
                $planning_preference->setPartsInARow($xml->partsInARow);
            }
            if ($this->isAttributeValid($xml, 'termTypeValueId')) {
                $planning_preference->setTermTypeValueId($xml->termTypeValueId);
            }
            if ($this->isAttributeValid($xml, 'preferenceParts')) {
                $parser = new ParsePlanElementPreferenceParts($this->log);
                $parser->parse($xml->preferenceParts, $planning_preference);
            }
            if ($this->isAttributeValid($xml, 'timePreferences')) {
                $parser = new ParseTimePreferences($this->log);
                $parser->parse($xml->timePreferences, $planning_preference);
            }
        } else {
            $this->log->warning('No id given for PlanningPreference, skipping!');
        }

        return $planning_preference;
    }
}
