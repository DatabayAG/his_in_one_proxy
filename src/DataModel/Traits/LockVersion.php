<?php

namespace HisInOneProxy\DataModel\Traits;
/**
 * Trait LockVersion
 * @package HisInOneProxy\DataModel\Traits
 */
trait LockVersion
{
	/**
	 * @var int
	 */
	protected $lock_version;

	/**
	 * @return int
	 */
	public function getLockVersion()
	{
		return $this->lock_version;
	}

	/**
	 * @param int $lock_version
	 */
	public function setLockVersion($lock_version)
	{
		$this->lock_version = $lock_version;
	}
}
