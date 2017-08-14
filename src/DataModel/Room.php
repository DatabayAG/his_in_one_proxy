<?php

namespace HisInOneProxy\DataModel;

use HisInOneProxy\DataModel\Traits;

/**
 * Class Room
 * @package HisInOneProxy\DataModel
 */
class Room
{
	use Traits\ObjGuid, Traits\UniqueNameAndText;

	/**
	 * @var int
	 */
	protected $default_language_id;

	/**
	 * @var string
	 */
	protected $description;

	/**
	 * @var int
	 */
	protected $part_of_room_composition;

	/**
	 * @var string
	 */
	protected $class_room_name;

	/**
	 * @var int
	 */
	protected $floor_id;

	/**
	 * @var int
	 */
	protected $din_277_room_use_id;

	/**
	 * @var int
	 */
	protected $area;

	/**
	 * @var int
	 */
	protected $room_segment_count;

	/**
	 * @return int
	 */
	public function getDefaultLanguageId()
	{
		return $this->default_language_id;
	}

	/**
	 * @param int $default_language_id
	 */
	public function setDefaultLanguageId($default_language_id)
	{
		$this->default_language_id = $default_language_id;
	}

	/**
	 * @return string
	 */
	public function getDescription()
	{
		return $this->description;
	}

	/**
	 * @param string $description
	 */
	public function setDescription($description)
	{
		$this->description = $description;
	}

	/**
	 * @return int
	 */
	public function getPartOfRoomComposition()
	{
		return $this->part_of_room_composition;
	}

	/**
	 * @param int $part_of_room_composition
	 */
	public function setPartOfRoomComposition($part_of_room_composition)
	{
		$this->part_of_room_composition = $part_of_room_composition;
	}

	/**
	 * @return string
	 */
	public function getClassRoomName()
	{
		return $this->class_room_name;
	}

	/**
	 * @param string $class_room_name
	 */
	public function setClassRoomName($class_room_name)
	{
		$this->class_room_name = $class_room_name;
	}

	/**
	 * @return int
	 */
	public function getFloorId()
	{
		return $this->floor_id;
	}

	/**
	 * @param int $floor_id
	 */
	public function setFloorId($floor_id)
	{
		$this->floor_id = $floor_id;
	}

	/**
	 * @return int
	 */
	public function getDin277RoomUseId()
	{
		return $this->din_277_room_use_id;
	}

	/**
	 * @param int $din_277_room_use_id
	 */
	public function setDin277RoomUseId($din_277_room_use_id)
	{
		$this->din_277_room_use_id = $din_277_room_use_id;
	}

	/**
	 * @return int
	 */
	public function getArea()
	{
		return $this->area;
	}

	/**
	 * @param int $area
	 */
	public function setArea($area)
	{
		$this->area = $area;
	}

	/**
	 * @return int
	 */
	public function getRoomSegmentCount()
	{
		return $this->room_segment_count;
	}

	/**
	 * @param int $room_segment_count
	 */
	public function setRoomSegmentCount($room_segment_count)
	{
		$this->room_segment_count = $room_segment_count;
	}
}
