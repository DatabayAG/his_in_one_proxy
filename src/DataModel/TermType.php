<?php

namespace HisInOneProxy\DataModel;

use HisInOneProxy\DataModel\Traits;

class TermType
{

	use Traits\LanguageId, Traits\SortingOrder, Traits\ObjGuid, Traits\TermNumber, Traits\UniqueNameAndText;

	/**
	 * @var int
	 */
	protected $term_category;

	/**
	 * @return int
	 */
	public function getTermCategory()
	{
		return $this->term_category;
	}

	/**
	 * @param int $term_category
	 */
	public function setTermCategory($term_category)
	{
		$this->term_category = $term_category;
	}
}