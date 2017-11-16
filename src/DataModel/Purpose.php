<?php

namespace HisInOneProxy\DataModel;

use HisInOneProxy\DataModel\Traits;

class Purpose
{

	use Traits\DefaultObject;

	/**
	 * @var string
	 */
	protected $object_type;

	/**
	 * @return string
	 */
	public function getObjectType(): string
	{
		return $this->object_type;
	}

	/**
	 * @param string $object_type
	 */
	public function setObjectType(string $object_type)
	{
		$this->object_type = $object_type;
	}
}