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
	protected $term_umber;

	/**
	 * @return int
	 */
	public function getTermNumber()
	{
		return $this->term_umber;
	}

	/**
	 * @param int $term_umber
	 */
	public function setTermNumber($term_umber)
	{
		$this->term_umber = $term_umber;
	}
}