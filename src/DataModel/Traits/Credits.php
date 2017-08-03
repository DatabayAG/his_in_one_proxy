<?php

namespace HisInOneProxy\DataModel\Traits;

trait Credits
{

	/**
	 * @var string
	 */
	protected $credits;

	/**
	 * @return string
	 */
	public function getCredits()
	{
		return $this->credits;
	}

	/**
	 * @param string $credits
	 */
	public function setCredits($credits)
	{
		$this->credits = $credits;
	}

}