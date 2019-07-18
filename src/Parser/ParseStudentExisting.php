<?php

namespace HisInOneProxy\Parser;

use HisInOneProxy\DataModel;

/**
 * Class ParseStudentExisting
 * @package HisInOneProxy\Parser
 */
class ParseStudentExisting extends SimpleXmlParser
{
    /**
     * @param $xml
     * @return DataModel\StudentExisting
     */
    public function parse($xml)
    {
        $student_existing = new DataModel\StudentExisting();

        if ($this->isAttributeValid($xml, 'connectedToSubject')) {
            $student_existing->setConnectedToSubject($xml->connectedToSubject);
        }
        if ($this->isAttributeValid($xml, 'degreePrograms70')) {
            $student_existing->setDegreePrograms70($xml->degreePrograms70);
        }
        if ($this->isAttributeValid($xml, 'eduType')) {
            $student_existing->setEduType($xml->eduType);
        }
        if ($this->isAttributeValid($xml, 'enrollmentdate')) {
            $student_existing->setEnrollmentDate($xml->enrollmentdate);
        }
        if ($this->isAttributeValid($xml, 'exchangeprogramId')) {
            $student_existing->setExchangeProgramId($xml->exchangeprogramId);
        }
        if ($this->isAttributeValid($xml, 'hasLoanRequest')) {
            $student_existing->setHasLoanRequest($xml->hasLoanRequest);
        }
        if ($this->isAttributeValid($xml, 'homeCountryId')) {
            $student_existing->setHomeCountryId($xml->homeCountryId);
        }
        if ($this->isAttributeValid($xml, 'homeDistrictId')) {
            $student_existing->setHomeDistrictId($xml->homeDistrictId);
        }
        if ($this->isAttributeValid($xml, 'homeDistrictObjId')) {
            $student_existing->setHomeDistrictObjId($xml->homeDistrictObjId);
        }
        if ($this->isAttributeValid($xml, 'kollegsemester')) {
            $student_existing->setKollegSemester($xml->kollegsemester);
        }
        if ($this->isAttributeValid($xml, 'leavesemester')) {
            $student_existing->setLeaveSemester($xml->leavesemester);
        }
        if ($this->isAttributeValid($xml, 'orgunitId')) {
            $student_existing->setOrgUnitId($xml->orgunitId);
        }
        if ($this->isAttributeValid($xml, 'orgunitLid')) {
            $student_existing->setOrgUnitLid($xml->orgunitLid);
        }
        if ($this->isAttributeValid($xml, 'person')) {
            $student_existing->setPerson($xml->person);
        } else {
            $this->log->error('No person returned in student existing!');
        }
        if ($this->isAttributeValid($xml, 'practicalsemester')) {
            $student_existing->setPracticalSemester($xml->practicalsemester);
        }
        if ($this->isAttributeValid($xml, 'requestForDisenrollment')) {
            $student_existing->setRequestForDisEnrollment($xml->requestForDisenrollment);
        }
        if ($this->isAttributeValid($xml, 'registrationnumber')) {
            $student_existing->setRegistrationNumber($xml->registrationnumber);
        }
        if ($this->isAttributeValid($xml, 'semesterCountryId')) {
            $student_existing->setSemesterCountryId($xml->semesterCountryId);
        }
        if ($this->isAttributeValid($xml, 'semesterDistrictId')) {
            $student_existing->setSemesterDistrictId($xml->semesterDistrictId);
        }
        if ($this->isAttributeValid($xml, 'semesterDistrictObjId')) {
            $student_existing->setSemesterDistrictObjId($xml->semesterDistrictObjId);
        }
        if ($this->isAttributeValid($xml, 'studystatusId')) {
            $student_existing->setStudyStatusId($xml->studystatusId);
        }
        if ($this->isAttributeValid($xml, 'termTypeValueId')) {
            $student_existing->setTermTypeValueId($xml->termTypeValueId);
        }
        if ($this->isAttributeValid($xml, 'universitysemester')) {
            $student_existing->setUniversitySemester($xml->universitysemester);
        }
        if ($this->isAttributeValid($xml, 'year')) {
            $student_existing->setYear($xml->year);
        }
        if ($this->isAttributeValid($xml, 'studentFunctionlocks')) {
            $student_existing->setStudentFunctionLocks($xml->studentFunctionlocks);
        }

        return $student_existing;
    }
}