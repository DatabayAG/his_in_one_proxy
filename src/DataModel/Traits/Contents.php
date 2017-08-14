<?php

namespace HisInOneProxy\DataModel\Traits;
/**
 * Trait Contents
 * @package HisInOneProxy\DataModel\Traits
 */
trait Contents
{

	/**
	 * @var string
	 */
	protected $contents;

	/**
	 * @return string
	 */
	public function getContents()
	{
		return $this->contents;
	}

	/**
	 * @param string $contents
	 */
	public function setContents($contents)
	{
		$this->contents = $contents;
	}

}