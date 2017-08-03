<?php

namespace HisInOneProxy\DataModel\Traits;

trait PersonId
{
	/**
	 * @var int
	 */
	protected $person_id;

	/**
	 * @return int
	 */
	public function getPersonId()
	{
		return $this->person_id;
	}

	/**
	 * @param int $person_id
	 */
	public function setPersonId($person_id)
	{
		$this->person_id = $person_id;
	}
}