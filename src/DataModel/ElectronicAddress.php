<?php

namespace HisInOneProxy\DataModel;
/**
 * Class ElectronicAddress
 * @package HisInOneProxy\DataModel
 */
class ElectronicAddress extends Address
{

	/**
	 * @var int
	 */
	protected $electronic_address_type_id;

	/**
	 * @var string
	 */
	protected $electronic_address;

	/**
	 * @return int
	 */
	public function getEAddressTypeId()
	{
		return $this->electronic_address_type_id;
	}

	/**
	 * @param int $e_address_type_id
	 */
	public function setEAddressTypeId($e_address_type_id)
	{
		$this->electronic_address_type_id = $e_address_type_id;
	}

	/**
	 * @return string
	 */
	public function getEAddress()
	{
		return $this->electronic_address;
	}

	/**
	 * @param string $e_address
	 */
	public function setEAddress($e_address)
	{
		$this->electronic_address = $e_address;
	}
}