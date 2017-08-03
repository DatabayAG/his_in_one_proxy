<?php

namespace HisInOneProxy\Parser;

use HisInOneProxy\DataModel;

class ParsePlannedDate extends SimpleXmlParser
{

	/**
	 * @param                       $xml
	 * @param DataModel\PlanElement $planElement
	 */
	public function parse($xml, $planElement)
	{
		foreach($xml->plannedDate as $value)
		{
			$planned_date = new DataModel\PlannedDate();
			if($this->isAttributeValid($value, 'id'))
			{
				$planned_date->setId($value->id);
				$this->log->info(sprintf('Found PlannedDate with id %s.', $planned_date->getId()));
				if($this->isAttributeValid($value, 'objGuid'))
				{
					$planned_date->setObjGuid($value->objGuid);
				}
				if($this->isAttributeValid($value, 'lockVersion'))
				{
					$planned_date->setLockVersion($value->lockVersion);
				}
				if($this->isAttributeValid($value, 'academictimespecificationId'))
				{
					$planned_date->setAcademicTimeSpecificationId($value->academictimespecificationId);
				}
				if($this->isAttributeValid($value, 'enddate'))
				{
					$planned_date->setEndDate($value->enddate);
				}
				if($this->isAttributeValid($value, 'endtime'))
				{
					$planned_date->setEndTime($value->endtime);
				}
				if($this->isAttributeValid($value, 'expectedAttendeesCount'))
				{
					$planned_date->setExpectedAttendeesCount($value->expectedAttendeesCount);
				}
				if($this->isAttributeValid($value, 'notice'))
				{
					$planned_date->setNotice($value->notice);
				}
				if($this->isAttributeValid($value, 'planelementId'))
				{
					$planned_date->setPlanElementId($value->planelementId);
				}
				if($this->isAttributeValid($value, 'rhythmId'))
				{
					$planned_date->setRhythmId($value->rhythmId);
				}
				if($this->isAttributeValid($value, 'roomId'))
				{
					$planned_date->setRoomId($value->roomId);
				}
				if($this->isAttributeValid($value, 'startdate'))
				{
					$planned_date->setStartDate($value->startdate);
				}
				if($this->isAttributeValid($value, 'starttime'))
				{
					$planned_date->setStartTime($value->starttime);
				}
				if($this->isAttributeValid($value, 'weekdayId'))
				{
					$planned_date->setWeekdayId($value->weekdayId);
				}
				if($this->isAttributeValid($value, 'individualDates'))
				{
					$parser = new ParseIndividualDates($this->log);
					$parser->parse($value->individualDates, $planned_date);
				}
				if($this->isAttributeValid($value, 'instructors'))
				{
					$parser = new ParseInstructors($this->log);
					$parser->parse($value->instructors, $planned_date);
				}
				if($this->isAttributeValid($value, 'planelementCancellations'))
				{
					$parser = new ParsePlanElementCancellation($this->log);
					$parser->parse($value->planelementCancellations, $planned_date);
				}
				if($this->isAttributeValid($value, 'planelementChanges'))
				{
					$parser = new ParsePlanElementChanges($this->log);
					$parser->parse($value->planelementChanges, $planned_date);
				}

				$planElement->appendPlannedDate($planned_date);
			}
			else
			{
				$this->log->warning('No id given for PlannedDate, skipping!');
			}
		}
	}
}
