<?php

namespace HisInOneProxy\DataModel;

use HisInOneProxy\DataModel\Traits;

class ElearningPlatform
{
	use Traits\HisKeyId, Traits\LanguageId, Traits\ObjGuid, Traits\SortingOrder, Traits\Text, Traits\UniqueName;

	/**
	 * @var string
	 */
	protected $connection_info;

	/**
	 * @return string
	 */
	public function getConnectionInfo()
	{
		return $this->connection_info;
	}

	/**
	 * @param string $connection_info
	 */
	public function setConnectionInfo($connection_info)
	{
		$this->connection_info = $connection_info;
	}
}