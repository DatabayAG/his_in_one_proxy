<?php

namespace HisInOneProxy\EcsLocal\Data;

class CourseUrls
{
    protected string $cms_lecture_id = '';
    protected string $ecs_course_url = '';

    /** @var array[CourseUrl] */
    protected array $lms_course_urls = [];

    public function __construct(string $cms_lecture_id, string $ecs_course_url, array $lms_course_urls)
    {
        $this->cms_lecture_id = $cms_lecture_id;
        $this->ecs_course_url = $ecs_course_url;
        $this->lms_course_urls = $this->parseLmsCourseUrlsArray($lms_course_urls);
    }

    private function parseLmsCourseUrlsArray(array $lms_course_urls): array {
        $course_urls = [];
        if(count($lms_course_urls) > 0) {
            foreach($lms_course_urls as $entry) {
                $title = '';
                $url = '';
                foreach($entry as $key => $value) {
                    if($key === 'title') {
                        $title = $value;
                    }
                    if($key === 'url') {
                        $url = $value;
                    }
                    if($title !== '' && $url !== '') {
                        $course_urls[] = new CourseUrl($title, $url);
                    }
                }
            }
        }
        return $course_urls;
    }

    public function getCmsLectureId(): string
    {
        return $this->cms_lecture_id;
    }

    public function getEcsCourseUrl(): string
    {
        return $this->ecs_course_url;
    }

    public function getLmsCourseUrls(): array
    {
        return $this->lms_course_urls;
    }
}
