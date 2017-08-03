<?php

namespace HisInOneProxy\Parser;

use HisInOneProxy\DataModel;

class ParseCourseCatalogLeaf extends SimpleXmlParser
{

	/**
	 * @param $xml
	 * @return DataModel\CourseCatalogLeaf
	 */
	public function parse($xml)
	{
		$course_catalog_leaf = new DataModel\CourseCatalogLeaf();

		if($this->isAttributeValid($xml, 'elementId'))
		{
			$course_catalog_leaf->setId($xml->elementId);
			$this->log->info(sprintf('Found CourseCatalogLeaf with id %s.', $course_catalog_leaf->getId()));
			if($this->isAttributeValid($xml, 'title'))
			{
				$course_catalog_leaf->setTitle($xml->title);
			}
			if($this->isAttributeValid($xml, 'commentary'))
			{
				$course_catalog_leaf->setCommentary($xml->commentary);
			}
			if($this->isAttributeValid($xml, 'printout'))
			{
				$course_catalog_leaf->setPrintOut($xml->printout);
			}
			if($this->isAttributeValid($xml, 'stateId'))
			{
				$course_catalog_leaf->setStateId($xml->stateId);
			}
			if($this->isAttributeValid($xml, 'validFrom'))
			{
				$course_catalog_leaf->setValidFrom($xml->validFrom);
			}
			if($this->isAttributeValid($xml, 'validTo'))
			{
				$course_catalog_leaf->setValidTo($xml->validTo);
			}
			if($this->isAttributeValid($xml, 'assignedOrgunits'))
			{
				if(isset($xml->assignedOrgunits->assignedOrgunit))
				{
					$course_catalog_leaf->setAssignedOrgUnits($xml->assignedOrgunits->assignedOrgunit);
				}
			}
		}
		else
		{
			$this->log->warning('No id given for CourseCatalogLeaf, skipping!');
		}

		return $course_catalog_leaf;
	}
}