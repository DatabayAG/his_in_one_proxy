<?php

namespace HisInOneProxy\Parser;

use HisInOneProxy\DataModel;

/**
 * Class ParseTermType
 * @package HisInOneProxy\Parser
 */
class ParseTermType extends SimpleXmlParser
{
	/**
	 * @param $xml
	 * @return DataModel\TermType
	 */
	public function parse($xml)
	{
		$term_type = new DataModel\TermType();

		if($this->isAttributeValid($xml, 'id'))
		{
			$term_type->setId($xml->id);
			$this->log->info(sprintf('Found TermType with id %s.', $term_type->getId()));
			if($this->isAttributeValid($xml, 'objGuid'))
			{
				$term_type->setObjGuid($xml->objGuid);
			}
			if($this->isAttributeValid($xml, 'defaulttext'))
			{
				$term_type->setDefaultText($xml->defaulttext);
			}
			if($this->isAttributeValid($xml, 'longtext'))
			{
				$term_type->setLongText($xml->longtext);
			}
			if($this->isAttributeValid($xml, 'shorttext'))
			{
				$term_type->setShortText($xml->shorttext);
			}
			if($this->isAttributeValid($xml, 'uniquename'))
			{
				$term_type->setUniqueName($xml->uniquename);
			}
			if($this->isAttributeValid($xml, 'sortorder'))
			{
				$term_type->setSortOrder($xml->sortorder);
			}
			if($this->isAttributeValid($xml, 'defaultlanguage'))
			{
				$term_type->setLanguageId($xml->defaultlanguage);
			}
			if($this->isAttributeValid($xml, 'termCategory'))
			{
				$term_type->setTermCategory($xml->termCategory);
			}
			if($this->isAttributeValid($xml, 'termNumber'))
			{
				$term_type->setTermNumber($xml->termNumber);
			}
		}
		else
		{
			$this->log->warning('No id given for TermType, skipping!');
		}

		return $term_type;
	}
}
