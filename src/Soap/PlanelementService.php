<?php

namespace HisInOneProxy\Soap;

use HisInOneProxy\DataModel\Unit;
use HisInOneProxy\Parser;
use SoapFault;

/**
 * Class PlanelementService
 * @package HisInOneProxy\Soap
 */
class PlanelementService extends SoapService
{

    /**
     * @param $log
     * @param $soap_service_router
     */
    public function __construct($log, $soap_service_router)
    {
        parent::__construct($log, $soap_service_router);
    }

    /**
     * @param $plan_element_id
     * @return null
     */
    public function readPlanElementOfEvent($plan_element_id)
    {
        $params = array(array('planelementId' => $plan_element_id));
        try {
            $response = $this->soap_service_router->getSoapClientPlanelementService()->__soapCall('readPlanelementOfEvent', $params);
            $parser   = new Parser\ParsePlanElements($this->log);
            if (isset($response->examplans)) {
                $exam_relation = $parser->parse($response, new Unit());
                return $exam_relation;
            }
        } catch (SoapFault $exception) {
            $this->log->error($exception->getMessage());
        }
        return null;
    }

    /**
     * @param $unit_id
     * @return null
     */
    public function readAllPlanelementsOfEventForUnit($unit_id)
    {
        $params = array(array('unitId' => $unit_id));
        try {
            $response = $this->soap_service_router->getSoapClientPlanelementService()->__soapCall('readAllPlanelementsOfEventForUnit', $params);
            $parser   = new Parser\ParsePlanElements($this->log);
            if (isset($response->examplans)) {
                #$exam_relation = $parser->parse($response);
                #	return $exam_relation;
            }
        } catch (SoapFault $exception) {
            $this->log->error($exception->getMessage());
        }
        return null;
    }

}