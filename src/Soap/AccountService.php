<?php

namespace HisInOneProxy\Soap;

use HisInOneProxy\DataModel\CompleteAccount;
use HisInOneProxy\Log\Log;
use HisInOneProxy\Parser\ParseAccounts;
use SoapFault;

/**
 * Class AccountService
 * @package HisInOneProxy\Soap
 */
class AccountService extends SoapService
{

    /**
     * AccountService constructor.
     * @param Log               $log
     * @param SoapServiceRouter $soap_service_router
     */
    public function __construct($log, $soap_service_router)
    {
        parent::__construct($log, $soap_service_router);
    }

    /**
     * @param $person_id
     * @return CompleteAccount[]|null
     */
    public function searchAccountForPerson61($person_id)
    {
        $params = array(array('personId' => $person_id));
        try {
            $response     = $this->soap_service_router->getSoapClientAccountService()->__soapCall('searchAccountForPerson61', $params);
            $parser       = new ParseAccounts($this->log);
            $account_list = $parser->parse($response);
            return $account_list;
        } catch (SoapFault $exception) {
            $this->log->error($exception->getMessage());
        }
        return null;
    }

}