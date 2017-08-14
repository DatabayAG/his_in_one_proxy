<?php

namespace HisInOneProxy\DataModel\Traits;
/**
 * Trait Lid
 * @package HisInOneProxy\DataModel\Traits
 */
trait Lid
{
	/**
	 * @var int
	 */
	protected $lid;

	/**
	 * @return int
	 */
	public function getLid()
	{
		return $this->lid;
	}

	/**
	 * @param int $lid
	 */
	public function setLid($lid)
	{
		$this->lid = $lid;
	}

}