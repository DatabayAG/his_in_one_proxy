<?php

namespace HisInOneProxy\Parser;

use HisInOneProxy\DataModel;

/**
 * Class ParsePurposeList
 * @package HisInOneProxy\Parser
 */
class ParsePurposeList extends SimpleXmlParser
{
	/**
	 * @param $xml
	 * @return DataModel\Purpose[]
	 */
	public function parse($xml)
	{
		$container = array();
		if($this->doesAttributeExist($xml, 'listOfPurposes'))
		{
			$xml = $xml->listOfPurposes;
			if($this->doesMoreThanOneElementExists($xml, 'purposevalue'))
			{
				foreach($xml->purposevalue as $purpose)
				{
					$obj = $this->buildObject($purpose);
					$container[trim($obj->getId())] = $obj;
				}
			}
			else if($this->doesExactlyOneElementExists($xml, 'purposevalue'))
			{
				$obj = $this->buildObject($xml->purposevalue);
				$container[trim($obj->getId())] = $obj;
			}
		}
		return $container;
	}

	/**
	 * @param $xml
	 * @return DataModel\Purpose
	 */
	protected function buildObject($xml)
	{
		$purpose = new DataModel\Purpose();
		if($this->isAttributeValid($xml, 'id'))
		{
			$purpose->setId($xml->id);
		}
		if($this->isAttributeValid($xml, 'uniquename'))
		{
			$purpose->setUniqueName($xml->uniquename);
		}
		if($this->isAttributeValid($xml, 'shorttext'))
		{
			$purpose->setShortText($xml->shorttext);
		}
		if($this->isAttributeValid($xml, 'defaulttext'))
		{
			$purpose->setDefaultText($xml->defaulttext);
		}
		if($this->isAttributeValid($xml, 'longtext'))
		{
			$purpose->setLongText($xml->longtext);
		}
		if($this->isAttributeValid($xml, 'sortorder'))
		{
			$purpose->setSortOrder($xml->sortorder);
		}
		if($this->isAttributeValid($xml, 'defaultlanguage'))
		{
			$purpose->setDefaultLanguage($xml->defaultlanguage);
		}
		if($this->isAttributeValid($xml, 'objGuid'))
		{
			$purpose->setObjGuid($xml->objGuid);
		}
		if($this->isAttributeValid($xml, 'objecttype'))
		{
			$purpose->setObjectType($xml->objecttype);
		}
		if($this->isAttributeValid($xml, 'hiskeyId'))
		{
			$purpose->setHisKeyId($xml->hiskeyId);
		}

		return $purpose;
	}
}
