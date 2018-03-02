<?php

namespace HisInOneProxy\DataModel;

use HisInOneProxy\Config\GlobalSettings;
use HisInOneProxy\DataModel\Traits;

class EventType
{
	const TEXT = 'event_type';

	use Traits\Text,  Traits\DefaultLanguage, Traits\HisKeyId, Traits\ObjGuid, Traits\SortingOrder, Traits\UniqueName;

	/**
	 * @var string
	 */
	protected $address_type;

	/**
	 * @return string
	 */
	public function getText()
	{
		if(array_key_exists(self::TEXT, GlobalSettings::getInstance()->getTextConfig()))
		{
			if(method_exists($this, GlobalSettings::getInstance()->getTextConfig()[self::TEXT]))
			{
				return $this->{GlobalSettings::getInstance()->getTextConfig()[self::TEXT]}();
			}
		}
		return $this->getDefaultText();
	}

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