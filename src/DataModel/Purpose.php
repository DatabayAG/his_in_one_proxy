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
	public function getObjectType()
	{
		return $this->object_type;
	}

	/**
	 * @param string $object_type
	 */
	public function setObjectType($object_type)
	{
		$this->object_type = $object_type;
	}
}