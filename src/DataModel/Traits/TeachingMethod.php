<?php

namespace HisInOneProxy\DataModel\Traits;
/**
 * Trait TeachingMethod
 * @package HisInOneProxy\DataModel\Traits
 */
trait TeachingMethod
{

	/**
	 * @var string
	 */
	protected $teaching_method;

	/**
	 * @return string
	 */
	public function getTeachingMethod()
	{
		return $this->teaching_method;
	}

	/**
	 * @param string $teaching_method
	 */
	public function setTeachingMethod($teaching_method)
	{
		$this->teaching_method = $teaching_method;
	}
}