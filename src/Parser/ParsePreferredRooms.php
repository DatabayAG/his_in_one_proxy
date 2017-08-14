<?php

namespace HisInOneProxy\Parser;

use HisInOneProxy\DataModel;

/**
 * Class ParsePreferredRooms
 * @package HisInOneProxy\Parser
 */
class ParsePreferredRooms extends SimpleXmlParser
{

	/**
	 * @param                                     $xml
	 * @param DataModel\PlanElementPreferencePart $plan_element_preference_part
	 */
	public function parse($xml, $plan_element_preference_part)
	{
		foreach($xml->room as $value)
		{
			$room = new DataModel\Room();

			if($this->isAttributeValid($value, 'id'))
			{
				$room->setId($value->id);
				$this->log->info(sprintf('Found Room with id %s.', $room->getId()));
				if($this->isAttributeValid($value, 'objGuid'))
				{
					$room->setObjGuid($value->objGuid);
				}
				if($this->isAttributeValid($value, 'shorttext'))
				{
					$room->setShortText($value->shorttext);
				}
				if($this->isAttributeValid($value, 'defaulttext'))
				{
					$room->setDefaultText($value->defaulttext);
				}
				if($this->isAttributeValid($value, 'longtext'))
				{
					$room->setLongText($value->longtext);
				}
				if($this->isAttributeValid($value, 'defaultlanguageId'))
				{
					$room->setDefaultLanguageId($value->defaultlanguageId);
				}
				if($this->isAttributeValid($value, 'uniquename'))
				{
					$room->setUniqueName($value->uniquename);
				}
				if($this->isAttributeValid($value, 'description'))
				{
					$room->setDescription($value->description);
				}
				if($this->isAttributeValid($value, 'partOfRoomComposition'))
				{
					$room->setPartOfRoomComposition($value->partOfRoomComposition);
				}
				if($this->isAttributeValid($value, 'classRoomName'))
				{
					$room->setClassRoomName($value->classRoomName);
				}
				if($this->isAttributeValid($value, 'floorId'))
				{
					$room->setFloorId($value->floorId);
				}
				if($this->isAttributeValid($value, 'din277RoomuseId'))
				{
					$room->setDin277RoomUseId($value->din277RoomuseId);
				}
				if($this->isAttributeValid($value, 'area'))
				{
					$room->setArea($value->area);
				}
				if($this->isAttributeValid($value, 'roomSegmentCount'))
				{
					$room->setRoomSegmentCount($value->roomSegmentCount);
				}

				$plan_element_preference_part->appendPreferredRooms($room);
			}
			else
			{
				$this->log->warning('No id given for Room, skipping!');
			}
		}
	}
}
