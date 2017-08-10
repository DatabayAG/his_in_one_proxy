<?php

namespace HisInOneProxy\DataModel\Traits;

trait ObjGuid
{
	use Id;

	/**
	 * @var string
	 */
	protected $obj_guid;

	/**
	 * @return string
	 */
	public function getObjGuid()
	{
		return $this->obj_guid;
	}

	/**
	 * @param string $obj_guid
	 */
	public function setObjGuid($obj_guid)
	{
		$this->obj_guid = $obj_guid;
	}
}
