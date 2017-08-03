<?php

namespace HisInOneProxy\DataModel\Traits;

trait DefaultLanguage
{

	/**
	 * @var int
	 */
	protected $default_language;

	/**
	 * @return int
	 */
	public function getDefaultLanguage()
	{
		return $this->default_language;
	}

	/**
	 * @param int $default_language
	 */
	public function setDefaultLanguage($default_language)
	{
		$this->default_language = $default_language;
	}
}