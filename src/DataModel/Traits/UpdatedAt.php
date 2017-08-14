<?php

namespace HisInOneProxy\DataModel\Traits;
/**
 * Trait UpdatedAt
 * @package HisInOneProxy\DataModel\Traits
 */
trait UpdatedAt
{

	/**
	 * @var
	 */
	protected $updated_at;

	/**
	 * @return mixed
	 */
	public function getUpdatedAt()
	{
		return $this->updated_at;
	}

	/**
	 * @param mixed $updated_at
	 */
	public function setUpdatedAt($updated_at)
	{
		$this->updated_at = $updated_at;
	}
}