<?php

namespace HisInOneProxy\Soap;

use HisInOneProxy\DataModel\StudentExisting;
use HisInOneProxy\Parser;
use SoapFault;

/**
 * Class StudentService
 * @package HisInOneProxy\Soap
 */
class StudentService extends SoapService
{

    /**
     * @var WSSoapClient|null
     */
    protected $soap_student;

    /**
     * CourseCatalogService constructor.
     * @param                   $log
     * @param SoapServiceRouter $soap_service_router
     */
    public function __construct($log, $soap_service_router)
    {
        parent::__construct($log, $soap_service_router);
        $this->soap_student = $this->soap_service_router->getSoapClientStudentService();
    }

    /**
     * @param $student_id
     * @return StudentExisting|null
     */
    public function readStudentWithCoursesOfStudyByStudentId($student_id)
    {
        $params = array(array('studentId' => $student_id));
        try {
            $response = $this->soap_student->__soapCall('readStudentWithCoursesOfStudyByStudentId70', $params);
            $parser   = new Parser\ParseStudentExisting($this->log);
            $student  = $parser->parse($response->student);
            return $student;
        } catch (SoapFault $exception) {
            $this->log->error($exception->getMessage());
        }
        return null;
    }

    /**
     * @param $person_id
     * @return StudentExisting|null
     */
    public function readStudentWithCoursesOfStudyByPersonId($person_id)
    {
        $params = array(array('personId' => $person_id));
        try {
            $response = $this->soap_student->__soapCall('readStudentWithCoursesOfStudyByPersonId70', $params);
            $parser   = new Parser\ParseStudentExisting($this->log);
            $student  = $parser->parse($response->student);
            return $student;
        } catch (SoapFault $exception) {
            $this->log->error($exception->getMessage());
        }
        return null;
    }

    /**
     * @return null
     */
    public function getUniversityLid()
    {
        $params = array(array());
        try {
            $response = $this->soap_student->__soapCall('getUniversityLid', $params);
            $lid      = $response->universityLid;
            return $lid;
        } catch (SoapFault $exception) {
            $this->log->error($exception->getMessage());
        }
        return null;
    }
}