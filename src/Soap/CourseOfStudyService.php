<?php

namespace HisInOneProxy\Soap;

use HisInOneProxy\DataModel\CourseOfStudy;
use HisInOneProxy\Log\Log;
use HisInOneProxy\Parser;
use SoapFault;

/**
 * Class CourseOfStudyService
 * @package HisInOneProxy\Soap
 */
class CourseOfStudyService extends SoapService
{

    /**
     * @var WSSoapClient|null
     */
    protected $soap_course_of_study;

    /**
     * CourseOfStudyService constructor.
     * @param Log               $log
     * @param SoapServiceRouter $soap_service_router
     */
    public function __construct($log, $soap_service_router)
    {
        parent::__construct($log, $soap_service_router);
        $this->soap_course_of_study = $this->soap_service_router->getSoapClientCourseOfStudyService();
    }

    /**
     * @param $course_of_study_id
     * @return CourseOfStudy | null
     */
    public function getCourseOfStudyById($course_of_study_id)
    {
        $params = array(array('courseOfStudyId' => $course_of_study_id));
        try {
            $response = $this->soap_course_of_study->__soapCall('getCourseOfStudyById', $params);
            $parser   = new Parser\ParseCourseOfStudy($this->log);
            $study    = $parser->parse($response->courseOfStudy);
            return $study;
        } catch (SoapFault $exception) {
            $this->log->error($exception->getMessage());
        }
        return null;
    }

    /**
     * @return array | null
     */
    public function findCourseOfStudy()
    {
        $params = array();
        $map    = array();
        try {
            $response = $this->soap_course_of_study->__soapCall('findCourseOfStudy', $params);
            if ($response != null && $response->searchedCos != null) {
                $response = json_encode($response);
                $array    = json_decode($response, true);
                $arr      = $array['searchedCos']['searchedCos'];
                foreach ($arr as $value) {
                    $map[$value['courseofstudyLid']] = $value['courseofstudyId'];
                }
            }
            return $map;
        } catch (SoapFault $exception) {
            $this->log->error($exception->getMessage());
        }
        return null;
    }
}