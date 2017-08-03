<?php

namespace HisInOneProxy\DataModel;

use HisInOneProxy\DataModel\Traits;

class CourseCatalogChild
{
	use Traits\SortingOrder;

	/**
	 * @var int
	 */
	protected $courseCatalogId;

	/**
	 * @var string
	 */
	protected $type;

	/**
 	* @return string
 	*/
	public function getCourseCatalogId()
	{
		return $this->courseCatalogId;
	}

	/**
	 * @param string $courseCatalogId
	 */
	public function setCourseCatalogId($courseCatalogId)
	{
		$this->courseCatalogId = $courseCatalogId;
	}

	/**
	 * @return string
	 */
	public function getType()
	{
		return $this->type;
	}

	/**
	 * @param string $type
	 */
	public function setType($type)
	{
		$this->type = $type;
	}
}