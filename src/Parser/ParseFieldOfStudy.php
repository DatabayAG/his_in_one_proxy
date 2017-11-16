<?php

namespace HisInOneProxy\Parser;

use HisInOneProxy\DataModel;

/**
 * Class ParseFieldOfStudy
 * @package HisInOneProxy\Parser
 */
class ParseFieldOfStudy extends SimpleXmlParser
{
	/**
	 * @param $xml
	 * @return DataModel\FieldOfStudy[]
	 */
	public function parse($xml)
	{
		$container = array();
		if($this->doesAttributeExist($xml, 'listOfFieldOfStudies'))
		{
			$xml = $xml->listOfFieldOfStudies;
			if($this->doesMoreThanOneElementExists($xml, 'fieldofstudyvalue'))
			{
				foreach($xml->fieldofstudyvalue as $field_of_studys)
				{
					$obj = $this->buildObject($field_of_studys);
					$container[trim($obj->getId())] = $obj;
				}
			}
			else if($this->doesExactlyOneElementExists($xml, 'fieldofstudyvalue'))
			{
				$obj = $this->buildObject($xml->fieldofstudyvalue);
				$container[trim($obj->getId())] = $obj;
			}
		}
		return $container;
	}

	/**
	 * @param $xml
	 * @return DataModel\FieldOfStudy
	 */
	protected function buildObject($xml)
	{
		$field_of_study = new DataModel\FieldOfStudy();
		if($this->isAttributeValid($xml, 'id'))
		{
			$field_of_study->setId($xml->id);
		}
		if($this->isAttributeValid($xml, 'uniquename'))
		{
			$field_of_study->setUniqueName($xml->uniquename);
		}
		if($this->isAttributeValid($xml, 'shorttext'))
		{
			$field_of_study->setShortText($xml->shorttext);
		}
		if($this->isAttributeValid($xml, 'defaulttext'))
		{
			$field_of_study->setDefaultText($xml->defaulttext);
		}
		if($this->isAttributeValid($xml, 'longtext'))
		{
			$field_of_study->setLongText($xml->longtext);
		}
		if($this->isAttributeValid($xml, 'sortorder'))
		{
			$field_of_study->setSortOrder($xml->sortorder);
		}
		if($this->isAttributeValid($xml, 'defaultlanguage'))
		{
			$field_of_study->setDefaultLanguage($xml->defaultlanguage);
		}
		if($this->isAttributeValid($xml, 'objGuid'))
		{
			$field_of_study->setObjGuid($xml->objGuid);
		}
		if($this->isAttributeValid($xml, 'hiskeyId'))
		{
			$field_of_study->setHisKeyId($xml->hiskeyId);
		}
		if($this->isAttributeValid($xml, 'astat'))
		{
			$field_of_study->setAstat($xml->astat);
		}
		if($this->isAttributeValid($xml, 'astatGuestAuditor'))
		{
			$field_of_study->setAStatGuestAuditor($xml->astatGuestAuditor);
		}

		return $field_of_study;
	}
}
