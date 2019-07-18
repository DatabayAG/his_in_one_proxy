<?php

namespace HisInOneProxy\Soap;

use HisInOneProxy\DataModel\Unit;
use HisInOneProxy\Parser;

/**
 * Class CourseService
 * @package HisInOneProxy\Soap
 */
class CourseService extends SoapService
{

    /**
     * CourseService constructor.
     * @param                   $log
     * @param SoapServiceRouter $soap_service_router
     */
    public function __construct($log, $soap_service_router)
    {
        parent::__construct($log, $soap_service_router);
    }

    /**
     * @param $plan_element_id
     * @return null
     */
    public function getPlanElementById($plan_element_id)
    {
        $params = array(array('planelementId' => $plan_element_id));
        try {
            $response = $this->soap_service_router->getSoapClientCourseService()->__soapCall('getPlanElementById', $params);
            $parser   = new Parser\ParsePlanElements($this->log);
            if (isset($response->examplans)) {
                $exam_relation = $parser->parse($response, new Unit());
                return $exam_relation;
            }
        } catch (\SoapFault $exception) {
            $this->log->error($exception->getMessage());
        }
        return null;
    }

    /**
     * @param $unit_id
     * @return null
     */
    public function getAllPlanelementsOfUnit($unit_id)
    {
        $params = array(array('unitId' => $unit_id));
        try {
            $response = $this->soap_service_router->getSoapClientCourseService()->__soapCall('getAllPlanelementsOfUnit', $params);
            $parser   = new Parser\ParsePlanElements($this->log);
            if (isset($response->examplans)) {
                #$exam_relation = $parser->parse($response);
                #	return $exam_relation;
            }
        } catch (\SoapFault $exception) {
            $this->log->error($exception->getMessage());
        }
        return null;
    }

}