<?php

namespace HisInOneProxy\Parser;

use HisInOneProxy\DataModel\CurrentTerm;

class ParseCurrentTerm extends SimpleXmlParser
{
	/**
	 * @param $xml
	 * @return CurrentTerm
	 */
	public function parse($xml)
	{
		$current_term = new CurrentTerm();
		if($this->isAttributeValid($xml, 'year'))
		{
			$current_term->setYear($xml->year);
		}
		if($this->isAttributeValid($xml, 'longtext'))
		{
			$current_term->setLongText($xml->longtext);
		}
		if($this->isAttributeValid($xml, 'shorttext'))
		{
			$current_term->setShortText($xml->shorttext);
		}
		if($this->isAttributeValid($xml, 'defaulttext'))
		{
			$current_term->setDefaultText($xml->defaulttext);
		}
		if($this->isAttributeValid($xml, 'termType'))
		{
			$current_term->setTermNumber($xml->termType->termNumber);
		}

		return $current_term;
	}
}