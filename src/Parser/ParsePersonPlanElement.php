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
	 * @param $xml
	 * @param DataModel\PlanElement $plan_element
	 * @throws \Exception
	 */
	public function parse($xml, $plan_element)
	{
		foreach($xml->personPlanelements as $value)
		{
			$person_plan_element = new DataModel\PersonPlanElement();
			if(isset($value->personPlanelement)) {
				$value = $value->personPlanelement;
			}
			if(isset($value->planelementId) && $value->planelementId != null && $value->planelementId != '')
			{
				$person_plan_element->setPlanElementId($value->planelementId);

				$this->log->info(sprintf('Found PersonPlanElement with planelementId %s.', $person_plan_element->getPlanElementId()));
				if(isset($value->abstractPersonId))
				{
					$person_plan_element->setPersonId($value->abstractPersonId);
					DataCache::getInstance()->appendPersonIdToCache($value->abstractPersonId);
					$this->log->info(sprintf('Added person id %s.', $value->abstractPersonId));
				}
				if(isset($value->sortorder))
				{
					$person_plan_element->setSortOrder($value->sortorder);
				}
				$plan_element->appendPersonPlanElement($person_plan_element);
			}
			else
			{
				$this->log->warning('No id given for PersonPlanElement, skipping!');
			}
		}
	}
}
