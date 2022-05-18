<?php

namespace HisInOneProxy\Soap;

use HisInOneProxy\DataModel\Address;
use HisInOneProxy\DataModel\ElectronicAddress;
use HisInOneProxy\Log\Log;
use HisInOneProxy\Parser;
use SoapFault;

/**
 * Class PersonAddressService
 * @package HisInOneProxy\Soap
 */
class PersonAddressService extends SoapService
{

    /**
     * PersonAddressService constructor.
     * @param Log               $log
     * @param SoapServiceRouter $soap_service_router
     */
    public function __construct($log, $soap_service_router)
    {
        parent::__construct($log, $soap_service_router);
    }

    /**
     * @param $org_unit_id
     * @return Address[] | null
     */
    public function readPostAddresses($org_unit_id)
    {
        // 'Person', 'Orgunit', 'Room', 'Building'
        $params = array(array('id' => $org_unit_id, 'objekttype' => 'Orgunit'));
        try {
            $response = $this->soap_service_router->getSoapClientPersonAddressService()->__soapCall('readPostAddresses', $params);
            $parser   = new Parser\ParseAddress($this->log);
            $address  = $parser->parse($response);

            return $address;
        } catch (SoapFault $exception) {
            $this->log->error($exception->getMessage());
        }
        return null;
    }

    /**
     * @param $person_id
     * @return ElectronicAddress[]|null
     */
    public function readEAddresses($person_id)
    {
        // 'Person', 'Orgunit', 'Room', 'Building'
        // $params = array(array('id' => $person_id, 'objekttype' => 'Person'));
        $params = array(array('id' => $person_id));
        try {
            $response   = $this->soap_service_router->getSoapClientPersonAddressService()->__soapCall('readEAddresses', $params);
            $parser     = new Parser\ParseElectronicAddress($this->log);
            $eaddresses = $parser->parse($response);

            return $eaddresses;
        } catch (SoapFault $exception) {
            $this->log->error($exception->getMessage());
        }
        return null;
    }

}