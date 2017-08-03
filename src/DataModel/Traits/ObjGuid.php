<?php

namespace HisInOneProxy\DataModel\Traits;

trait ObjGuid
{
	/**
	 * @var int
	 */
	protected $id;

	/**
	 * @var string
	 */
	protected $obj_guid;

	/**
	 * @return int
	 */
	public function getId()
	{
		return $this->id;
	}

	/**
	 * @param int $id
	 */
	public function setId($id)
	{
		$this->id = $id;
	}

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
