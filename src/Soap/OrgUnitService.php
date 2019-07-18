<?php

namespace HisInOneProxy\Soap;

use HisInOneProxy\DataModel\OrgUnit;
use HisInOneProxy\Log\Log;
use HisInOneProxy\Parser;
use SoapFault;

/**
 * Class OrgUnitService
 * @package HisInOneProxy\Soap
 */
class OrgUnitService extends SoapService
{

    /**
     * @var WSSoapClient|null
     */
    protected $soap_org_unit;

    /**
     * CourseCatalogService constructor.
     * @param Log               $log
     * @param SoapServiceRouter $soap_service_router
     */
    public function __construct($log, $soap_service_router)
    {
        parent::__construct($log, $soap_service_router);
        $this->soap_org_unit = $this->soap_service_router->getSoapClientOrgUnitService();
    }

    /**
     * @param $lid
     * @param $date
     * @return OrgUnit | null
     */
    public function readOrgUnit($lid, $date = null)
    {
        $params = array(array('lid' => $lid, 'date' => $date));
        try {
            $response = $this->soap_org_unit->__soapCall('readOrgUnit61', $params);
            $parser   = new Parser\ParseOrgUnit($this->log);
            $org_unit = $parser->parse($response->orgunit);
            return $org_unit;
        } catch (SoapFault $exception) {
            $this->log->error($exception->getMessage());
        }
        return null;
    }

    /**
     * @return int | null
     */
    public function getUniversityLid()
    {
        $params = array();
        try {
            $response = $this->soap_org_unit->__soapCall('getUniversityLid', $params);
            return $response->universityLid;
        } catch (SoapFault $exception) {
            $this->log->error($exception->getMessage());
        }
        return null;
    }

    /**
     * @param $lid
     * @param $date
     * @return OrgUnit | null
     */
    public function getOrgUnitWithChildren($lid, $date = null)
    {
        $params  = array(array('lid' => $lid, 'date' => $date));
        $service = new AddressService($this->log, $this->soap_service_router);

        try {
            $response = $this->soap_org_unit->__soapCall('getOrgUnitWithChildren', $params);
            $parser   = new Parser\ParseOrgUnit($this->log);
            $org_unit = $parser->parse($response->orgunit);
            if (count($org_unit->getContainer()) > 0) {
                foreach ($org_unit->getContainer() as $value) {
                    #$address = $service->readPostAddresses($org_unit->getId());

                    if ($value->getLid() > 0 && $value->getLid() != '') {
                        $value->replaceContainerObjectWithNewChildren($this->getOrgUnitWithChildren($value->getLid()));
                    }
                }
            }
            return $org_unit;
        } catch (SoapFault $exception) {
            $this->log->error($exception->getMessage());
        }
        return null;
    }
}