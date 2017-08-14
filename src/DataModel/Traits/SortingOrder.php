<?php

namespace HisInOneProxy\DataModel\Traits;
/**
 * Trait SortingOrder
 * @package HisInOneProxy\DataModel\Traits
 */
trait SortingOrder
{

	/**
	 * @var int
	 */
	protected $sort_order;

	/**
	 * @return int
	 */
	public function getSortOrder()
	{
		return $this->sort_order;
	}

	/**
	 * @param int $sort_order
	 */
	public function setSortOrder($sort_order)
	{
		$this->sort_order = $sort_order;
	}
}
