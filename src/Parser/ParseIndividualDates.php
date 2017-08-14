<?php

namespace HisInOneProxy\Parser;

use HisInOneProxy\DataModel;

/**
 * Class ParseIndividualDates
 * @package HisInOneProxy\Parser
 */
class ParseIndividualDates extends SimpleXmlParser
{

	/**
	 * @param                       $xml
	 * @param DataModel\PlannedDate $planned_date
	 */
	public function parse($xml, $planned_date)
	{
		foreach($xml->individualDate as $value)
		{
			$individual_date = new DataModel\IndividualDate();

			if($this->isAttributeValid($value, 'id'))
			{
				$individual_date->setId($value->id);
				$this->log->info(sprintf('Found IndividualDate with id %s.', $individual_date->getId()));
				if($this->isAttributeValid($value, 'objGuid'))
				{
					$individual_date->setObjGuid($value->objGuid);
				}
				if($this->isAttributeValid($value, 'lockVersion'))
				{
					$individual_date->setLockVersion($value->lockVersion);
				}
				if($this->isAttributeValid($value, 'plannedDatesId'))
				{
					$individual_date->setPlannedDatesId($value->plannedDatesId);
				}
				if($this->isAttributeValid($value, 'executiondate'))
				{
					$individual_date->setExecutionDate($value->executiondate);
				}
				if($this->isAttributeValid($value, 'starttime'))
				{
					$individual_date->setStartTime($value->starttime);
				}
				if($this->isAttributeValid($value, 'endtime'))
				{
					$individual_date->setEndTime($value->endtime);
				}
				if($this->isAttributeValid($value, 'weekday'))
				{
					$individual_date->setWeekDay($value->weekday);
				}
				if($this->isAttributeValid($value, 'roomId'))
				{
					$individual_date->setRoomId($value->roomId);
				}
				$planned_date->appendIndividualDate($individual_date);
			}
			else
			{
				$this->log->warning('No id given for IndividualDate, skipping!');
			}
		}
	}
}
