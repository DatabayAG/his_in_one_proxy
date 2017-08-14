<?php

namespace HisInOneProxy\Parser;

use HisInOneProxy\DataModel;

/**
 * Class ParsePreferredInstructors
 * @package HisInOneProxy\Parser
 */
class ParsePreferredInstructors extends SimpleXmlParser
{

	/**
	 * @param                                     $xml
	 * @param DataModel\PlanElementPreferencePart $plan_element_preference_part
	 */
	public function parse($xml, $plan_element_preference_part)
	{
		foreach($xml->instructor as $value)
		{
			$preferred_instructor = new DataModel\PreferredInstructor();
			if($this->isAttributeValid($value, 'id'))
			{
				$preferred_instructor->setId($value->id);
				$this->log->info(sprintf('Found PreferredInstructor with id %s.', $preferred_instructor->getId()));
				if($this->isAttributeValid($value, 'objGuid'))
				{
					$preferred_instructor->setObjGuid($value->objGuid);
				}
				if($this->isAttributeValid($value, 'lockVersion'))
				{
					$preferred_instructor->setLockVersion($value->lockVersion);
				}
				if($this->isAttributeValid($value, 'preferredInstructorId'))
				{
					$preferred_instructor->setPreferredInstructorId($value->preferredInstructorId);
				}
				if($this->isAttributeValid($value, 'preferredInstructorForPlanelementPartsId'))
				{
					$preferred_instructor->setPreferredInstructorForPlanElementPartsId($value->preferredInstructorForPlanelementPartsId);
				}
				if($this->isAttributeValid($value, 'priority'))
				{
					$preferred_instructor->setPriority($value->priority);
				}

				$plan_element_preference_part->appendPreferredInstructors($preferred_instructor);
			}
			else
			{
				$this->log->warning('No id given for PreferredInstructor, skipping!');
			}
		}
	}
}
