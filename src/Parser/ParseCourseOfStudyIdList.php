<?php

namespace HisInOneProxy\Parser;

use HisInOneProxy\DataModel\Container\CourseOfStudyIdList;

/**
 * Class ParseCourseOfStudyIdList
 * @package HisInOneProxy\Parser
 */
class ParseCourseOfStudyIdList extends SimpleXmlParser
{
    /**
     * @param $xml
     * @return CourseOfStudyIdList
     */
    public function parse($xml)
    {
        $course_of_study_ids = new CourseOfStudyIdList();
        if ($this->isAttributeValid($xml, 'courseOfStudyLids')) {
            if (isset($xml->courseOfStudyLids->courseOfStudyLid) && is_array($xml->courseOfStudyLids->courseOfStudyLid)) {
                foreach ($xml->courseOfStudyLids->courseOfStudyLid as $value) {
                    if (isset($value) && $value != null && $value != '') {
                        $course_of_study_ids->appendCourseOfStudyId($value);
                        $this->log->info(sprintf('Found course of study id %s.', $value));
                    } else {
                        $this->log->warning('No id given for for course of study, skipping!');
                    }
                }
            } else {
                if (isset($xml->courseOfStudyLids->courseOfStudyLid)) {
                    $course_of_study_ids->appendCourseOfStudyId($xml->courseOfStudyLids->courseOfStudyLid);
                }
            }
        }

        return $course_of_study_ids;
    }
}