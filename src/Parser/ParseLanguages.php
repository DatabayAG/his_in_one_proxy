<?php

namespace HisInOneProxy\Parser;

use HisInOneProxy\DataModel;

/**
 * Class ParseLanguages
 * @package HisInOneProxy\Parser
 */
class ParseLanguages extends SimpleXmlParser
{
	/**
	 * @param $xml
	 * @return DataModel\Language[]
	 */
	public function parse($xml)
	{
		$container = array();
		if($this->doesAttributeExist($xml, 'listOfLanguages'))
		{
			$xml = $xml->listOfLanguages;
			if($this->doesMoreThanOneElementExists($xml, 'languagevalue'))
			{
				foreach($xml->languagevalue as $language)
				{
					$obj = $this->buildObject($language);
					$container[trim($obj->getId())] = $obj;
				}
			}
			else if($this->doesExactlyOneElementExists($xml, 'languagevalue'))
			{
				$obj = $this->buildObject($xml->languagevalue);
				$container[trim($obj->getId())] = $obj;
			}
		}
		return $container;
	}

	/**
	 * @param $xml
	 * @return DataModel\Language
	 */
	protected function buildObject($xml)
	{
		$gender = new DataModel\Language();
		if($this->isAttributeValid($xml, 'id'))
		{
			$gender->setId($xml->id);
		}
		if($this->isAttributeValid($xml, 'uniquename'))
		{
			$gender->setUniqueName($xml->uniquename);
		}
		if($this->isAttributeValid($xml, 'shorttext'))
		{
			$gender->setShortText($xml->shorttext);
		}
		if($this->isAttributeValid($xml, 'defaulttext'))
		{
			$gender->setDefaultText($xml->defaulttext);
		}
		if($this->isAttributeValid($xml, 'longtext'))
		{
			$gender->setLongText($xml->longtext);
		}
		if($this->isAttributeValid($xml, 'sortorder'))
		{
			$gender->setSortOrder($xml->sortorder);
		}
		if($this->isAttributeValid($xml, 'defaultlanguage'))
		{
			$gender->setDefaultLanguage($xml->defaultlanguage);
		}
		if($this->isAttributeValid($xml, 'objGuid'))
		{
			$gender->setObjGuid($xml->objGuid);
		}
		if($this->isAttributeValid($xml, 'iso_639_1'))
		{
			$gender->setIso6391($xml->iso_639_1);
		}
		if($this->isAttributeValid($xml, 'iso_639_2'))
		{
			$gender->setIso6392($xml->iso_639_2);
		}

		return $gender;
	}
}
