<?php

namespace HisInOneProxy\Soap;

use Exception;
use HisInOneProxy\DataModel\Unit;
use HisInOneProxy\Parser;
use SoapFault;

/**
 * Class CurriculumDesignerService
 * @package HisInOneProxy\Soap
 */
class CurriculumDesignerService extends SoapService
{

    protected $soap_unit;

    /**
     * CurriculumDesignerService constructor.
     * @param                   $log
     * @param SoapServiceRouter $soap_service_router
     */
    public function __construct($log, $soap_service_router)
    {
        parent::__construct($log, $soap_service_router);
        $this->soap_unit = $this->soap_service_router->getSoapClientCurriculumDesingerService();
    }

    /**
     * @param $unitId
     * @return Unit|null
     * @throws Exception
     */
    public function readUnit($unitId)
    {
        $params = array(array('unitId' => $unitId));
        try {
            $response = $this->soap_unit->__soapCall('readUnit', $params);
            $parser   = new Parser\ParseUnit($this->log);
            if (isset($response->unit)) {

                $unit = $parser->parse($response->unit);
                return $unit;
            } else {
                $this->log->error('No unit object found in response!');
            }
        } catch (SoapFault $exception) {
            $this->log->error($exception->getMessage());
        }
        return null;
    }

    /**
     * @param $unitId
     * @return Unit|null
     * @throws Exception
     */
    public function readChildUnitRelations($unitId)
    {
        $params = array(array('unitId' => $unitId));
        try {
            $response = $this->soap_unit->__soapCall('readChildUnitRelations', $params);
            $parser   = new Parser\ParseUnit($this->log);
            if (isset($response->unit)) {
                $unit     = $parser->parse($response->unit);
                $response = $this->soap_unit->__soapCall('readUnitWithRelations', $params);
                $parser   = new Parser\ParseOrgUnitList($this->log);
                #if (array_key_exists('unitOrgunitList', $response)) {
                if (array_key_exists('unitOrgunits', $response)) {
                    $org_units = $parser->parse($response->unitOrgunits);
                    $unit->setOrgUnitsContainer($org_units);
                }
                return $unit;
            } else {
                $this->log->error('No unit object found in response!');
            }
        } catch (SoapFault $exception) {
            $this->log->error($exception->getMessage());
        }
        return null;
    }

    /**
     * @param $unitId
     * @return array | null
     */
    public function readUnitWithRelations($unitId)
    {
        $params = array(array('unitId' => $unitId));
        try {
            $response      = $this->soap_unit->__soapCall('readUnitWithRelations', $params);
            $org_unit_lids = array();
            if (isset($response->unitOrgunitList)) {
                $list = $response->unitOrgunitList;
                if (is_array($list->unitOrgunitInfo)) {
                    foreach ($list->unitOrgunitInfo as $org_unit) {
                        $org_unit_lids[] = $org_unit->orgunitLid;
                    }
                } else {
                    $org_unit_lids[] = $list->unitOrgunitInfo->orgunitLid;
                }

                return $org_unit_lids;
            } else {
                $this->log->error('No unit object found in response!');
            }
        } catch (SoapFault $exception) {
            $this->log->error($exception->getMessage());
        }
        return null;
    }
}