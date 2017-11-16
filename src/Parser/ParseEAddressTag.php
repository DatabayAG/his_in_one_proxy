<?php

namespace HisInOneProxy\Parser;

use HisInOneProxy\DataModel;

/**
 * Class ParseEAddressTag
 * @package HisInOneProxy\Parser
 */
class ParseEAddressTag extends SimpleXmlParser
{
	/**
	 * @param $xml
	 * @return DataModel\EAddressTag[]
	 */
	public function parse($xml)
	{
		$container = array();
		if($this->doesAttributeExist($xml, 'listOfEAddresstags'))
		{
			$xml = $xml->listOfEAddresstags;
			if($this->doesMoreThanOneElementExists($xml, 'eaddresstagvalue'))
			{
				foreach($xml->eaddresstagvalue as $address)
				{
					$obj = $this->buildObject($address);
					$container[trim($obj->getId())] = $obj;
				}
			}
			else if($this->doesExactlyOneElementExists($xml, 'eaddresstagvalue'))
			{
				$obj = $this->buildObject($xml->eaddresstagvalue);
				$container[trim($obj->getId())] = $obj;
			}
		}
		return $container;
	}

	/**
	 * @param $xml
	 * @return DataModel\EAddressTag
	 */
	protected function buildObject($xml)
	{
		$e_address_tag = new DataModel\EAddressTag();
		if($this->isAttributeValid($xml, 'id'))
		{
			$e_address_tag->setId($xml->id);
		}
		if($this->isAttributeValid($xml, 'uniquename'))
		{
			$e_address_tag->setUniqueName($xml->uniquename);
		}
		if($this->isAttributeValid($xml, 'shorttext'))
		{
			$e_address_tag->setShortText($xml->shorttext);
		}
		if($this->isAttributeValid($xml, 'defaulttext'))
		{
			$e_address_tag->setDefaultText($xml->defaulttext);
		}
		if($this->isAttributeValid($xml, 'longtext'))
		{
			$e_address_tag->setLongText($xml->longtext);
		}
		if($this->isAttributeValid($xml, 'sortorder'))
		{
			$e_address_tag->setSortOrder($xml->sortorder);
		}
		if($this->isAttributeValid($xml, 'defaultlanguage'))
		{
			$e_address_tag->setDefaultLanguage($xml->defaultlanguage);
		}
		if($this->isAttributeValid($xml, 'objGuid'))
		{
			$e_address_tag->setObjGuid($xml->objGuid);
		}
		if($this->isAttributeValid($xml, 'hiskeyId'))
		{
			$e_address_tag->setHisKeyId($xml->hiskeyId);
		}

		return $e_address_tag;
	}
}
