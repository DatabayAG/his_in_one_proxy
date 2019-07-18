<?php

namespace HisInOneProxy\Parser;

use HisInOneProxy\DataModel;

/**
 * Class ParseEventDate
 * @package HisInOneProxy\Parser
 */
class ParseEventDate extends SimpleXmlParser
{

    /**
     * @param                       $xml
     * @param DataModel\PlanElement $planElement
     */
    public function parse($xml, $planElement)
    {
        $event_date = new DataModel\EventDate();

        if ($this->isAttributeValid($xml, 'id')) {
            $event_date->setId($xml->id);
            $this->log->info(sprintf('Found EventDate with id %s.', $event_date->getId()));
            if ($this->isAttributeValid($xml, 'objGuid')) {
                $event_date->setObjGuid($xml->objGuid);
            }
            if ($this->isAttributeValid($xml, 'lockVersion')) {
                $event_date->setLockVersion($xml->lockVersion);
            }
            if ($this->isAttributeValid($xml, 'academicYear')) {
                $event_date->setAcademicYear($xml->academicYear);
            }
            if ($this->isAttributeValid($xml, 'compulsoryRequirement')) {
                $event_date->setCompulsoryRequirement($xml->compulsoryRequirement);
            }
            if ($this->isAttributeValid($xml, 'contents')) {
                $event_date->setContents($xml->contents);
            }
            if ($this->isAttributeValid($xml, 'courseAchievement')) {
                $event_date->setCourseAchievement($xml->courseAchievement);
            }
            if ($this->isAttributeValid($xml, 'credits')) {
                $event_date->setCredits($xml->credits);
            }
            if ($this->isAttributeValid($xml, 'examinationAchievement')) {
                $event_date->setExaminationAchievement($xml->examinationAchievement);
            }
            if ($this->isAttributeValid($xml, 'externOrganizer')) {
                $event_date->setExternOrganizer($xml->externOrganizer);
            }
            if ($this->isAttributeValid($xml, 'grading')) {
                $event_date->setGrading($xml->grading);
            }
            if ($this->isAttributeValid($xml, 'learningTarget')) {
                $event_date->setLearningTarget($xml->learningTarget);
            }
            if ($this->isAttributeValid($xml, 'literature')) {
                $event_date->setLiterature($xml->literature);
            }
            if ($this->isAttributeValid($xml, 'objectiveQualification')) {
                $event_date->setObjectiveQualification($xml->objectiveQualification);
            }
            if ($this->isAttributeValid($xml, 'planelementId')) {
                $event_date->setPlanElementId($xml->planelementId);
            }
            if ($this->isAttributeValid($xml, 'recommendedRequirement')) {
                $event_date->setRecommendedRequirement($xml->recommendedRequirement);
            }
            if ($this->isAttributeValid($xml, 'targetGroup')) {
                $event_date->setTargetGroup($xml->targetGroup);
            }
            if ($this->isAttributeValid($xml, 'teachingLanguageId')) {
                $event_date->setTeachingLanguageId($xml->teachingLanguageId);
            }
            if ($this->isAttributeValid($xml, 'teachingMethod')) {
                $event_date->setTeachingMethod($xml->teachingMethod);
            }
            if ($this->isAttributeValid($xml, 'workload')) {
                $event_date->setWorkload($xml->workload);
            }
            $planElement->appendEventDate($event_date);
        } else {
            $this->log->warning('No id given for EventDate, skipping!');
        }
    }
}
