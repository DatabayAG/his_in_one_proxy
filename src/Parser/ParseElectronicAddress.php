<?php

namespace HisInOneProxy\Parser;

use HisInOneProxy\DataModel\ElectronicAddress;

class ParseElectronicAddress extends SimpleXmlParser
{
	/**
	 * @param $xml
	 * @return ElectronicAddress[]
	 */
	public function parse($xml)
	{
        //Todo: possibility the the parser must be rebuild with the new webservice version
		$container = array();
		if($this->doesAttributeExist($xml, 'eAdresses'))
		{
			$xml = $xml->eAdresses;
			if($this->doesMoreThanOneElementExists($xml, 'eAddress'))
			{
				foreach($xml->eAddress as $address)
				{
					$container[] = $this->buildObject($address);
				}
			}
			else if($this->doesExactlyOneElementExists($xml, 'eAddress'))
			{
				$container[] = $this->buildObject($xml->eAddress);
			}
		}
		return $container;
	}

	/**
	 * @param $xml
	 * @return ElectronicAddress
	 */
	protected function buildObject($xml)
	{
		$address = new ElectronicAddress();
		if($this->isAttributeValid($xml, 'id'))
		{
			$address->setId($xml->id);
		}
		if($this->isAttributeValid($xml, 'addresstagId'))
		{
			$address->setAddressTagId($xml->addresstagId);
		}
		if($this->isAttributeValid($xml, 'sortorder'))
		{
			$address->setSortOrder($xml->sortorder);
		}
		if($this->isAttributeValid($xml, 'personId'))
		{
			$address->setPersonId($xml->personId);
		}
		if($this->isAttributeValid($xml, 'validTo'))
		{
			$address->setValidTo($xml->validTo);
		}
		if($this->isAttributeValid($xml, 'validFrom'))
		{
			$address->setValidFrom($xml->validFrom);
		}
		if($this->isAttributeValid($xml, 'orgunitLid'))
		{
			$address->setOrgUnitLid($xml->orgunitLid);
		}
		if($this->isAttributeValid($xml, 'buildingId'))
		{
			$address->setBuildingId($xml->buildingId);
		}
		if($this->isAttributeValid($xml, 'createdAt'))
		{
			$address->setCreatedAt($xml->createdAt);
		}
		if($this->isAttributeValid($xml, 'updatedAt'))
		{
			$address->setUpdatedAt($xml->updatedAt);
		}
		if($this->isAttributeValid($xml, 'eaddresstypeId'))
		{
			$address->setEAddressTypeId($xml->eaddresstypeId);
		}
		if($this->isAttributeValid($xml, 'eaddress'))
		{
			$address->setEAddress($xml->eaddress);
		}

		return $address;
	}
}