<?php

namespace HisInOneProxy\DataModel\Container;

use Generator;
use HisInOneProxy\DataModel\CompleteAccount;

/**
 * Class AccountList
 * @package HisInOneProxy\DataModel\Container
 */
class AccountList
{
    /**
     * @var array
     */
    protected $account_container = array();

    /**
     * @return array
     */
    public function getAccountContainer()
    {
        return $this->account_container;
    }

    /**
     * @return Generator
     */
    public function getAccount()
    {
        foreach ($this->account_container as $account) {
            yield $account;
        }
    }

    /**
     * @param CompleteAccount $account
     */
    public function appendAccount($account)
    {
        $this->account_container[] = $account;
    }

    /**
     * @return int
     */
    public function getSizeOfContainer()
    {
        return count($this->account_container);
    }
}