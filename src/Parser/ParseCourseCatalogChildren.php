<?php

namespace HisInOneProxy\Parser;

use HisInOneProxy\DataModel;

/**
 * Class ParseCourseCatalogChildren
 * @package HisInOneProxy\Parser
 */
class ParseCourseCatalogChildren extends SimpleXmlParser
{

	protected $valid_types = array('coursecatalog', 'planelement', 'unit');

	/**
	 * @param                             $xml
	 * @param DataModel\CourseCatalogLeaf $course_catalog_element
	 * @return DataModel\CourseCatalogLeaf
	 */
	public function parse($xml, $course_catalog_element)
	{
		if($this->doesMoreThanOneElementExists($xml, 'courseCatalogChildren'))
		{
			foreach($xml->courseCatalogChildren as $value)
			{
				if($this->isAttributeValid($value, 'courseCatalogElementId'))
				{
					$this->buildObjectFromData($value, $course_catalog_element);
				}
				else
				{
					$this->log->warning('No id given for CourseCatalogChildren, skipping!');
				}
			}
		}
		elseif($this->doesExactlyOneElementExists($xml, 'courseCatalogChildren'))
		{
			$this->buildObjectFromData($xml->courseCatalogChildren, $course_catalog_element);
		}
		else
		{
			$this->log->warning('No children given for CourseCatalogChildren, skipping!');
		}
		return $course_catalog_element;
	}

	/**
	 * @param                             $value
	 * @param DataModel\CourseCatalogLeaf $course_catalog_element
	 */
	protected function buildObjectFromData($value, $course_catalog_element)
	{
		if(isset($value->courseCatalogElementId) && $value->courseCatalogElementId != '')
		{
			$child = new DataModel\CourseCatalogChild();
			$child->setCourseCatalogId($value->courseCatalogElementId);
			$this->log->info(sprintf('Found CourseCatalogChild with id %s.', $child->getCourseCatalogId()));

			if(isset($value->sortorder))
			{
				$child->setSortOrder($value->sortorder);
			}
			if(isset($value->type))
			{
				if(in_array(strtolower($value->type), $this->valid_types))
				{
					$child->setType($value->type);
					$course_catalog_element->appendChild($child);
				}
				else
				{
					$this->log->warning(sprintf('Type: %s is not valid, skipping!', $value->type));
				}
			}
		}
	}
}