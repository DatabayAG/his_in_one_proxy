<?php

namespace HisInOneProxy\DataModel;

use HisInOneProxy\DataModel\Traits;

class CourseCatalogLeaf
{

	use Traits\Title, Traits\Valid;

	/**
	 * @var int
	 */
	protected $id;

	/**
	 * @var string
	 */
	protected $commentary;

	/**
	 * @var boolean
	 */
	protected $print_out;

	/**
	 * @var int
	 */
	protected $state_id;

	/**
	 * @var array
	 */
	protected $assigned_org_units = array();

	/**
	 * @var array
	 */
	protected $children = array();

	/**
	 * @var array
	 */
	protected $units = array();
	
	/**
	 * @return int
	 */
	public function getId()
	{
		return $this->id;
	}

	/**
	 * @param int $id
	 */
	public function setId($id)
	{
		$this->id = $id;
	}

	/**
	 * @return string
	 */
	public function getCommentary()
	{
		return $this->commentary;
	}

	/**
	 * @param string $commentary
	 */
	public function setCommentary($commentary)
	{
		$this->commentary = $commentary;
	}

	/**
	 * @return boolean
	 */
	public function getPrintOut()
	{
		return $this->print_out;
	}

	/**
	 * @param boolean $print_out
	 */
	public function setPrintOut($print_out)
	{
		$this->print_out = $print_out;
	}

	/**
	 * @return int
	 */
	public function getStateId()
	{
		return $this->state_id;
	}

	/**
	 * @param int $state_id
	 */
	public function setStateId($state_id)
	{
		$this->state_id = $state_id;
	}

	/**
	 * @return array
	 */
	public function getAssignedOrgUnits()
	{
		return $this->assigned_org_units;
	}

	/**
	 * @param array|int $org_unit
	 */
	public function setAssignedOrgUnits($org_unit)
	{
		if(is_array($org_unit))
		{
			$this->assigned_org_units = $org_unit;
		}
		else
		{
			$this->assigned_org_units[] = $org_unit;
		}
	}

	/**
	 * @return CourseCatalogChild[]
	 */
	public function getChildren()
	{
		return $this->children;
	}

	/**
	 * @param CourseCatalogChild $child
	 */
	public function appendChild($child)
	{
		$this->children[trim($child->getCourseCatalogId())] = $child;
	}

	/**
	 * @return array
	 */
	public function getUnits()
	{
		return $this->units;
	}

	/**
	 * @param Unit $units
	 */
	public function setUnits($units)
	{
		$this->units = $units;
	}

	/**
	 * @param $id
	 * @param $leaf
	 */
	public function replaceChildWithObject($id, $leaf)
	{
		if($leaf != null)
		{
			$this->children[$id] = $leaf;
		}
	}
}