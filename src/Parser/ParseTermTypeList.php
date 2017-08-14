<?php

namespace HisInOneProxy\Parser;

use HisInOneProxy\DataModel\Container\TermTypeList;

/**
 * Class ParseTermTypeList
 * @package HisInOneProxy\Parser
 */
class ParseTermTypeList extends SimpleXmlParser
{
	/**
	 * @param $xml
	 * @return TermTypeList
	 */
	public function parse($xml)
	{
		$term_type_list = new TermTypeList();

		if($this->isAttributeValid($xml, 'termtypevalue'))
		{
			foreach($xml->termtypevalue as $value)
			{
				if($this->isAttributeValid($value, 'id'))
				{
					$this->log->info(sprintf('Found TermType start parsing.'));
					$parser    = new ParseTermType($this->log);
					$term_type = $parser->parse($value);
					$term_type_list->appendTermType($term_type);
				}
				else
				{
					$this->log->warning('No TermType found, skipping!');
				}
			}
		}

		return $term_type_list;
	}
}