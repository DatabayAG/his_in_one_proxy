<?php

namespace HisInOneProxy\Parser;

use HisInOneProxy\DataModel;

/**
 * Class ParseParallelGroupValues
 * @package HisInOneProxy\Parser
 */
class ParseParallelGroupValues extends SimpleXmlParser
{
	/**
	 * @param $xml
	 * @return DataModel\Container\ParallelGroupValuesContainer
	 */
	public function parse($xml)
	{
		$container = new DataModel\Container\ParallelGroupValuesContainer();

		foreach($xml->parallelgroupvalue as $value)
		{
			if($this->isAttributeValid($value, 'id'))
			{
				$group_value = new DataModel\ParallelGroupValue();
				$group_value->setId($value->id);
				$this->log->info(sprintf('Found OrgUnit with id %s.', $group_value->getId()));
				if($this->isAttributeValid($value, 'uniquename'))
				{
					$group_value->setUniqueName($value->uniquename);
				}
				if($this->isAttributeValid($value, 'shorttext'))
				{
					$group_value->setShortText($value->shorttext);
				}
				if($this->isAttributeValid($value, 'displaytext'))
				{
					$group_value->setDefaultText($value->displaytext);
				}
				if($this->isAttributeValid($value, 'longtext'))
				{
					$group_value->setLongText($value->longtext);
				}
				if($this->isAttributeValid($value, 'sortorder'))
				{
					$group_value->setSortOrder($value->sortorder);
				}
				if($this->isAttributeValid($value, 'defaultlanguage'))
				{
					$group_value->setLanguageId($value->defaultlanguage);
				}
				if($this->isAttributeValid($value, 'objGuid'))
				{
					$group_value->setObjGuid($value->objGuid);
				}
				$container->appendParallelGroupValue($group_value);
			}
			else
			{
				$this->log->warning('No id given for OrgUnit, skipping!');
			}
		}

		return $container;
	}
}