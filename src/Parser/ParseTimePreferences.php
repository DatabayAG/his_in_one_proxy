<?php

namespace HisInOneProxy\Parser;

use HisInOneProxy\DataModel;

/**
 * Class ParseTimePreferences
 * @package HisInOneProxy\Parser
 */
class ParseTimePreferences extends SimpleXmlParser
{

    /**
     * @param                              $xml
     * @param DataModel\PlanningPreference $planningPreference
     */
    public function parse($xml, $planningPreference)
    {
        foreach ($xml->timePreference as $value) {
            $time_preference = new DataModel\TimePreference();

            if ($this->isAttributeValid($value, 'id')) {
                $time_preference->setId($value->id);
                $this->log->info(sprintf('Found TimePreference with id %s.', $time_preference->getId()));
                if ($this->isAttributeValid($value, 'objGuid')) {
                    $time_preference->setObjGuid($value->objGuid);
                }
                if ($this->isAttributeValid($value, 'lockVersion')) {
                    $time_preference->setLockVersion($value->lockVersion);
                }
                if ($this->isAttributeValid($value, 'ownerPersonPreferenceId')) {
                    $time_preference->setOwnerPersonPreferenceId($value->ownerPersonPreferenceId);
                }
                if ($this->isAttributeValid($value, 'ownerPlanelementPreferenceId')) {
                    $time_preference->setOwnerPlanElementPreferenceId($value->ownerPlanelementPreferenceId);
                }
                if ($this->isAttributeValid($value, 'ownerRoomclassId')) {
                    $time_preference->setOwnerRoomClassId($value->ownerRoomclassId);
                }
                if ($this->isAttributeValid($value, 'termTypeValueId')) {
                    $time_preference->setTermTypeValueId($value->termTypeValueId);
                }
                if ($this->isAttributeValid($value, 'timeslot')) {
                    $parser = new ParseTimeSlot($this->log);
                    $time_preference->appendTimeSlot($parser->parse($value->timeslot));
                }
                if ($this->isAttributeValid($value, 'weightingFactor')) {
                    $time_preference->setWeightingFactor($value->weightingFactor);
                }
                if ($this->isAttributeValid($value, 'year')) {
                    $time_preference->setYear($value->year);
                }
                $planningPreference->appendTimePreference($time_preference);
            } else {
                $this->log->warning('No id given for TimePreference, skipping!');
            }
        }
    }
}
