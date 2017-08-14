<?php

namespace HisInOneProxy\Parser;

use HisInOneProxy\DataModel;

/**
 * Class ParsePlanElementChanges
 * @package HisInOneProxy\Parser
 */
class ParsePlanElementChanges extends SimpleXmlParser
{

	/**
	 * @param                       $xml
	 * @param DataModel\PlannedDate $planned_date
	 */
	public function parse($xml, $planned_date)
	{
		foreach($xml->planelementChange as $value)
		{
			$plan_element_change = new DataModel\PlanElementChange();
			if($this->isAttributeValid($value, 'id'))
			{
				$plan_element_change->setId($value->id);
				$this->log->info(sprintf('Found PlanElementChange with id %s.', $plan_element_change->getId()));
				if($this->isAttributeValid($value, 'objGuid'))
				{
					$plan_element_change->setObjGuid($value->objGuid);
				}
				if($this->isAttributeValid($value, 'lockVersion'))
				{
					$plan_element_change->setLockVersion($value->lockVersion);
				}
				if($this->isAttributeValid($value, 'instructors'))
				{
					$parser = new ParseInstructors($this->log);
					$parser->parse($value->instructors, $plan_element_change);
				}
				if($this->isAttributeValid($value, 'languageId'))
				{
					$plan_element_change->setLanguageId($value->languageId);
				}
				if($this->isAttributeValid($value, 'newdate'))
				{
					$plan_element_change->setNewDate($value->newdate);
				}
				if($this->isAttributeValid($value, 'olddate'))
				{
					$plan_element_change->setOldDate($value->olddate);
				}
				if($this->isAttributeValid($value, 'plannedDatesId'))
				{
					$plan_element_change->setPlannedDatesId($value->plannedDatesId);
				}
				if($this->isAttributeValid($value, 'remark'))
				{
					$plan_element_change->setRemark($value->remark);
				}
				if($this->isAttributeValid($value, 'roomId'))
				{
					$plan_element_change->setRoomId($value->roomId);
				}
				if($this->isAttributeValid($value, 'starttime'))
				{
					$plan_element_change->setStartTime($value->starttime);
				}
				if($this->isAttributeValid($value, 'endtime'))
				{
					$plan_element_change->setEndTime($value->endtime);
				}

				$planned_date->appendPlanElementChange($plan_element_change);
			}
			else
			{
				$this->log->warning('No id given for PlanElementChange, skipping!');
			}
		}
	}
}
