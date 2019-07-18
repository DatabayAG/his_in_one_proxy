<?php

namespace HisInOneProxy\Parser;

use HisInOneProxy\DataModel;

/**
 * Class ParseCourse
 * @package HisInOneProxy\Parser
 */
class ParseCourse extends SimpleXmlParser
{

    /**
     * @param         $xml
     * @return DataModel\Course
     */
    public function parse($xml)
    {
        $course = new DataModel\Course();

        if ($this->isAttributeValid($xml, 'id')) {
            $course->setId($xml->id);
            $this->log->info(sprintf('Found Course with id %s.', $course->getId()));
            if ($this->isAttributeValid($xml, 'objGuid')) {
                $course->setObjGuid($xml->objGuid);
            }
            if ($this->isAttributeValid($xml, 'lockVersion')) {
                $course->setLockVersion($xml->lockVersion);
            }
            if ($this->isAttributeValid($xml, 'academicYear')) {
                $course->setAcademicYear($xml->academicYear);
            }
            if ($this->isAttributeValid($xml, 'classAttendance')) {
                $course->setClassAttendance($xml->classAttendance);
            }
            if ($this->isAttributeValid($xml, 'compulsoryRequirement')) {
                $course->setCompulsoryRequirement($xml->compulsoryRequirement);
            }
            if ($this->isAttributeValid($xml, 'contents')) {
                $course->setContents($xml->contents);
            }
            if ($this->isAttributeValid($xml, 'courseAchievement')) {
                $course->setCourseAchievement($xml->courseAchievement);
            }
            if ($this->isAttributeValid($xml, 'credits')) {
                $course->setCredits($xml->credits);
            }
            if ($this->isAttributeValid($xml, 'directive')) {
                $course->setDirective($xml->directive);
            }
            if ($this->isAttributeValid($xml, 'eventtypeId')) {
                $course->setEventTypeId($xml->eventtypeId);
            }
            if ($this->isAttributeValid($xml, 'examinationAchievement')) {
                $course->setExaminationAchievement($xml->examinationAchievement);
            }
            if ($this->isAttributeValid($xml, 'externOrganizer')) {
                $course->setExternOrganizer($xml->externOrganizer);
            }
            if ($this->isAttributeValid($xml, 'frequencyOfOffervalueId')) {
                $course->setFrequencyOfOfferValueId($xml->frequencyOfOffervalueId);
            }
            if ($this->isAttributeValid($xml, 'grading')) {
                $course->setGrading($xml->grading);
            }
            if ($this->isAttributeValid($xml, 'independentStudy')) {
                $course->setIndependentStudy($xml->independentStudy);
            }
            if ($this->isAttributeValid($xml, 'intendedSemester')) {
                $course->setIntendedSemester($xml->intendedSemester);
            }
            if ($this->isAttributeValid($xml, 'learningTarget')) {
                $course->setLearningTarget($xml->learningTarget);
            }
            if ($this->isAttributeValid($xml, 'literature')) {
                $course->setLiterature($xml->literature);
            }
            if ($this->isAttributeValid($xml, 'objectiveQualification')) {
                $course->setObjectiveQualification($xml->objectiveQualification);
            }
            if ($this->isAttributeValid($xml, 'recommendation')) {
                $course->setRecommendation($xml->recommendation);
            }
            if ($this->isAttributeValid($xml, 'recommendedRequirement')) {
                $course->setRecommendedRequirement($xml->recommendedRequirement);
            }
            if ($this->isAttributeValid($xml, 'scheduledGroupSize')) {
                $course->setScheduledGroupSize($xml->scheduledGroupSize);
            }
            if ($this->isAttributeValid($xml, 'targetGroup')) {
                $course->setTargetGroup($xml->targetGroup);
            }
            if ($this->isAttributeValid($xml, 'teachingKLanguageId')) {
                $course->setTeachingKLanguageId($xml->teachingKLanguageId);
            }
            if ($this->isAttributeValid($xml, 'teachingMethod')) {
                $course->setTeachingMethod($xml->teachingMethod);
            }
            if ($this->isAttributeValid($xml, 'unitId')) {
                $course->setUnitId($xml->unitId);
            }
            if ($this->isAttributeValid($xml, 'workload')) {
                $course->setWorkload($xml->workload);
            }
        } else {
            $this->log->warning('No id given for Course, skipping!');
        }

        return $course;
    }
}
