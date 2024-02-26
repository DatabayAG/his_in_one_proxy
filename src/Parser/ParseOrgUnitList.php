<?php

namespace HisInOneProxy\Parser;

use HisInOneProxy\DataModel;

/**
 * Class ParseOrgUnitList
 * @package HisInOneProxy\Parser
 */
class ParseOrgUnitList extends SimpleXmlParser
{

    /**
     * @var array
     */
    protected $list;

    /**
     * @param $xml
     * @return DataModel\OrgUnitListItem[]
     */
    public function parse($xml)
    {
        $this->list = array();
        if(array_key_exists('unitOrgunits',$xml) && array_key_exists('unitOrgunits', $xml->unitOrgunits))
        {
            $xml = $xml->unitOrgunits;
        }
        if ($this->doesMoreThanOneElementExists($xml, 'unitOrgunits')) {
            foreach ($xml->unitOrgunits as $value) {
                $this->appendOrgUnitToList($this->buildOrgUnit($value));
            }
        } else {
            $this->appendOrgUnitToList($this->buildOrgUnit($xml));
        }
        return $this->list;
    }

    /**
     * @param DataModel\OrgUnitListItem $org_unit
     */
    protected function appendOrgUnitToList($org_unit)
    {
        if ($org_unit->getOrgUnitLid() !== null) {
            $this->list[] = $org_unit;
        }
    }

    /**
     * @param $xml
     * @return DataModel\OrgUnitListItem
     */
    public function buildOrgUnit($xml)
    { 
        $org_unit = new DataModel\OrgUnitListItem();

        if (array_key_exists('unitOrgunits', $xml)) {
            $xml = $xml->unitOrgunits;
        }
        if (isset($xml->lid) && $xml->lid != null && $xml->lid != '') {
            $org_unit->setOrgUnitLid($xml->lid);
            $this->log->info(sprintf('Found OrgUnitListItem with id %s.', $org_unit->getOrgUnitLid()));
            if ($this->isAttributeValid($xml, 'unitId')) {
                $org_unit->setUnitId($xml->unitId);
            }
            if ($this->isAttributeValid($xml, 'unitOrgunitRelationTypeId')) {
                $org_unit->setUnitOrgUnitRelationTypeId($xml->unitOrgunitRelationTypeId);
            }
        } else {
            $this->log->warning('No id given for OrgUnit, skipping!');
        }

        return $org_unit;
    }
}
