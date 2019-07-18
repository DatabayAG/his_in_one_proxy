<?php

namespace HisInOneProxy\DataModel;

use HisInOneProxy\DataModel\Traits;

/**
 * Class OrgUnit
 * @package HisInOneProxy\DataModel
 */
class OrgUnit
{
    use Traits\Id, Traits\LanguageId, Traits\Lid, Traits\ParentId, Traits\SortingOrder, Traits\Valid, Traits\UniqueNameAndText;

    /**
     * @var string
     */
    protected $astat;

    /**
     * @var int
     */
    protected $parent_long_id;

    /**
     * @var int
     */
    protected $type_id;

    /**
     * @var string
     */
    protected $short_cut;

    /**
     * @var OrgUnit[]
     */
    protected $container = array();

    /**
     * @var int
     */
    protected $child_count;

    /**
     * @var Address[]
     */
    protected $address_container = array();

    /**
     * @return OrgUnit[]
     */
    public function getContainer()
    {
        return $this->container;
    }

    /**
     * @param OrgUnit $org_unit
     */
    public function appendOrgUnit($org_unit)
    {
        if ($org_unit != null && $org_unit->getId() != '' && $org_unit->getId() != 0) {
            $this->container[] = $org_unit;
        }
    }

    /**
     * @return Address[]
     */
    public function getAddressContainer()
    {
        return $this->address_container;
    }

    /**
     * @param Address $address
     */
    public function appendAddress($address)
    {
        $this->address_container[] = $address;
    }

    /**
     * @param OrgUnit $org_unit
     */
    public function replaceContainerObjectWithNewChildren($org_unit)
    {
        if ($org_unit->container != null && $org_unit->container != '' && count($org_unit->container) > 0) {
            $this->container = $org_unit->container;
        }
    }

    /**
     * @return string
     */
    public function getAstat()
    {
        return $this->astat;
    }

    /**
     * @param string $astat
     */
    public function setAstat($astat)
    {
        $this->astat = $astat;
    }

    /**
     * @return int
     */
    public function getParentLongId()
    {
        return $this->parent_long_id;
    }

    /**
     * @param int $parent_long_id
     */
    public function setParentLongId($parent_long_id)
    {
        $this->parent_long_id = $parent_long_id;
    }

    /**
     * @return int
     */
    public function getTypeId()
    {
        return $this->type_id;
    }

    /**
     * @param int $type_id
     */
    public function setTypeId($type_id)
    {
        $this->type_id = $type_id;
    }

    /**
     * @return string
     */
    public function getShortCut()
    {
        return $this->short_cut;
    }

    /**
     * @param string $short_cut
     */
    public function setShortCut($short_cut)
    {
        $this->short_cut = $short_cut;
    }

    /**
     * @return int
     */
    public function getChildCount()
    {
        return $this->child_count;
    }

    /**
     * @param int $child_count
     */
    public function setChildCount($child_count)
    {
        $this->child_count = $child_count;
    }
}
