<?php

namespace HisInOneProxy\DataModel\Container;

use HisInOneProxy\DataModel\TermType;

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
		$this->term_type_container[] = $term_type;
	}

	public function getSizeOfContainer()
	{
		return count($this->term_type_container);
	}
}