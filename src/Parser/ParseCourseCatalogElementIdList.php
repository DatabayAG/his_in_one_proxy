<?php

namespace HisInOneProxy\Parser;

use HisInOneProxy\DataModel\Container\CourseCatalogElementIdList;

/**
 * Class ParseCourseCatalogElementIdList
 * @package HisInOneProxy\Parser
 */
class ParseCourseCatalogElementIdList extends SimpleXmlParser
{
	/**
	 * @param $xml
	 * @return CourseCatalogElementIdList
	 */
	public function parse($xml)
	{
		$course_catalog_element_id_list = new CourseCatalogElementIdList();
		if($this->isAttributeValid($xml, 'courseCatalogElementId'))
		{
			foreach($xml->courseCatalogElementId as $value)
			{
				if(isset($value) && $value != null && $value != '')
				{
					$course_catalog_element_id_list->appendCourseCatalogElementId($value);
					$this->log->info(sprintf('Found course catalog element id %s.', $value));
				}
				else
				{
					$this->log->warning('No id given for course catalog element, skipping!');
				}
			}
		}

		return $course_catalog_element_id_list;
	}
}