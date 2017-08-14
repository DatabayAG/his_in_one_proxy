<?php

namespace HisInOneProxy\DataModel\Container;

use HisInOneProxy\DataModel\CourseMappingType;
use InvalidArgumentException;

/**
 * Class CourseMappingTypeContainer
 * @package HisInOneProxy\DataModel\Container
 */
class CourseMappingTypeContainer
{
	/**
	 * @var CourseMappingType[]
	 */
	protected $container;

	/**
	 * @return CourseMappingType[]
	 */
	public function getCourseMappingTypeContainer()
	{
		return $this->container;
	}

	/**
	 * @param \HisInOneProxy\DataModel\CourseMappingType $course_mapping_type
	 */
	public function appendCourseMappingType($course_mapping_type)
	{
		if(is_a($course_mapping_type, '\HisInOneProxy\DataModel\CourseMappingType'))
		{
			$this->container[trim($course_mapping_type->getId())] = $course_mapping_type;
		}
		else
		{
			throw new InvalidArgumentException();
		}
	}

	/**
	 * @param $id
	 * @return null|string
	 */
	public function translateIdToDefaultText($id)
	{
		if(array_key_exists($id, $this->container))
		{
			return $this->container[$id]->getUniqueName();
		}
		return null;
	}
}