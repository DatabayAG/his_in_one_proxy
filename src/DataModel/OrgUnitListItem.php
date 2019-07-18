<?php

namespace HisInOneProxy\DataModel;

/**
 * Class OrgUnitListItem
 * @package HisInOneProxy\DataModel
 */
class OrgUnitListItem
{
    /**
     * @var int
     */
    protected $org_unit_lid;

    /**
     * @var int
     */
    protected $unit_id;

    /**
     * @var int
     */
    protected $unitOrgUnitRelationTypeId;

    /**
     * @return int
     */
    public function getOrgUnitLid()
    {
        return $this->org_unit_lid;
    }

    /**
     * @param int $org_unit_lid
     */
    public function setOrgUnitLid($org_unit_lid)
    {
        $this->org_unit_lid = $org_unit_lid;
    }

    /**
     * @return int
     */
    public function getLid()
    {
        return $this->org_unit_lid;
    }

    /**
     * @return int
     */
    public function getUnitId()
    {
        return $this->unit_id;
    }

    /**
     * @param int $unit_id
     */
    public function setUnitId($unit_id)
    {
        $this->unit_id = $unit_id;
    }

    /**
     * @return int
     */
    public function getUnitOrgUnitRelationTypeId()
    {
        return $this->unitOrgUnitRelationTypeId;
    }

    /**
     * @param int $unitOrgUnitRelationTypeId
     */
    public function setUnitOrgUnitRelationTypeId($unitOrgUnitRelationTypeId)
    {
        $this->unitOrgUnitRelationTypeId = $unitOrgUnitRelationTypeId;
    }
}
