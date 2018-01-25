<?php

namespace HisInOneProxy\DataModel;

use HisInOneProxy\DataModel\Traits;

/**
 * Class CompleteAccount
 * @package HisInOneProxy\DataModel
 */
class CompleteAccount
{
	use Traits\Valid;

	/**
	 * @var string
	 */
	protected $id;

	/**
	 * @var string
	 */
	protected $person_id;

	/**
	 * @var string
	 */
	protected $user_name;

	/**
	 * @var string
	 */
	protected $account_auth_id;

	/**
	 * @var string
	 */
	protected $auth_info;

	/**
	 * @var string
	 */
	protected $external_system_id;

	/**
	 * @var string
	 */
	protected $is_ldap_account;

	/**
	 * @var string
	 */
	protected $purpose_id;

	/**
	 * @var string
	 */
	protected $org_unit_lid;

	/**
	 * @var int
	 */
	protected $blocked_id;

	/**
	 * @return string
	 */
	public function getPersonId()
	{
		return $this->person_id;
	}

	/**
	 * @param string $person_id
	 */
	public function setPersonId($person_id)
	{
		$this->person_id = $person_id;
	}

	/**
	 * @return string
	 */
	public function getId()
	{
		return $this->id;
	}

	/**
	 * @param string $id
	 */
	public function setId($id)
	{
		$this->id = $id;
	}

	/**
	 * @return string
	 */
	public function getUserName()
	{
		return $this->user_name;
	}

	/**
	 * @param string $user_name
	 */
	public function setUserName($user_name)
	{
		$this->user_name = $user_name;
	}

	/**
	 * @return string
	 */
	public function getAccountAuthId()
	{
		return $this->account_auth_id;
	}

	/**
	 * @param string $account_auth_id
	 */
	public function setAccountAuthId($account_auth_id)
	{
		$this->account_auth_id = $account_auth_id;
	}

	/**
	 * @return string
	 */
	public function getAuthInfo()
	{
		return $this->auth_info;
	}

	/**
	 * @param string $auth_info
	 */
	public function setAuthInfo($auth_info)
	{
		$this->auth_info = $auth_info;
	}

	/**
	 * @return string
	 */
	public function getExternalSystemId()
	{
		return $this->external_system_id;
	}

	/**
	 * @param string $external_system_id
	 */
	public function setExternalSystemId($external_system_id)
	{
		$this->external_system_id = $external_system_id;
	}

	/**
	 * @return string
	 */
	public function isLdapAccount()
	{
		return $this->is_ldap_account;
	}

	/**
	 * @param string $is_ldap_account
	 */
	public function setIsLdapAccount($is_ldap_account)
	{
		$this->is_ldap_account = $is_ldap_account;
	}

	/**
	 * @return string
	 */
	public function getPurposeId()
	{
		return $this->purpose_id;
	}

	/**
	 * @param string $purpose_id
	 */
	public function setPurposeId($purpose_id)
	{
		$this->purpose_id = $purpose_id;
	}

	/**
	 * @return string
	 */
	public function getOrgUnitLid()
	{
		return $this->org_unit_lid;
	}

	/**
	 * @param string $org_unit_lid
	 */
	public function setOrgUnitLid($org_unit_lid)
	{
		$this->org_unit_lid = $org_unit_lid;
	}

	/**
	 * @return int
	 */
	public function getBlockedId()
	{
		return $this->blocked_id;
	}

	/**
	 * @param int $blocked_id
	 */
	public function setBlockedId($blocked_id)
	{
		$this->blocked_id = $blocked_id;
	}
}