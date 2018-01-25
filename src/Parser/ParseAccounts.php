<?php

namespace HisInOneProxy\Parser;

use HisInOneProxy\DataModel\CompleteAccount;

/**
 * Class ParseAddress
 * @package HisInOneProxy\Parser
 */
class ParseAccounts extends SimpleXmlParser
{
	/**
	 * @param $xml
	 * @return CompleteAccount[]
	 */
	public function parse($xml)
	{
		$container = array();
		if($this->doesAttributeExist($xml, 'completeAccounts60'))
		{
			$xml = $xml->completeAccounts60;
			if($this->doesMoreThanOneElementExists($xml, 'completeAccount60'))
			{
				foreach($xml->completeAccount60 as $account)
				{
					$container[] = $this->buildObject($account);
				}
			}
			else if($this->doesExactlyOneElementExists($xml, 'completeAccount60'))
			{
				$container[] = $this->buildObject($xml->completeAccount60);
			}
		}
		return $container;
	}

	/**
	 * @param $xml
	 * @return CompleteAccount
	 */
	protected function buildObject($xml)
	{
		$account = new CompleteAccount();
		if($this->isAttributeValid($xml, 'id'))
		{
			$account->setId($xml->id);
		}
		if($this->isAttributeValid($xml, 'personId'))
		{
			$account->setPersonId($xml->personId);
		}
		if($this->isAttributeValid($xml, 'username'))
		{
			$account->setUserName($xml->username);
		}
		if($this->isAttributeValid($xml, 'accountauthId'))
		{
			$account->setAccountAuthId($xml->accountauthId);
		}
		if($this->isAttributeValid($xml, 'authinfo'))
		{
			$account->setAuthInfo($xml->authinfo);
		}
		if($this->isAttributeValid($xml, 'externalsystemId'))
		{
			$account->setExternalSystemId($xml->externalsystemId);
		}
		if($this->isAttributeValid($xml, 'isLdapAccount'))
		{
			$account->setIsLdapAccount($xml->isLdapAccount);
		}
		if($this->isAttributeValid($xml, 'orgunitLid'))
		{
			$account->setOrgUnitLid($xml->orgunitLid);
		}
		if($this->isAttributeValid($xml, 'purposeId'))
		{
			$account->setPurposeId($xml->purposeId);
		}
		if($this->isAttributeValid($xml, 'blockedId'))
		{
			$account->setBlockedId($xml->blockedId);
		}
		return $account;
	}
}