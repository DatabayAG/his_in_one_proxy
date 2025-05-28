<?php

namespace HisInOneProxy\REST;

/**
 * Class EcsResources
 * @package HisInOneProxy\REST
 */
class EcsResources
{
    public function getCoursePath(): string
    {
        return $this->getPlainPath() . 'courses/';
    }

    public function getPlainPath(): string
    {
        return 'campusconnect/';
    }

    public function getCourseUrlPath(): string
    {
        return $this->getPlainPath() . 'course_urls/';
    }

    public function getMembersUrlPath(): string
    {
        return $this->getPlainPath() . 'course_members/';
    }

    public function getCourseCatalogUrlPath(): string
    {
        return $this->getPlainPath() . 'directory_trees/';
    }
}
