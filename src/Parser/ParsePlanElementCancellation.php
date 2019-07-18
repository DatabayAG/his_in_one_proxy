<?php

namespace HisInOneProxy\Parser;

use HisInOneProxy\DataModel;

/**
 * Class ParsePlanElementCancellation
 * @package HisInOneProxy\Parser
 */
class ParsePlanElementCancellation extends SimpleXmlParser
{

    /**
     * @param                       $xml
     * @param DataModel\PlannedDate $planned_date
     */
    public function parse($xml, $planned_date)
    {
        foreach ($xml->planelementCancellation as $value) {
            $plan_element_cancellation = new DataModel\PlanElementCancellation();
            if ($this->isAttributeValid($value, 'id')) {
                $plan_element_cancellation->setId($value->id);
                $this->log->info(sprintf('Found PlanElementCancellation with id %s.', $plan_element_cancellation->getId()));
                if ($this->isAttributeValid($value, 'objGuid')) {
                    $plan_element_cancellation->setObjGuid($value->objGuid);
                }
                if ($this->isAttributeValid($value, 'lockVersion')) {
                    $plan_element_cancellation->setLockVersion($value->lockVersion);
                }
                if ($this->isAttributeValid($value, 'canceledDate')) {
                    $plan_element_cancellation->setCanceledDate($value->canceledDate);
                }
                if ($this->isAttributeValid($value, 'languageId')) {
                    $plan_element_cancellation->setLanguageId($value->languageId);
                }
                if ($this->isAttributeValid($value, 'plannedDatesId')) {
                    $plan_element_cancellation->setPlannedDatesId($value->plannedDatesId);
                }
                if ($this->isAttributeValid($value, 'remark')) {
                    $plan_element_cancellation->setRemark($value->remark);
                }

                $planned_date->appendPlanElementCancellation($plan_element_cancellation);
            } else {
                $this->log->warning('No id given for PlanElementCancellation, skipping!');
            }
        }
    }
}
