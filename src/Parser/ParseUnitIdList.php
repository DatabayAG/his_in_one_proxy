<?php

namespace HisInOneProxy\Parser;

use HisInOneProxy\DataModel\Container\UnitIdList;

class ParseUnitIdList extends SimpleXmlParser
{
	/**
	 * @param $xml
	 * @return UnitIdList
	 */
	public function parse($xml)
	{
		$unit_id_list = new UnitIdList();

		if($this->isAttributeValid($xml, 'unitIds'))
		{
			foreach($xml->unitIds as $value)
			{
				if(isset($value) && !is_array($value) && $value != null && $value != '')
				{
					$unit_id_list->appendUnitId($value);
					$this->log->info(sprintf('Found Unit Id %s.', $value));
				}
				else if(is_array($value) && count($value) > 0)
				{
					foreach($value as $unit_id)
					{
						$unit_id_list->appendUnitId($unit_id);
						$this->log->info(sprintf('Found Unit Id %s.', $unit_id));
					}
				}

				else
				{
					$this->log->warning('No id given for Unit, skipping!');
				}
			}
		}

		return $unit_id_list;
	}
}