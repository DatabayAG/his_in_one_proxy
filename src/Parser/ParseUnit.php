<?php

namespace HisInOneProxy\Parser;

use HisInOneProxy\DataModel;
use HisInOneProxy\Soap\Interactions\DataCache;

/**
 * Class ParseUnit
 * @package HisInOneProxy\Parser
 */
class ParseUnit extends SimpleXmlParser
{
	/**
	 * @param $xml
	 * @return DataModel\Unit
	 * @throws \Exception
	 */
	public function parse($xml)
	{
		$unit = new DataModel\Unit();

		if($this->isAttributeValid($xml, 'id'))
		{
			$unit->setId($xml->id);
			$this->log->info(sprintf('Found Unit with id %s.', $unit->getId()));
			if($this->isAttributeValid($xml, 'objGuid'))
			{
				$unit->setObjGuid($xml->objGuid);
			}
			if($this->isAttributeValid($xml, 'lockVersion'))
			{
				$unit->setLockVersion($xml->lockVersion);
			}
			if($this->isAttributeValid($xml, 'comment'))
			{
				$unit->setComment($xml->comment);
			}
			if($this->isAttributeValid($xml, 'defaultlanguage'))
			{
				$unit->setDefaultLanguage($xml->defaultlanguage);
			}
			if($this->isAttributeValid($xml, 'defaulttext'))
			{
				$unit->setDefaultText($xml->defaulttext);
			}
			if($this->isAttributeValid($xml, 'elementnr'))
			{
				$unit->setElementNr($xml->elementnr);
			}
			if($this->isAttributeValid($xml, 'elementtypeId'))
			{
				$unit->setElementTypeId($xml->elementtypeId);
			}
			if($this->isAttributeValid($xml, 'lid'))
			{
				$unit->setLid($xml->lid);
			}
			if($this->isAttributeValid($xml, 'longtext'))
			{
				$unit->setLongText($xml->longtext);
			}
			if($this->isAttributeValid($xml, 'shortcomment'))
			{
				$unit->setShortComment($xml->shortcomment);
			}
			if($this->isAttributeValid($xml, 'shorttext'))
			{
				$unit->setShortText($xml->shorttext);
			}
			if($this->isAttributeValid($xml, 'statusId'))
			{
				$unit->setStatusId($xml->statusId);
			}
			if($this->isAttributeValid($xml, 'validFrom'))
			{
				$unit->setValidFrom($xml->validFrom);
			}
			if($this->isAttributeValid($xml, 'validTo'))
			{
				$unit->setValidTo($xml->validTo);
			}
			if($this->isAttributeValid($xml, 'versionComment'))
			{
				$unit->setVersionComment($xml->versionComment);
			}
			if($this->isAttributeValid($xml, 'versionTag'))
			{
				$unit->setVersionTag($xml->versionTag);
			}
			if($this->isAttributeValid($xml, 'course'))
			{
				$parser = new ParseCourse($this->log);
				$unit->appendCourse($parser->parse($xml->course));
			}
			if($this->isAttributeValid($xml, 'unitOrgunits'))
			{
				$parser = new ParseOrgUnit($this->log);
				$parser->parseUnit($xml, $unit);
			}
			if($this->isAttributeValid($xml, 'children'))
			{
				$parser = new ParseChildRelation($this->log);
				$unit->setChildContainer($parser->parse($xml->children));
			}
			DataCache::getInstance()->appendUnitCache($unit);
		}
		else
		{
			$this->log->warning('No id given for Unit, skipping!');
		}

		return $unit;
	}
}
