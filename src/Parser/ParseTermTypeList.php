<?php

namespace HisInOneProxy\Parser;

/**
 * Class ParseTermTypeList
 * @package HisInOneProxy\Parser
 */
class ParseTermTypeList extends SimpleXmlParser
{
	/**
	 * @param $xml
	 * @return \HisInOneProxy\DataModel\Container\TermTypeList
	 */
	public function parse($xml)
	{
		$term_type_list = new \HisInOneProxy\DataModel\Container\TermTypeList();

		if($this->isAttributeValid($xml, 'values'))
		{
            $xml = $xml->values;
            if ($this->isAttributeValid($xml, 'value')) {
                foreach($xml->value as $value)
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
        }

		return $term_type_list;
	}
}
