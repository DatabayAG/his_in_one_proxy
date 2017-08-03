<?php

namespace HisInOneProxy\DataModel\Container;

use HisInOneProxy\DataModel\ChildRelation;
use InvalidArgumentException;

class ChildRelationContainer
{
	/**
	 * @var ChildRelation[]
	 */
	protected $container = array();

	/**
	 * @return ChildRelation[]
	 */
	public function getChildRelationContainer()
	{
		return $this->container;
	}

	/**
	 * @param ChildRelation $child_relation
	 */
	public function appendChildRelation($child_relation)
	{
		if(is_a($child_relation, '\HisInOneProxy\DataModel\ChildRelation'))
		{
			$this->container[ (string) $child_relation->getChildId()] = $child_relation;
		}
		else
		{
			throw new InvalidArgumentException();
		}
	}

	/**
	 * @param $id
	 * @param ChildRelation $child
	 */
	public function replaceChildInContainer($id, $child)
	{
		$this->container[$id] = $child;
	}

}