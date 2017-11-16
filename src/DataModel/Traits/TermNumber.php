<?php

namespace HisInOneProxy\DataModel\Traits;
/**
 * Trait TermNumber
 * @package HisInOneProxy\DataModel\Traits
 */
trait TermNumber
{
	/**
	 * @var int
	 */
	protected $term_number;

	/**
	 * @return int
	 */
	public function getTermNumber()
	{
		return $this->term_number;
	}

	/**
	 * @param int term_number
	 */
	public function setTermNumber($term_number)
	{
		$this->term_number = $term_number;
	}
}