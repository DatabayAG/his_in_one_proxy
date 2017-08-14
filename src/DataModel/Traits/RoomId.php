<?php

namespace HisInOneProxy\DataModel\Traits;
/**
 * Trait RoomId
 * @package HisInOneProxy\DataModel\Traits
 */
trait RoomId
{

	/**
	 * @var int
	 */
	protected $room_id;

	/**
	 * @return int
	 */
	public function getRoomId()
	{
		return $this->room_id;
	}

	/**
	 * @param int $room_id
	 */
	public function setRoomId($room_id)
	{
		$this->room_id = $room_id;
	}
}