<?php

namespace HisInOneProxy\DataModel\Container;
/**
 * Class UnitIdList
 * @package HisInOneProxy\DataModel\Container
 */
class UnitIdList
{
	/**
	 * @var array
	 */
	protected $unit_id_container = array();

	/**
	 * @return array
	 */
	public function getUnitIdContainer()
	{
		return $this->unit_id_container;
	}

	/**
	 * @return \Generator
	 */
	public function getUnitId()
	{
		foreach($this->unit_id_container as $unit_id) 
		{
			yield $unit_id;
		}
	}

	/**
	 * @param int $unit_id
	 */
	public function appendUnitId($unit_id)
	{
		$unit_id = (int) $unit_id;
		if(!in_array($unit_id, $this->getUnitIdContainer()))
		{
			$this->unit_id_container[] = $unit_id;
		}
	}

	/**
	 * @return int
	 */
	public function getSizeOfContainer()
	{
		return count($this->unit_id_container);
	}
}