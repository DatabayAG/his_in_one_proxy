<?php

namespace HisInOneProxy\DataModel\Traits;
/**
 * Trait GenderId
 * @package HisInOneProxy\DataModel\Traits
 */
trait GenderId
{

	/**
	 * @var int
	 */
	protected $gender_id;

	/**
	 * @return int
	 */
	public function getGenderId()
	{
		return $this->gender_id;
	}

	/**
	 * @param int $gender_id
	 */
	public function setGenderId($gender_id)
	{
		$this->gender_id = $gender_id;
	}

}