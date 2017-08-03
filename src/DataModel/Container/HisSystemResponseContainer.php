<?php

namespace HisInOneProxy\DataModel\Container;

use HisInOneProxy\DataModel\HisSystemResponse;

class HisSystemResponseContainer
{
	/**
	 * @var array
	 */
	protected $system_response_container = array();

	/**
	 * @return array
	 */
	public function getSystemResponseContainer()
	{
		return $this->system_response_container;
	}

	/**
	 * @return \Generator
	 */
	public function getSystemResponse()
	{
		foreach($this->system_response_container as $system_response)
		{
			yield $system_response;
		}
	}

	/**
	 * @param HisSystemResponse $system_response
	 */
	public function appendSystemResponse($system_response)
	{
		$this->system_response_container[] = $system_response;
	}

	public function getSizeOfContainer()
	{
		return count($this->system_response_container);
	}
}