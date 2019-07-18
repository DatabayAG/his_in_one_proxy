<?php

namespace HisInOneProxy\DataModel\Container;

use Generator;

/**
 * Class CourseOfStudyIdList
 * @package HisInOneProxy\DataModel\Container
 */
class CourseOfStudyIdList
{
    /**
     * @var array
     */
    protected $course_of_study_id_container = array();

    /**
     * @param int $course_of_study_id
     */
    public function appendCourseOfStudyId($course_of_study_id)
    {
        $course_of_study_id = (int) $course_of_study_id;
        if (!in_array($course_of_study_id, $this->getCourseOfStudyIdContainer())) {
            $this->course_of_study_id_container[] = $course_of_study_id;
        }
    }

    /**
     * @return array
     */
    public function getCourseOfStudyIdContainer()
    {
        return $this->course_of_study_id_container;
    }

    /**
     * @return int
     */
    public function getSizeOfContainer()
    {
        return count($this->course_of_study_id_container);
    }

    /**
     * @return Generator
     */
    public function getCourseOfStudyId()
    {
        foreach ($this->course_of_study_id_container as $course_of_study_id) {
            yield $course_of_study_id;
        }
    }
}