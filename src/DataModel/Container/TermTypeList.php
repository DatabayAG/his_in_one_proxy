<?php

namespace HisInOneProxy\DataModel\Container;

use HisInOneProxy\DataModel\TermType;

/**
 * Class TermTypeList
 * @package HisInOneProxy\DataModel\Container
 */
class TermTypeList
{
	/**
	 * @var array
	 */
	protected $term_type_container = array();

	/**
	 * @return array
	 */
	public function getTermTypeContainer()
	{
		return $this->term_type_container;
	}

	/**
	 * @return \Generator
	 */
	public function getTermType()
	{
		foreach($this->term_type_container as $term_type)
		{
			yield $term_type;
		}
	}

	/**
	 * @param TermType $term_type
	 */
	public function appendTermType($term_type)
	{
		$this->term_type_container[(string) $term_type->getId()] = $term_type;
	}

	/**
	 * @return int
	 */
	public function getSizeOfContainer()
	{
		return count($this->term_type_container);
	}
}