<?php

namespace HisInOneProxy\Parser;

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
	 */
	public function parse($xml, $plan_element)
	{
		foreach($xml->personExternals as $person)
		{
			$person_externals = new DataModel\PersonExternals();
			if(isset($person->abstractPersonId) && $person->abstractPersonId != null && $person->abstractPersonId != '')
			{
				$person_externals->setPlanElementId($plan_element->getId());

				$this->log->info(sprintf('Found PersonPlanElement with planelementId %s.', $person_externals->getPlanElementId()));
				if(isset($person->abstractPersonId))
				{
					$person_externals->setPersonId($person->abstractPersonId);
					DataCache::getInstance()->appendPersonIdToCache($person->abstractPersonId);
					$this->log->info(sprintf('Added person id %s.', $person->abstractPersonId));
				}
				if(isset($person->sortorder))
				{
					$person_externals->setSortOrder($person->sortorder);
				}
				$plan_element->appendPersonExternalsElement($person_externals);
			}
			else
			{
				$this->log->warning('No id given for PersonExternals, skipping!');
			}
		}
	}
}
