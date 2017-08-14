<?php

namespace HisInOneProxy\DataModel\Container;

use HisInOneProxy\DataModel\ExamRelation;
use HisInOneProxy\Exceptions;

/**
 * Class ExamRelationContainer
 * @package HisInOneProxy\DataModel\Container
 */
class ExamRelationContainer
{

	/**
	 * @var array
	 */
	protected $container;

	/**
	 * @return ExamRelation[]
	 */
	public function getExamRelationContainer()
	{
		return $this->container;
	}

	/**
	 * @param \HisInOneProxy\DataModel\ExamRelation $exam_relation
	 */
	public function appendExamRelation($exam_relation)
	{
		if(is_a($exam_relation, '\HisInOneProxy\DataModel\ExamRelation'))
		{
			$this->container[] = $exam_relation;
		}
		else
		{
			throw new Exceptions\InvalidExamRelation();
		}
	}
}
