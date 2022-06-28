<?php

namespace HisInOneProxy\Parser;

use Exception;
use HisInOneProxy\DataModel;
use HisInOneProxy\Soap\Interactions\DataCache;

/**
 * Class ParsePersonPlanElement
 * @package HisInOneProxy\Parser
 */
class ParsePersonExternals extends SimpleXmlParser
{
    /**
     * @param                       $xml
     * @param DataModel\PlanElement $plan_element
     * @throws Exception
     */
    public function parse($xml, $plan_element, $nullablePlanElementId = null)
    {
        if ($this->doesAttributeExist($xml, 'personExternals')) {
            $xml = $xml->personExternals;
            if ($this->doesMoreThanOneElementExists($xml, 'personExternal')) {
                foreach ($xml->personExternal as $value) {
                    $this->parseElement($value, $plan_element, $nullablePlanElementId);
                }
            } else {
                $this->parseElement($xml, $plan_element, $nullablePlanElementId);
            }
        }
    }

    /**
     * @param $xml
     * @param $plan_element
     * @return void
     * @throws Exception
     */
    protected function parseElement($xml, $plan_element, $nullablePlanElementId)
    {
        if (isset($xml->personExternal)) {
            $xml = $xml->personExternal;
        }
        $person_externals = new DataModel\PersonExternals();
        if ($nullablePlanElementId || (isset($xml->abstractPersonId) && $xml->abstractPersonId != null && $xml->abstractPersonId != '')) {
            $person_externals->setPlanElementId($plan_element->getId());
            if($nullablePlanElementId) {
                $person_externals->setPlanElementId($xml->planelemntId);
            }
            
            $this->log->info(sprintf('Found PersonPlanElement with planelementId %s.', $person_externals->getPlanElementId()));
            if (isset($xml->abstractPersonId)) {
                $person_externals->setPersonId($xml->abstractPersonId);
                DataCache::getInstance()->appendPersonIdToCache($xml->abstractPersonId);
                $this->log->info(sprintf('Added person id %s.', $xml->abstractPersonId));
            }
            if (isset($xml->sortorder)) {
                $person_externals->setSortOrder($xml->sortorder);
            }
            $plan_element->appendPersonPlanElement($person_externals);
        } else {
            $this->log->warning('No id given for PersonExternals, skipping!');
        }
    }
}
