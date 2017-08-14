<?php

namespace HisInOneProxy\DataModel\Traits;
/**
 * Trait TeachingLanguageId
 * @package HisInOneProxy\DataModel\Traits
 */
trait TeachingLanguageId
{

	/**
	 * @var int
	 */
	protected $teaching_language_id;

	/**
	 * @return int
	 */
	public function getTeachingLanguageId()
	{
		return $this->teaching_language_id;
	}

	/**
	 * @param int $teaching_language_id
	 */
	public function setTeachingLanguageId($teaching_language_id)
	{
		$this->teaching_language_id = $teaching_language_id;
	}

}