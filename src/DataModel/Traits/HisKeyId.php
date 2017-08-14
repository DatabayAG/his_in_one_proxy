<?php

namespace HisInOneProxy\DataModel\Traits;
/**
 * Trait HisKeyId
 * @package HisInOneProxy\DataModel\Traits
 */
trait HisKeyId
{

	/**
	 * @var int
	 */
	protected $his_key_id;

	/**
	 * @return int
	 */
	public function getHisKeyId()
	{
		return $this->his_key_id;
	}

	/**
	 * @param int $his_key_id
	 */
	public function setHisKeyId($his_key_id)
	{
		$this->his_key_id = $his_key_id;
	}
}