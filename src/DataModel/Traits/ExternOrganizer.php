<?php

namespace HisInOneProxy\DataModel\Traits;

trait ExternOrganizer
{
	/**
	 * @var string
	 */
	protected $extern_organizer;

	/**
	 * @return string
	 */
	public function getExternOrganizer()
	{
		return $this->extern_organizer;
	}

	/**
	 * @param string $extern_organizer
	 */
	public function setExternOrganizer($extern_organizer)
	{
		$this->extern_organizer = $extern_organizer;
	}
}