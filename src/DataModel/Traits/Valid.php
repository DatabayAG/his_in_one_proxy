<?php

namespace HisInOneProxy\DataModel\Traits;

trait Valid
{

	/**
	 * @var string
	 */
	protected $valid_from;

	/**
	 * @var string
	 */
	protected $valid_to;

	/**
	 * @return string
	 */
	public function getValidFrom()
	{
		return $this->valid_from;
	}

	/**
	 * @param string $valid_from
	 */
	public function setValidFrom($valid_from)
	{
		$this->valid_from = $valid_from;
	}

	/**
	 * @return string
	 */
	public function getValidTo()
	{
		return $this->valid_to;
	}

	/**
	 * @param string $valid_to
	 */
	public function setValidTo($valid_to)
	{
		$this->valid_to = $valid_to;
	}
}
