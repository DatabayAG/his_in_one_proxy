<?php

namespace HisInOneProxy\DataModel;

use HisInOneProxy\DataModel\Traits;

/**
 * Class StudentExisting
 * @package HisInOneProxy\DataModel
 */
class StudentExisting
{
    use Traits\OrgUnitId, Traits\TermTypeValueId, Traits\Year;
    /**
     * @var int
     */
    protected $connected_to_subject;

    /**
     * @var DegreeProgram
     */
    protected $degree_programs_70;

    /**
     * @var int
     */
    protected $edu_type;

    /**
     * @var \DateTime
     */
    protected $enrollment_date;

    /**
     * @var int
     */
    protected $exchange_program_id;

    /**
     * @var int
     */
    protected $has_loan_request;

    /**
     * @var int
     */
    protected $home_country_id;

    /**
     * @var int
     */
    protected $home_district_id;

    /**
     * @var int
     */
    protected $home_district_obj_id;

    /**
     * @var float
     */
    protected $kolleg_semester;

    /**
     * @var float
     */
    protected $leave_semester;

    /**
     * @var Person
     */
    protected $person;

    /**
     * @var float
     */
    protected $practical_semester;

    /**
     * @var int
     */
    protected $request_for_dis_enrollment;

    /**
     * @var int
     */
    protected $registration_number;

    /**
     * @var int
     */
    protected $semester_country_id;

    /**
     * @var int
     */
    protected $semester_district_id;

    /**
     * @var int
     */
    protected $semester_district_obj_id;

    /**
     * @var int
     */
    protected $study_status_id;

    /**
     * @var float
     */
    protected $university_semester;

    /**
     * @var int
     */
    protected $student_function_locks;

    /**
     * @return int
     */
    public function getConnectedToSubject()
    {
        return $this->connected_to_subject;
    }

    /**
     * @param int $connected_to_subject
     */
    public function setConnectedToSubject($connected_to_subject)
    {
        $this->connected_to_subject = $connected_to_subject;
    }

    /**
     * @return DegreeProgram
     */
    public function getDegreePrograms70()
    {
        return $this->degree_programs_70;
    }

    /**
     * @param DegreeProgram $degree_programs_70
     */
    public function setDegreePrograms70($degree_programs_70)
    {
        $this->degree_programs_70 = $degree_programs_70;
    }

    /**
     * @return int
     */
    public function getEduType()
    {
        return $this->edu_type;
    }

    /**
     * @param int $edu_type
     */
    public function setEduType($edu_type)
    {
        $this->edu_type = $edu_type;
    }

    /**
     * @return \DateTime
     */
    public function getEnrollmentDate()
    {
        return $this->enrollment_date;
    }

    /**
     * @param \DateTime $enrollment_date
     */
    public function setEnrollmentDate($enrollment_date)
    {
        $this->enrollment_date = $enrollment_date;
    }

    /**
     * @return int
     */
    public function getExchangeProgramId()
    {
        return $this->exchange_program_id;
    }

    /**
     * @param int $exchange_program_id
     */
    public function setExchangeProgramId($exchange_program_id)
    {
        $this->exchange_program_id = $exchange_program_id;
    }

    /**
     * @return int
     */
    public function getHasLoanRequest()
    {
        return $this->has_loan_request;
    }

    /**
     * @param int $has_loan_request
     */
    public function setHasLoanRequest($has_loan_request)
    {
        $this->has_loan_request = $has_loan_request;
    }

    /**
     * @return int
     */
    public function getHomeCountryId()
    {
        return $this->home_country_id;
    }

    /**
     * @param int $home_country_id
     */
    public function setHomeCountryId($home_country_id)
    {
        $this->home_country_id = $home_country_id;
    }

    /**
     * @return int
     */
    public function getHomeDistrictId()
    {
        return $this->home_district_id;
    }

    /**
     * @param int $home_district_id
     */
    public function setHomeDistrictId($home_district_id)
    {
        $this->home_district_id = $home_district_id;
    }

    /**
     * @return int
     */
    public function getHomeDistrictObjId()
    {
        return $this->home_district_obj_id;
    }

    /**
     * @param int $home_district_obj_id
     */
    public function setHomeDistrictObjId($home_district_obj_id)
    {
        $this->home_district_obj_id = $home_district_obj_id;
    }

    /**
     * @return float
     */
    public function getKollegSemester()
    {
        return $this->kolleg_semester;
    }

    /**
     * @param float $kolleg_semester
     */
    public function setKollegSemester($kolleg_semester)
    {
        $this->kolleg_semester = $kolleg_semester;
    }

    /**
     * @return float
     */
    public function getLeaveSemester()
    {
        return $this->leave_semester;
    }

    /**
     * @param float $leave_semester
     */
    public function setLeaveSemester($leave_semester)
    {
        $this->leave_semester = $leave_semester;
    }

    /**
     * @return Person
     */
    public function getPerson()
    {
        return $this->person;
    }

    /**
     * @param Person $person
     */
    public function setPerson($person)
    {
        $this->person = $person;
    }

    /**
     * @return float
     */
    public function getPracticalSemester()
    {
        return $this->practical_semester;
    }

    /**
     * @param float $practical_semester
     */
    public function setPracticalSemester($practical_semester)
    {
        $this->practical_semester = $practical_semester;
    }

    /**
     * @return int
     */
    public function getRequestForDisEnrollment()
    {
        return $this->request_for_dis_enrollment;
    }

    /**
     * @param int $request_for_dis_enrollment
     */
    public function setRequestForDisEnrollment($request_for_dis_enrollment)
    {
        $this->request_for_dis_enrollment = $request_for_dis_enrollment;
    }

    /**
     * @return int
     */
    public function getRegistrationNumber()
    {
        return $this->registration_number;
    }

    /**
     * @param int $registration_number
     */
    public function setRegistrationNumber($registration_number)
    {
        $this->registration_number = $registration_number;
    }

    /**
     * @return int
     */
    public function getSemesterCountryId()
    {
        return $this->semester_country_id;
    }

    /**
     * @param int $semester_country_id
     */
    public function setSemesterCountryId($semester_country_id)
    {
        $this->semester_country_id = $semester_country_id;
    }

    /**
     * @return int
     */
    public function getSemesterDistrictId()
    {
        return $this->semester_district_id;
    }

    /**
     * @param int $semester_district_id
     */
    public function setSemesterDistrictId($semester_district_id)
    {
        $this->semester_district_id = $semester_district_id;
    }

    /**
     * @return int
     */
    public function getSemesterDistrictObjId()
    {
        return $this->semester_district_obj_id;
    }

    /**
     * @param int $semester_district_obj_id
     */
    public function setSemesterDistrictObjId($semester_district_obj_id)
    {
        $this->semester_district_obj_id = $semester_district_obj_id;
    }

    /**
     * @return int
     */
    public function getStudyStatusId()
    {
        return $this->study_status_id;
    }

    /**
     * @param int $study_status_id
     */
    public function setStudyStatusId($study_status_id)
    {
        $this->study_status_id = $study_status_id;
    }

    /**
     * @return float
     */
    public function getUniversitySemester()
    {
        return $this->university_semester;
    }

    /**
     * @param float $university_semester
     */
    public function setUniversitySemester($university_semester)
    {
        $this->university_semester = $university_semester;
    }

    /**
     * @return int
     */
    public function getStudentFunctionLocks()
    {
        return $this->student_function_locks;
    }

    /**
     * @param int $student_function_locks
     */
    public function setStudentFunctionLocks($student_function_locks)
    {
        $this->student_function_locks = $student_function_locks;
    }
}