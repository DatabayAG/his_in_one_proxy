<?php

namespace HisInOneProxy\Soap;

use Exception;
use HisInOneProxy\DataModel\Container\CourseCatalogElementIdList;
use HisInOneProxy\DataModel\CourseCatalogChild;
use HisInOneProxy\DataModel\CourseCatalogLeaf;
use HisInOneProxy\DataModel\VisibleChild;
use HisInOneProxy\Parser;
use HisInOneProxy\Soap\Interactions\DataCache;
use SoapFault;

/**
 * Class CourseCatalogService
 * @package HisInOneProxy\Soap
 */
class CourseCatalogService extends SoapService
{
    const COURSE_CATALOG = 'coursecatalog';

    const PLAN_ELEMENT = 'planelement';

    const UNIT = 'unit';

    protected $soap_client_course_catalog;

    /**
     * CourseCatalogService constructor.
     * @param                   $log
     * @param SoapServiceRouter $soap_service_router
     */
    public function __construct($log, $soap_service_router)
    {
        parent::__construct($log, $soap_service_router);
        $this->soap_client_course_catalog = $this->soap_service_router->getSoapClientCourseCatalog();
    }

    /**
     * @param $year
     * @param $term_type
     * @return int  | null
     */
    public function getRootIdOfTerm($year, $term_type)
    {
        $params = array(array('year' => $year, 'termTypeValueId' => $term_type));
        try {
            $response = $this->soap_client_course_catalog->__soapCall('getRootIdOfTerm', $params);
            $term_id  = $response->rootIdOfTerm;
            return $term_id;
        } catch (SoapFault $exception) {
            $this->log->error($exception->getMessage());
        }
        return null;
    }

    /**
     * @param $rootIdOfTerm
     * @return CourseCatalogLeaf|null
     * @throws Exception
     */
    public function getCourseCatalogLeaf($rootIdOfTerm)
    {
        $params = array(array('courseCatalogElementId' => $rootIdOfTerm));
        try {
            $response               = $this->soap_client_course_catalog->__soapCall('readCourseCatalogLeaf', $params);
            $parser                 = new Parser\ParseCourseCatalogLeaf($this->log);
            $catalog_leaf           = $parser->parse($response->courseCatalogLeaf);
            $course_catalog_element = $this->getChildren($catalog_leaf);
            return $course_catalog_element;
        } catch (SoapFault $exception) {
            $this->log->error($exception->getMessage());
        }
        return null;
    }

    /**
     * @param CourseCatalogLeaf $course_catalog_element
     * @return CourseCatalogLeaf | null
     * @throws Exception
     */
    public function getChildren($course_catalog_element)
    {
        $params = array(array('courseCatalogElementId' => $course_catalog_element->getId()));
        try {
            $response = $this->soap_client_course_catalog->__soapCall('readChildren', $params);
            $parser   = new Parser\ParseCourseCatalogChildren($this->log);
            $parser->parse($response->courseCatalogChildrenList, $course_catalog_element);
            $children = $course_catalog_element->getChildren();

            /** @var CourseCatalogChild $child */
            foreach ($children as $child) {
                if (strtolower($child->getType()) == self::COURSE_CATALOG) {
                    $course_catalog_element->replaceChildWithObject($child->getCourseCatalogId(),
                        $this->getCourseCatalogLeaf($child->getCourseCatalogId()));
                } else {
                    if (strtolower($child->getType()) == self::PLAN_ELEMENT) {
                        $course_catalog_element->replaceChildWithObject($child->getCourseCatalogId(),
                            DataCache::getInstance()->getCourseService()->getPlanElementById($child->getCourseCatalogId()));
                    } else {
                        if (strtolower($child->getType()) == self::UNIT) {
                            $course_catalog_element->replaceChildWithObject($child->getCourseCatalogId(),
                                $this->getUnitChildren($child->getCourseCatalogId()));

                            DataCache::getInstance()->getCourseService()->getAllPlanelementsOfUnit($child->getCourseCatalogId());
                        } else {
                            $this->log->warning(sprintf('No children found.'));
                        }
                    }
                }
            }
            return $course_catalog_element;
        } catch (SoapFault $exception) {
            $this->log->error($exception->getMessage());
        }
        return null;
    }

    /**
     * @param $courseCatalogElementId
     * @param $termTypeValueId
     * @param $year
     * @return VisibleChild[]  | null
     * @throws Exception
     */
    public function getUnitChildren($courseCatalogElementId, $termTypeValueId = 1, $year = 2017)
    {
        $params = array(array('courseCatalogElementId' => $courseCatalogElementId, 'termTypeValueId' => $termTypeValueId, 'year' => $year));
        try {
            $response = $this->soap_client_course_catalog->__soapCall('readUnitChildren', $params);
            $parser   = new Parser\ParseVisibleChildren($this->log);
            $children = $parser->parse($response);
            $units    = array();
            $service  = DataCache::getInstance()->getUnitService();

            if (is_array($children) && count($children) > 0) {
                foreach ($children as $id => $unit) {
                    $units[$id] = $service->readUnitWithChildren($id);
                }
            }
            return $units;
        } catch (SoapFault $exception) {
            $this->log->error($exception->getMessage());
        }
        return null;
    }

    /**
     * @param $plan_element_id
     * @return CourseCatalogElementIdList | null
     */
    public function getCourseCatalogElementIdsForPlanElement($plan_element_id)
    {
        $params = array(array('planelementId' => $plan_element_id));
        try {
            $response = $this->soap_client_course_catalog->__soapCall('getCourseCatalogElementIdsForPlanelement', $params);
            $parser   = new Parser\ParseCourseCatalogElementIdList($this->log);
            $children = $parser->parse($response);
            return $children;
        } catch (SoapFault $exception) {
            $this->log->error($exception->getMessage());
        }
        return null;
    }

}