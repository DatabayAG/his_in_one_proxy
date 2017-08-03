<?php

namespace HisInOneProxy\DataModel\Traits;

trait OrgUnitId
{

	/**
	 * @var int
	 */
	protected $org_unit_id;

	/**
	 * @var int
	 */
	protected $org_unit_lid;

	/**
	 * @return int
	 */
	public function getOrgUnitId()
	{
		return $this->org_unit_id;
	}

	/**
	 * @param int $org_unit_id
	 */
	public function setOrgUnitId($org_unit_id)
	{
		$this->org_unit_id = $org_unit_id;
	}

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

}