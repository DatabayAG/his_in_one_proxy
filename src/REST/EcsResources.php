<?php

namespace HisInOneProxy\REST;

/**
 * Class EcsResources
 * @package HisInOneProxy\REST
 */
class EcsResources
{
    /**
     * @return string
     */
    public function getCoursePath()
    {
        return $this->getPlainPath() . 'courses/';
    }

    /**
     * @return string
     */
    public function getPlainPath()
    {
        return 'campusconnect/';
    }

    /**
     * @return string
     */
    public function getCourseUrlPath()
    {
        return $this->getPlainPath() . 'course_urls/';
    }

    /**
     * @return string
     */
    public function getMembersUrlPath()
    {
        return $this->getPlainPath() . 'course_members/';
    }

    /**
     * @return string
     */
    public function getCourseCatalogUrlPath()
    {
        return $this->getPlainPath() . 'directory_trees/';
    }
}