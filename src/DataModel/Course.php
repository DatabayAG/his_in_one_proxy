<?php

namespace HisInOneProxy\DataModel;

use HisInOneProxy\DataModel\Traits;

/**
 * Class Course
 * @package HisInOneProxy\DataModel
 */
class Course
{
    use Traits\AcademicYear, Traits\Achievements, Traits\CompulsoryRequirement, Traits\Contents, Traits\Credits, Traits\ExternOrganizer,
        Traits\Grading, Traits\Literature, Traits\LearningTarget, Traits\LockVersion, Traits\ObjectiveQualification,
        Traits\ObjGuid, Traits\RecommendedRequirement, Traits\TargetGroup, Traits\TeachingMethod, Traits\UnitId, Traits\Workload;

    /**
     * @var string
     */
    protected $class_attendance;

    /**
     * @var string
     */
    protected $directive;

    /**
     * @var int
     */
    protected $event_type_id;

    /**
     * @var int
     */
    protected $frequency_of_offer_value_id;

    /**
     * @var string
     */
    protected $independent_study;

    /**
     * @var string
     */
    protected $intended_semester;

    /**
     * @var string
     */
    protected $recommendation;

    /**
     * @var int
     */
    protected $scheduled_group_size;

    /**
     * @var int
     */
    protected $teaching_k_language_id;

    /**
     * @return string
     */
    public function getClassAttendance()
    {
        return $this->class_attendance;
    }

    /**
     * @param string $class_attendance
     */
    public function setClassAttendance($class_attendance)
    {
        $this->class_attendance = $class_attendance;
    }

    /**
     * @return string
     */
    public function getDirective()
    {
        return $this->directive;
    }

    /**
     * @param string $directive
     */
    public function setDirective($directive)
    {
        $this->directive = $directive;
    }

    /**
     * @return int
     */
    public function getEventTypeId()
    {
        return $this->event_type_id;
    }

    /**
     * @param int $event_type_id
     */
    public function setEventTypeId($event_type_id)
    {
        $this->event_type_id = $event_type_id;
    }

    /**
     * @return int
     */
    public function getFrequencyOfOfferValueId()
    {
        return $this->frequency_of_offer_value_id;
    }

    /**
     * @param int $frequency_of_offer_value_id
     */
    public function setFrequencyOfOfferValueId($frequency_of_offer_value_id)
    {
        $this->frequency_of_offer_value_id = $frequency_of_offer_value_id;
    }

    /**
     * @return string
     */
    public function getIndependentStudy()
    {
        return $this->independent_study;
    }

    /**
     * @param string $independent_study
     */
    public function setIndependentStudy($independent_study)
    {
        $this->independent_study = $independent_study;
    }

    /**
     * @return string
     */
    public function getIntendedSemester()
    {
        return $this->intended_semester;
    }

    /**
     * @param string $intended_semester
     */
    public function setIntendedSemester($intended_semester)
    {
        $this->intended_semester = $intended_semester;
    }

    /**
     * @return string
     */
    public function getRecommendation()
    {
        return $this->recommendation;
    }

    /**
     * @param string $recommendation
     */
    public function setRecommendation($recommendation)
    {
        $this->recommendation = $recommendation;
    }

    /**
     * @return int
     */
    public function getScheduledGroupSize()
    {
        return $this->scheduled_group_size;
    }

    /**
     * @param int $scheduled_group_size
     */
    public function setScheduledGroupSize($scheduled_group_size)
    {
        $this->scheduled_group_size = $scheduled_group_size;
    }

    /**
     * @return int
     */
    public function getTeachingKLanguageId()
    {
        return $this->teaching_k_language_id;
    }

    /**
     * @param int $teaching_k_language_id
     */
    public function setTeachingKLanguageId($teaching_k_language_id)
    {
        $this->teaching_k_language_id = $teaching_k_language_id;
    }

}
