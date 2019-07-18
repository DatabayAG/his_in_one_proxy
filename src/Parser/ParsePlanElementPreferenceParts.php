<?php

namespace HisInOneProxy\Parser;

use HisInOneProxy\DataModel;

/**
 * Class ParsePlanElementPreferenceParts
 * @package HisInOneProxy\Parser
 */
class ParsePlanElementPreferenceParts extends SimpleXmlParser
{

    /**
     * @param                              $xml
     * @param DataModel\PlanningPreference $planningPreference
     */
    public function parse($xml, $planningPreference)
    {
        foreach ($xml->planelementPreferencePart as $value) {
            $plan_element_preference_part = new DataModel\PlanElementPreferencePart();

            if ($this->isAttributeValid($value, 'id')) {
                $plan_element_preference_part->setId($value->id);
                $this->log->info(sprintf('Found PlanElementPreferencePart with id %s.', $plan_element_preference_part->getId()));
                if ($this->isAttributeValid($value, 'objGuid')) {
                    $plan_element_preference_part->setObjGuid($value->objGuid);
                }
                if ($this->isAttributeValid($value, 'lockVersion')) {
                    $plan_element_preference_part->setLockVersion($value->lockVersion);
                }
                if ($this->isAttributeValid($value, 'belongsToPlanelementPreferenceId')) {
                    $plan_element_preference_part->setBelongsToPlanElementPreferenceId($value->belongsToPlanelementPreferenceId);
                }
                if ($this->isAttributeValid($value, 'preferredInstructors')) {
                    $parser = new ParsePreferredInstructors($this->log);
                    $parser->parse($value->preferredInstructors, $plan_element_preference_part);
                }
                if ($this->isAttributeValid($value, 'preferredRooms')) {
                    $parser = new ParsePreferredRooms($this->log);
                    $parser->parse($value->preferredRooms, $plan_element_preference_part);
                }
                $planningPreference->appendPlanElementPreferencePart($plan_element_preference_part);
            } else {
                $this->log->warning('No id given for PlanElementPreferencePart, skipping!');
            }
        }
    }
}
