<?php

namespace HisInOneProxy\Soap;

use Exception;
use HisInOneProxy\DataModel\Person;
use HisInOneProxy\Log\Log;
use HisInOneProxy\Parser;
use HisInOneProxy\Soap\Interactions\DataCache;
use SoapFault;

/**
 * Class PersonService
 * @package HisInOneProxy\Soap
 */
class PersonService extends SoapService
{

    /**
     * CourseCatalogService constructor.
     * @param Log               $log
     * @param SoapServiceRouter $soap_service_router
     */
    public function __construct($log, $soap_service_router)
    {
        parent::__construct($log, $soap_service_router);
    }

    /**
     * @param $person_id
     * @return Person|null
     * @throws Exception
     */
    public function readPerson($person_id)
    {
        $params = array(array('id' => $person_id));
        try {
            $response = $this->soap_service_router->getSoapClientPersonService()->__soapCall('readPerson', $params);
            $parser   = new Parser\ParsePerson($this->log);
            if (isset($response->person) && $response->person != null && $response->person != '') {
                $person = $parser->parse($response->person);
                $person->setEAddresses(DataCache::getInstance()->getAddressService()->readEAddressesForPerson($person_id));
                return $person;
            }
        } catch (SoapFault $exception) {
            $this->log->error($exception->getMessage());
        }
        return null;
    }

}