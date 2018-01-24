<?php

namespace HisInOneProxy\Parser;

use HisInOneProxy\DataModel;

/**
 * Class ParsePlanElements
 * @package HisInOneProxy\Parser
 */
class ParsePlanElements extends SimpleXmlParser
{

	/**
	 * @param                $xml
	 * @param DataModel\Unit $unit
	 * @return bool
	 */
	public function parse($xml, $unit)
	{
		foreach($xml->planelements as $value)
		{
			if(is_array($value))
			{
				foreach($value as $planElement)
				{
					$this->parseElement($planElement, $unit);
				}
			}
			else
			{
				$this->parseElement($value, $unit);
			}
		}
		if($unit->getSizeOfPlanElementContainer() > 0)
		{
			return true;
		}
		return false;
	}

	/**
	 * @param $value
	 * @param DataModel\Unit $unit
	 */
	protected function parseElement($value, $unit)
	{
		if($this->isAttributeValid($value, 'id'))
		{
			$plan_element = new DataModel\PlanElement();
			$plan_element->setId($value->id);
			$this->log->info(sprintf('Found PlanElement with id %s.', $plan_element->getId()));
			if($this->isAttributeValid($value, 'objGuid'))
			{
				$plan_element->setObjGuid($value->objGuid);
			}
			if($this->isAttributeValid($value, 'lockVersion'))
			{
				$plan_element->setLockVersion($value->lockVersion);
			}
			if($this->isAttributeValid($value, 'attendeeMaximum'))
			{
				$plan_element->setAttendeeMaximum($value->attendeeMaximum);
			}
			if($this->isAttributeValid($value, 'attendeeMinimum'))
			{
				$plan_element->setAttendeeMinimum($value->attendeeMinimum);
			}
			if($this->isAttributeValid($value, 'cancelEnd'))
			{
				$plan_element->setCancelEnd($value->cancelEnd);
			}
			if($this->isAttributeValid($value, 'cancelled'))
			{
				$plan_element->setCancelled($value->cancelled);
			}
			if($this->isAttributeValid($value, 'defaultlanguage'))
			{
				$plan_element->setDefaultLanguage($value->defaultlanguage);
			}
			if($this->isAttributeValid($value, 'defaulttext'))
			{
				//Todo: change this to a more dynamic approach
				$plan_element->setShortText($value->defaulttext);
				$plan_element->setDefaultText($value->defaulttext);
			}
			if($this->isAttributeValid($value, 'genderId'))
			{
				$plan_element->setGenderId($value->genderId);
			}
			if($this->isAttributeValid($value, 'gradeAssessmentStatusId'))
			{
				$plan_element->setGradeAssessmentStatusId($value->gradeAssessmentStatusId);
			}
			if($this->isAttributeValid($value, 'hoursPerWeek'))
			{
				$plan_element->setHoursPerWeek($value->hoursPerWeek);
			}
			if($this->isAttributeValid($value, 'longtext'))
			{
				$plan_element->setLongText($value->longtext);
			}
			if($this->isAttributeValid($value, 'parallelgroupId'))
			{
				$plan_element->setParallelGroupId($value->parallelgroupId);
			}
			if($this->isAttributeValid($value, 'registerBegin'))
			{
				$plan_element->setRegisterBegin($value->registerBegin);
			}
			if($this->isAttributeValid($value, 'registerEnd'))
			{
				$plan_element->setRegisterEnd($value->registerEnd);
			}
			if($this->isAttributeValid($value, 'rotation'))
			{
				$plan_element->setRotation($value->rotation);
			}
			if($this->isAttributeValid($value, 'shorttext'))
			{
				#$plan_element->setShortText($value->shorttext);
			}
			if($this->isAttributeValid($value, 'termSegment'))
			{
				$plan_element->setTermSegment($value->termSegment);
			}
			if($this->isAttributeValid($value, 'termTypeValueId'))
			{
				$plan_element->setTermTypeValueId($value->termTypeValueId);
			}
			if($this->isAttributeValid($value, 'unitId'))
			{
				$plan_element->setUnitId($value->unitId);
			}
			if($this->isAttributeValid($value, 'year'))
			{
				$plan_element->setYear($value->year);
			}
			if($this->isAttributeValid($value, 'eventDate'))
			{
				$parser = new ParseEventDate($this->log);
				$parser->parse($value->eventDate, $plan_element);
			}
			if($this->isAttributeValid($value, 'planningPreference'))
			{
				$parser = new ParsePlanningPreference($this->log);
				$plan_element->setPlanningPreference($parser->parse($value->planningPreference));
			}
			if($this->isAttributeValid($value, 'personPlanelements'))
			{
				$parser = new ParsePersonPlanElement($this->log);
				$parser->parse($value->personPlanelements, $plan_element);
			}
			if($this->isAttributeValid($value, 'plannedDates'))
			{
				$parser = new ParsePlannedDate($this->log);
				$parser->parse($value->plannedDates, $plan_element);
			}
			$unit->appendPlanElement($plan_element);
		}
		else
		{
			$this->log->warning('No id given for PlanElement, skipping!');
		}
	}
}
