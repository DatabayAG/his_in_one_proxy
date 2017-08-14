<?php

namespace HisInOneProxy\DataModel\Traits;
/**
 * Trait Year
 * @package HisInOneProxy\DataModel\Traits
 */
trait Year
{

	/**
	 * @var int
	 */
	protected $year;

	/**
	 * @return int
	 */
	public function getYear()
	{
		return $this->year;
	}

	/**
	 * @param int $year
	 */
	public function setYear($year)
	{
		$this->year = $year;
	}

}