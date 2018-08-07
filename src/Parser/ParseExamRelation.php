<?php

namespace HisInOneProxy\Parser;

use HisInOneProxy\Config\GlobalSettings;
use HisInOneProxy\DataModel;
use HisInOneProxy\Soap\Interactions\DataCache;

/**
 * Class ParseExamRelation
 * @package HisInOneProxy\Parser
 */
class ParseExamRelation extends SimpleXmlParser
{
	/**
	 * @param $xml
	 * @param DataModel\PlanElement $plan_element
	 */
	public function parse($xml, $plan_element)
	{
		if(isset($xml->examplans))
		{
			$xml = $xml->examplans;
			if($this->doesMoreThanOneElementExists($xml, 'examplan'))
			{
				foreach($xml->examplan as $value)
				{
					$exam_relation = $this->buildExamRelation($value);
					$plan_element->appendPersonPlanElement($exam_relation);
				}
			}
			else
			{
				if($this->doesAttributeExist($xml, 'examplan'))
				{
					$exam_relation = $this->buildExamRelation($xml->examplan);
					$plan_element->appendPersonPlanElement($exam_relation);
				}
			}
		}
	}

	/**
	 * @param $data
	 * @return DataModel\ExamRelation
	 */
	protected function buildExamRelation($data)
	{
		$exam_relation = new DataModel\ExamRelation();
		if($this->isAttributeValid($data, 'personId'))
		{
			$exam_relation->setPersonId($data->personId);
			DataCache::getInstance()->appendPersonIdToCache($data->personId);
			$this->log->info(sprintf('Added person id %s.', $data->personId));
			$this->log->info(sprintf('Found ExamRelation with id %s.', $exam_relation->getPersonId()));
			if($this->isAttributeValid($data, 'cancellation'))
			{
				$exam_relation->setCancellation($data->cancellation);
			}
			if($this->isAttributeValid($data, 'planelementId'))
			{
				$exam_relation->setPlanElementId($data->planelementId);
			}
			if($this->isAttributeValid($data, 'unitId'))
			{
				$exam_relation->setUnitId($data->unitId);
			}
			if($this->isAttributeValid($data, 'workstatusId'))
			{
				if($data->workstatusId != 8) // 8 = zugelassen
				{
					$this->log->warning(sprintf('Found ExamRelation with work status id %s != 8.', $data->workstatusId));
				}
				$exam_relation->setWorkStatusId($data->workstatusId);
			}
		}
		else
		{
			$this->log->warning('No id given for ExamRelation, skipping!');
			$this->log->debug(var_dump($value));
		}
		return $exam_relation;
	}
}