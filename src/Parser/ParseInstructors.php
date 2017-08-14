<?php

namespace HisInOneProxy\Parser;

use HisInOneProxy\DataModel;

/**
 * Class ParseInstructors
 * @package HisInOneProxy\Parser
 */
class ParseInstructors extends SimpleXmlParser
{

	/**
	 * @param                                                     $xml
	 * @param DataModel\PlannedDate | DataModel\PlanElementChange $planned_date
	 */
	public function parse($xml, $planned_date)
	{
		foreach($xml->instructor as $value)
		{
			$instructor = new DataModel\Instructor();

			if($this->isAttributeValid($value, 'id'))
			{
				$instructor->setId($value->id);
				$this->log->info(sprintf('Found Instructor with id %s.', $instructor->getId()));
				if($this->isAttributeValid($value, 'objGuid'))
				{
					$instructor->setObjGuid($value->objGuid);
				}
				if($this->isAttributeValid($value, 'lockVersion'))
				{
					$instructor->setLockVersion($value->lockVersion);
				}
				if($this->isAttributeValid($value, 'examinationsubareaId'))
				{
					$instructor->setExaminationSubareaId($value->examinationsubareaId);
				}
				if($this->isAttributeValid($value, 'instructortaskId'))
				{
					$instructor->setInstructorTaskId($value->instructortaskId);
				}
				if($this->isAttributeValid($value, 'personId'))
				{
					$instructor->setPersonId($value->personId);
				}
				if($this->isAttributeValid($value, 'planelementChangeId'))
				{
					$instructor->setPlanElementChangeId($value->planelementChangeId);
				}
				if($this->isAttributeValid($value, 'plannedDatesId'))
				{
					$instructor->setPlannedDatesId($value->plannedDatesId);
				}
				if($this->isAttributeValid($value, 'sortorder'))
				{
					$instructor->setSortOrder($value->sortorder);
				}
				if($this->isAttributeValid($value, 'teachingLoadPercentage'))
				{
					$instructor->setTeachingLoadPercentage($value->teachingLoadPercentage);
				}
				if($this->isAttributeValid($value, 'weight'))
				{
					$instructor->setWeight($value->weight);
				}
				$planned_date->appendInstructor($instructor);
			}
			else
			{
				$this->log->warning('No id given for Instructor, skipping!');
			}
		}
	}
}
