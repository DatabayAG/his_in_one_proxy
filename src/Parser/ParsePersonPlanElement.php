<?php

namespace HisInOneProxy\Parser;

use HisInOneProxy\DataModel;
use HisInOneProxy\Soap\Interactions\DataCache;

/**
 * Class ParsePersonPlanElement
 * @package HisInOneProxy\Parser
 */
class ParsePersonPlanElement extends SimpleXmlParser
{
    /**
     * @param                       $xml
     * @param DataModel\PlanElement $plan_element
     * @throws \Exception
     */
    public function parse($xml, $plan_element)
    {
        if ($this->doesAttributeExist($xml, 'personPlanelements')) {
            $xml = $xml->personPlanelements;
            if ($this->doesMoreThanOneElementExists($xml, 'personPlanelement')) {
                foreach ($xml->personPlanelement as $value) {
                    $this->parseElement($value, $plan_element);
                }
            } else {
                $this->parseElement($xml->personPlanelement, $plan_element);
            }
        }
    }

    /**
     * @param $xml
     * @param $plan_element
     * @param $person_plan_element
     * @throws \Exception
     */
    protected function parseElement($xml, $plan_element)
    {
        $person_plan_element = new DataModel\PersonPlanElement();
        if (isset($xml->personPlanelement)) {
            $xml = $xml->personPlanelement;
        }

        if (isset($xml->planelementId) && $xml->planelementId != null && $xml->planelementId != '') {
            $person_plan_element->setPlanElementId($xml->planelementId);

            $this->log->info(sprintf('Found PersonPlanElement with planelementId %s.', $person_plan_element->getPlanElementId()));
            if (isset($xml->abstractPersonId)) {
                $person_plan_element->setPersonId($xml->abstractPersonId);
                DataCache::getInstance()->appendPersonIdToCache($xml->abstractPersonId);
                $this->log->info(sprintf('Added person id %s.', $xml->abstractPersonId));
            }
            if (isset($xml->sortorder)) {
                $person_plan_element->setSortOrder($xml->sortorder);
            }
            $plan_element->appendPersonPlanElement($person_plan_element);
        } else {
            $this->log->warning('No id given for PersonPlanElement, skipping!');
        }
    }
}
