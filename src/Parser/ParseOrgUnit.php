<?php

namespace HisInOneProxy\Parser;

use HisInOneProxy\DataModel;

class ParseOrgUnit extends SimpleXmlParser
{

	/**
	 * @param $xml
	 * @param DataModel\Unit $unit
	 */
	public function parseUnit($xml, $unit)
	{
		if($this->doesAttributeExist($xml, 'unitOrgunits'))
		{
			$xml = $xml->unitOrgunits;
			if($this->doesMoreThanOneElementExists($xml, 'unitOrgunit'))
			{
				foreach($xml->unitOrgunit as $value)
				{
					$unit->appendOrgUnit($this->buildOrgUnit($value));
				}
			}
			else if($this->doesExactlyOneElementExists($xml, 'unitOrgunit'))
			{
				$unit->appendOrgUnit($this->buildOrgUnit($xml->unitOrgunit));
			}
		}

	}

	/**
	 * @param $xml
	 * @return DataModel\OrgUnit
	 */
	public function parse($xml)
	{
		if($this->doesMoreThanOneElementExists($xml, 'unitOrgunit'))
		{
			foreach($xml->unitOrgunit as $value)
			{
				return $this->buildOrgUnit($value);
			}
		}
		else
		{
			return $this->buildOrgUnit($xml);
		}
	}
	
	/**
	 * @param $xml
	 * @return DataModel\OrgUnit
	 */
	public function buildOrgUnit($xml)
	{
		$org_unit = new DataModel\OrgUnit();

		if(isset($xml->id) && $xml->id != null && $xml->id != '')
		{
			$org_unit->setId($xml->id);
			$this->log->info(sprintf('Found OrgUnit with id %s.', $org_unit->getId()));

			if($this->isAttributeValid($xml, 'lid') || $this->isAttributeValid($xml, 'orgunitLid'))
			{
				if($this->isAttributeValid($xml, 'lid'))
				{
					$org_unit->setLid($xml->lid);
				}
				else
				{
					$org_unit->setLid($xml->orgunitLid);
				}
			}
			if($this->isAttributeValid($xml, 'shortcut'))
			{
				$org_unit->setShortCut($xml->shortcut);
			}
			if($this->isAttributeValid($xml, 'shorttext'))
			{
				$org_unit->setShortText($xml->shorttext);
			}
			if($this->isAttributeValid($xml, 'displaytext'))
			{
				$org_unit->setDefaultText($xml->displaytext);
			}
			if($this->isAttributeValid($xml, 'longtext'))
			{
				$org_unit->setLongText($xml->longtext);
			}
			if($this->isAttributeValid($xml, 'elementtypeId'))
			{
				$org_unit->setTypeId($xml->elementtypeId);
			}
			if($this->isAttributeValid($xml, 'children'))
			{
				$this->parseOrgUnitChildren($xml->children, $org_unit);
			}
			if($this->isAttributeValid($xml, 'validFrom'))
			{
				$org_unit->setValidFrom($xml->validFrom);
			}
			if($this->isAttributeValid($xml, 'validTo'))
			{
				$org_unit->setValidTo($xml->validTo);
			}
			if($this->isAttributeValid($xml, 'languageId'))
			{
				$org_unit->setLanguageId($xml->languageId);
			}
			if($this->isAttributeValid($xml, 'parentId'))
			{
				$org_unit->setParentId($xml->parentId);
			}
			if($this->isAttributeValid($xml, 'parentLongId'))
			{
				$org_unit->setParentLongId($xml->parentLongId);
			}
			if($this->isAttributeValid($xml, 'type'))
			{
				$org_unit->setTypeId($xml->type);
			}
		}
		else
		{
			$this->log->warning('No id given for OrgUnit, skipping!');
		}

		return $org_unit;
	}

	/**
	 * @param                   $xml
	 * @param DataModel\OrgUnit $org_unit
	 */
	protected function parseOrgUnitChildren($xml, $org_unit)
	{
		if($this->isAttributeValid($xml, 'orgunit'))
		{
			if(is_array($xml->orgunit))
			{
				foreach($xml->orgunit as $unit)
				{
					$org_unit->appendOrgUnit($this->parse($unit));
				}
			}
			else
			{
				$org_unit->appendOrgUnit($this->parse($xml->orgunit));
			}
		}

	}
}
