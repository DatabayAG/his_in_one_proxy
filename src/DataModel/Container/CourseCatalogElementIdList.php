<?php

namespace HisInOneProxy\DataModel\Container;

/**
 * Class CourseCatalogElementIdList
 * @package HisInOneProxy\DataModel\Container
 */
class CourseCatalogElementIdList
{
    /**
     * @var array
     */
    protected $course_catalog_element_id_container = array();

    /**
     * @param $course_catalog_element_id
     */
    public function appendCourseCatalogElementId($course_catalog_element_id)
    {
        $course_catalog_element_id = (int) $course_catalog_element_id;
        if (!in_array($course_catalog_element_id, $this->getCourseCatalogElementIdContainer())) {
            $this->course_catalog_element_id_container[] = $course_catalog_element_id;
        }
    }

    /**
     * @return array
     */
    public function getCourseCatalogElementIdContainer()
    {
        return $this->course_catalog_element_id_container;
    }

    /**
     * @return int
     */
    public function getSizeOfContainer()
    {
        return count($this->course_catalog_element_id_container);
    }
}
