<?php

namespace HisInOneProxy\Parser;

use HisInOneProxy\DataModel;

/**
 * Class ParseRoom
 * @package HisInOneProxy\Parser
 */
class ParseRoom extends SimpleXmlParser
{
	/**
	 * @param $xml
	 * @return DataModel\Room
	 */
	public function parse($xml)
	{
		$room = new DataModel\Room();
		if($this->isAttributeValid($xml, 'id'))
		{
			$room->setId($xml->id);
			$this->log->info(sprintf('Found Room with id %s.', $room->getId()));
			if($this->isAttributeValid($xml, 'objGuid'))
			{
				$room->setObjGuid($xml->objGuid);
			}
			if($this->isAttributeValid($xml, 'shorttext'))
			{
				$room->setShortText($xml->shorttext);
			}
			if($this->isAttributeValid($xml, 'defaulttext'))
			{
				$room->setDefaultText($xml->defaulttext);
			}
			if($this->isAttributeValid($xml, 'longtext'))
			{
				$room->setLongText($xml->longtext);
			}
			if($this->isAttributeValid($xml, 'defaultlanguageId'))
			{
				$room->setDefaultLanguageId($xml->defaultlanguageId);
			}
			if($this->isAttributeValid($xml, 'uniquename'))
			{
				$room->setUniqueName($xml->uniquename);
			}
			if($this->isAttributeValid($xml, 'description'))
			{
				$room->setDescription($xml->description);
			}
			if($this->isAttributeValid($xml, 'partOfRoomComposition'))
			{
				$room->setPartOfRoomComposition($xml->partOfRoomComposition);
			}
			if($this->isAttributeValid($xml, 'classRoomName'))
			{
				$room->setClassRoomName($xml->classRoomName);
			}
			if($this->isAttributeValid($xml, 'floorId'))
			{
				$room->setFloorId($xml->floorId);
			}
			if($this->isAttributeValid($xml, 'din277RoomuseId'))
			{
				$room->setDin277RoomUseId($xml->din277RoomuseId);
			}
			if($this->isAttributeValid($xml, 'area'))
			{
				$room->setArea($xml->area);
			}
			if($this->isAttributeValid($xml, 'roomSegmentCount'))
			{
				$room->setRoomSegmentCount($xml->roomSegmentCount);
			}
		}
		else
		{
			$this->log->warning('No id given for Room, skipping!');
		}
		return $room;
	}
}