<?php

namespace HisInOneProxy\DataModel;

use HisInOneProxy\DataModel\Traits;

/**
 * Class VisibleChild
 * @package HisInOneProxy\DataModel
 */
class VisibleChild
{
	use Traits\UnitId, Traits\SortingOrder;

	/**
	 * @var int
	 */
	protected $parent_unit_id;

	/**
	 * @var int
	 */
	protected $relation_type_id;

	/**
	 * @var string
	 */
	protected $child_default_text;

	/**
	 * @var int
	 */
	protected $child_elements;

	/**
	 * @return int
	 */
	public function getParentUnitId()
	{
		return $this->parent_unit_id;
	}

	/**
	 * @param int $parent_unit_id
	 */
	public function setParentUnitId($parent_unit_id)
	{
		$this->parent_unit_id = $parent_unit_id;
	}

	/**
	 * @return int
	 */
	public function getRelationTypeId()
	{
		return $this->relation_type_id;
	}

	/**
	 * @param int $relationTypeId
	 */
	public function setRelationTypeId($relationTypeId)
	{
		$this->relation_type_id = $relationTypeId;
	}

	/**
	 * @return string
	 */
	public function getChildDefaultText()
	{
		return $this->child_default_text;
	}

	/**
	 * @param string $child_default_text
	 */
	public function setChildDefaultText($child_default_text)
	{
		$this->child_default_text = $child_default_text;
	}

	/**
	 * @return int
	 */
	public function getChildElements()
	{
		return $this->child_elements;
	}

	/**
	 * @param int $child_elements
	 */
	public function setChildElements($child_elements)
	{
		$this->child_elements = $child_elements;
	}

}