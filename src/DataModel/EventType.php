<?php

namespace HisInOneProxy\DataModel;

use HisInOneProxy\DataModel\Traits;

class EventType
{

	use Traits\Text,  Traits\DefaultLanguage, Traits\HisKeyId, Traits\ObjGuid, Traits\SortingOrder, Traits\UniqueName;

	/**
	 * @var string
	 */
	protected $address_type;

	/**
	 * @return string
	 */
	public function getAddressType()
	{
		return $this->address_type;
	}

	/**
	 * @param string $address_type
	 */
	public function setAddressType($address_type)
	{
		$this->address_type = $address_type;
	}
}