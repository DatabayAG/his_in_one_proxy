<?php

namespace HisInOneProxy\DataModel\Traits;

trait Literature
{

	/**
	 * @var string
	 */
	protected $literature;

	/**
	 * @return string
	 */
	public function getLiterature()
	{
		return $this->literature;
	}

	/**
	 * @param string $literature
	 */
	public function setLiterature($literature)
	{
		$this->literature = $literature;
	}
}