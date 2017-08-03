<?php

namespace HisInOneProxy\Parser;

use HisInOneProxy\DataModel\ChildRelation;
use HisInOneProxy\DataModel\Container\ChildRelationContainer;

class ParseChildRelation extends SimpleXmlParser
{
	/**
	 * @param $xml
	 * @return ChildRelationContainer
	 */
	public function parse($xml)
	{
		$child_relation_container = new ChildRelationContainer();
		if($this->doesMoreThanOneElementExists($xml, 'childRelation'))
		{
			foreach($xml->childRelation as $relation)
			{
				$this->buildObject($relation, $child_relation_container);
			}
		}
		else if($this->doesExactlyOneElementExists($xml, 'childRelation'))
		{
			$this->buildObject($xml->childRelation, $child_relation_container);
		}

		return $child_relation_container;
	}

	/**
	 * @param                        $relation
	 * @param ChildRelationContainer $child_relation_container
	 */
	protected function buildObject($relation, $child_relation_container)
	{
		$child = new ChildRelation();
		if($this->isAttributeValid($relation, 'childId'))
		{
			$child->setChildId($relation->childId);
		}
		if($this->isAttributeValid($relation, 'parentId'))
		{
			$child->setParentId($relation->parentId);
			#	DataCache::getInstance()->appendToChildRelationMap($child);
		}
		if(!isset($relation->childId) || !isset($relation->parentId) || $relation->parentId == null || $relation->childId == null)
		{
			$this->log->warning('No parent or child id given!');
		}

		$child_relation_container->appendChildRelation($child);
	}
}