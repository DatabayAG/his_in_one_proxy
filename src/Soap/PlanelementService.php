<?php

namespace HisInOneProxy\Soap;

use Exception;
use HisInOneProxy\DataModel\PlanElement;
use HisInOneProxy\DataModel\Unit;
use HisInOneProxy\Parser;
use SoapFault;

/**
 * Class PlanelementService
 * @package HisInOneProxy\Soap
 */
class PlanelementService extends SoapService
{
    protected $soap_client;

    /**
     * PlanelementService constructor.
     * @param $log
     * @param SoapServiceRouter $soap_service_router
     */
    public function __construct($log, $soap_service_router)
    {
        parent::__construct($log, $soap_service_router);
        $this->soap_client = $this->soap_service_router->getSoapClientPlanelementService();
    }

    /**
     * @param $plan_element_id
     * @return PlanElement|null
     * @throws Exception
     */
    public function readPlanElementOfEvent($plan_element_id)
    {
        $params = array(array('planelementId' => $plan_element_id));
        try {
            $response = $this->soap_client->__soapCall('readPlanelementOfEvent', $params);
            if (isset($response->planelement)) {
                $unit   = new Unit();
                $parser = new Parser\ParsePlanElements($this->log);
                $wrapper = new \stdClass();
                $wrapper->planelements = array($response->planelement);
                $parser->parse($wrapper, $unit);
                $elements = $unit->getPlanElementContainer();
                return count($elements) > 0 ? reset($elements) : null;
            }
        } catch (SoapFault $exception) {
            $this->log->error($exception->getMessage());
        }
        return null;
    }

    /**
     * @param $unit_id
     * @return Unit|null
     * @throws Exception
     */
    public function readAllPlanelementsOfEventForUnit($unit_id)
    {
        $params = array(array('unitId' => $unit_id));
        try {
            $response = $this->soap_client->__soapCall('readAllPlanelementsOfEventForUnit', $params);
            if (isset($response->planelements)) {
                $unit   = new Unit();
                $parser = new Parser\ParsePlanElements($this->log);
                $parser->parse($response, $unit);
                return $unit;
            }
        } catch (SoapFault $exception) {
            $this->log->error($exception->getMessage());
        }
        return null;
    }
}
