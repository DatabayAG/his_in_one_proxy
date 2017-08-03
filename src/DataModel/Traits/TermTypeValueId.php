<?php

namespace HisInOneProxy\DataModel\Traits;

trait TermTypeValueId
{

	/**
	 * @var int
	 */
	protected $term_type_value_id;

	/**
	 * @return int
	 */
	public function getTermTypeValueId()
	{
		return $this->term_type_value_id;
	}

	/**
	 * @param int $term_type_value_id
	 */
	public function setTermTypeValueId($term_type_value_id)
	{
		$this->term_type_value_id = (int) $term_type_value_id;
	}

}