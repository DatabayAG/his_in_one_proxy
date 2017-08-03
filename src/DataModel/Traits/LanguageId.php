<?php

namespace HisInOneProxy\DataModel\Traits;

trait LanguageId
{

	/**
	 * @var int
	 */
	protected $language_id;

	/**
	 * @return int
	 */
	public function getLanguageId()
	{
		return $this->language_id;
	}

	/**
	 * @param int $language_id
	 */
	public function setLanguageId($language_id)
	{
		$this->language_id = $language_id;
	}
}