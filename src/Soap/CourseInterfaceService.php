<?php

namespace HisInOneProxy\Soap;

use HisInOneProxy\DataModel\PlanElement;
use HisInOneProxy\DataModel\Unit;
use HisInOneProxy\Log;
use HisInOneProxy\Parser;
use HisInOneProxy\Soap\Interactions\DataCache;

/**
 * Class CourseInterfaceService
 * @package HisInOneProxy\Soap
 */
class CourseInterfaceService extends SoapService
{
	/**
	 * @var WSSoapClient|null
	 */
	protected $soap_course_interface;

	/**
	 * CourseCatalogService constructor.
	 * @param $log
	 * @param SoapServiceRouter $soap_service_router
	 */
	public function __construct($log, $soap_service_router)
	{
		parent::__construct($log, $soap_service_router);
		$this->soap_course_interface = $this->soap_service_router->getSoapClientCourseInterfaceService();
	}

	/**
	 * @param      $plan_element
	 * @param      $unit_id
	 * @param      $term_type_id
	 * @param      $year
	 * @param   $work_status_ids
	 * @param null $cancellation
	 * @param null $updated_since
	 */
	public function readPersonExamPlanEnrollmentsForUnit($plan_element, $unit_id, $term_type_id, $year, $work_status_ids = 8, $cancellation = null, $updated_since = null)
	{
		$params = array(array('unitId' => $unit_id, 'termTypeId' => $term_type_id, 'year' => $year, 'workstatusIds' => $work_status_ids, 'cancellation' => $cancellation, 'updatedSince' => $updated_since));
		try{
			$response	= $this->soap_course_interface->__soapCall('readPersonExamplanEnrollmentsForUnit', $params);
			$parser		= new Parser\ParseExamRelation($this->log);
			if(isset($response->examplans))
			{
				$parser->parse($response, $plan_element);
			}
		}
		catch(\SoapFault $exception)
		{
			$this->log->error($exception->getMessage());
		}
	}

	/**
	 * @param PlanElement $plan_element
	 * @param null $workstatus_ids
	 * @param null $cancellation
	 * @param null $updated_since
	 * @return \HisInOneProxy\DataModel\Container\ExamRelationContainer|null
	 */
	public function readPersonExamPlanEnrollments($plan_element, $workstatus_ids = null, $cancellation = null, $updated_since = null)
	{
		$params = array(array('planelementId' => $plan_element->getId(), 'workstatusIds' => $workstatus_ids, 'cancellation' => $cancellation, 'updatedSince' => $updated_since));
		try{
			$response	= $this->soap_course_interface->__soapCall('readPersonExamPlanEnrollments', $params);
			$parser		= new Parser\ParseExamRelation(new Log\Log());
			if(isset($response->examplans))
			{
				$parser->parse($response, $plan_element);
			}
		}
		catch(\SoapFault $exception)
		{
			$this->log->error($exception->getMessage());
		}
		return null;
	}

	/**
	 * @param null $term_type_id
	 * @param null $year
	 * @return \HisInOneProxy\DataModel\Container\UnitIdList|null
	 */
	public function findUnit($term_type_id = null, $year = null)
	{
		$params = array(array('termTypeValueId' => $term_type_id, 'termYear' => $year));
		try{
			$response		= $this->soap_course_interface->__soapCall('findUnit81', $params);
			$parser			= new Parser\ParseUnitIdList(new Log\Log());
			$exam_relation	= $parser->parse($response);
			return $exam_relation;
		}
		catch(\SoapFault $exception)
		{
			$this->log->error($exception->getMessage());
		}
		return null;
	}

	/**
	 * @param $unit_id
	 * @return Unit|null
	 */
	public function readUnit($unit_id)
	{
		$params = array(array('unitId' => $unit_id));
		try{
			$response	= $this->soap_course_interface->__soapCall('readUnit81', $params);
			$parser		= new Parser\ParseUnit(new Log\Log());
			if(isset($response->unit) && $response->unit != null && $response->unit != '')
			{
				$unit = $parser->parse($response->unit);
				return $unit;
			}
		}
		catch(\SoapFault $exception)
		{
			$this->log->error($exception->getMessage());
		}
		return null;
	}

	/**
	 * @param $unit_id
	 * @return \HisInOneProxy\DataModel\Container\UnitIdList|null
	 */
	public function getModulesForUnit($unit_id)
	{
		$params = array(array('unitId' => $unit_id));
		try{
			$response	= $this->soap_course_interface->__soapCall('getModulesForUnit', $params);
			$parser		= new Parser\ParseUnitIdList(new Log\Log());
			if(isset($response->unitIds) && $response->unitIds != null && $response->unitIds != '')
			{
				$unit_list = $parser->parse($response);
				return $unit_list;
			}
		}
		catch(\SoapFault $exception)
		{
			$this->log->error($exception->getMessage());
		}
		return null;
	}

	/**
	 * @param $unit_id
	 * @return \HisInOneProxy\DataModel\Container\CourseOfStudyIdList|null
	 */
	public function getCourseOfStudiesForUnit($unit_id)
	{
		$params = array(array('unitId' => $unit_id));
		try{
			$response					= $this->soap_course_interface->__soapCall('getCoursesOfStudiesForUnit', $params);
			$course_of_study_id			= new Parser\ParseCourseOfStudyIdList(new Log\Log());
			$course_of_study_id_list	= $course_of_study_id->parse($response);
			return $course_of_study_id_list;
		}
		catch(\SoapFault $exception)
		{
			$this->log->error($exception->getMessage());
		}
		return null;
	}

	/**
	 * @param Unit $unit
	 * @param $term_type_id
	 * @param $year
	 * @return null
	 */
	public function getCombinationForCourse($unit, $term_type_id, $year)
	{
		$params = array(array('unitId' => $unit->getId(), 'termTypeId' => $term_type_id, 'year' => $year));
		try{
			$response					= $this->soap_course_interface->__soapCall('getCombinationForCourse', $params);
			$course_of_study_id_list 	= new Parser\ParseElearningCourseMapping(new Log\Log());
			$course_mapping				= $course_of_study_id_list->parse($response);
			$unit->appendCourseMappingContainer($course_mapping);
		}
		catch(\SoapFault $exception)
		{
			$this->log->error($exception->getMessage());
		}
		return null;
	}

	/**
	 * @param $unit_id
	 * @param $plan_element
	 * @param $term_type_id
	 * @param $term_year
	 * @return null
	 */
	public function getPersonExternalForCourse($unit_id, $plan_element, $term_type_id, $term_year)
	{
		$params = array(array('unitId' => $unit_id, 'termTypeId' => $term_type_id, 'year' => $term_year));
		try{
			$response = $this->soap_course_interface->__soapCall('getPersonExternalForCourse', $params);
			$person_plan_elements	= new Parser\ParsePersonExternals($this->log);
			$person_plan_elements->parse($response, $plan_element);
			return $plan_element;
		}
		catch(\SoapFault $exception)
		{
			$this->log->error($exception->getMessage());
		}
		return null;
	}

	/**
	 * @param $unit_id
	 * @param $term_type_id
	 * @param $year
	 * @return bool
	 */
	public function doesCombinationForCourseExist($unit_id, $term_type_id, $year)
	{
		$params = array(array('unitId' => $unit_id, 'termTypeId' => $term_type_id, 'year' => $year));
		try{
			$response					= $this->soap_course_interface->__soapCall('getCombinationForCourse', $params);
			$course_of_study_id_list 	= new Parser\ParseElearningCourseMapping(new Log\Log());
			$course_mapping				= $course_of_study_id_list->parse($response);
			if(count($course_mapping) > 0)
			{
				return true;
			}
		}
		catch(\SoapFault $exception)
		{
			$this->log->error($exception->getMessage());
		}
		return false;
	}

	/**
	 * @param Unit $unit
	 * @param $term_type_id
	 * @param $term_year
	 * @return null
	 */
	public function readPlanElementsForUnit($unit, $term_type_id, $term_year)
	{
		$params = array(array('unitId' => $unit->getId(), 'termTypeId' => $term_type_id, 'termyear' => $term_year));
		try{
			$response					= $this->soap_course_interface->__soapCall('readPlanElementsForUnit', $params);
			$course_of_study_id_list	= new Parser\ParsePlanElements(new Log\Log());
			$plan_element_found			= $course_of_study_id_list->parse($response, $unit);
			var_dump($response);
			if($plan_element_found)
			{
				foreach($unit->getPlanElementContainer() as $plan_element)
				{
					//get a room
					
					$catalog_element_ids = DataCache::getInstance()->getCourseCatalogService()->getCourseCatalogElementIdsForPlanElement($plan_element->getId());
					$this->getPersonResponsibleForPlanElement($plan_element->getId(), $plan_element);
					$this->getPersonExternalForCourse($unit->getId(), $plan_element, $term_type_id, $term_year);
					$this->getPersonResponsibleForUnit($unit->getId(), $plan_element, $term_type_id, $term_year);
					$this->readPersonExamPlanEnrollmentsForUnit($plan_element, $unit->getId(), $term_type_id, $term_year);
				}

			}

			return $unit;
		}
		catch(\SoapFault $exception)
		{
			$this->log->error($exception->getMessage());
		}
		return null;
	}

	/**
	 * @param $plan_element_id
	 * @param $plan_element
	 * @return null
	 */
	public function getPersonResponsibleForPlanElement($plan_element_id, $plan_element)
	{
		$params = array(array('planelementId' => $plan_element_id));
		try{
			$response				= $this->soap_course_interface->__soapCall('getPersonResponsibleForPlanelement', $params);
			$person_plan_elements	= new Parser\ParsePersonPlanElement( $this->log);
			$person_plan_elements->parse($response, $plan_element);
			return $plan_element;
		}
		catch(\SoapFault $exception)
		{
			$this->log->error($exception->getMessage());
		}
		return null;
	}

	/**
	 * @param $unit_id
	 * @param $plan_element
	 * @param $term_type_id
	 * @param $term_year
	 * @return null
	 */
	public function getPersonResponsibleForUnit($unit_id, $plan_element, $term_type_id, $term_year)
	{
		$params = array(array('unitId' => $unit_id, 'termTypeId' => $term_type_id, 'year' => $term_year));
		try{
			$response				= $this->soap_course_interface->__soapCall('getPersonResponsibleForUnit', $params);
			$person_plan_elements	= new Parser\ParsePersonPlanElement($this->log);
			$person_plan_elements->parse($response, $plan_element);
			return $plan_element;
		}
		catch(\SoapFault $exception)
		{
			$this->log->error($exception->getMessage());
		}
		return null;
	}

	/**
	 * @param $unit_id
	 * @param $term_type_id
	 * @param $year
	 * @param $link_url
	 * @param $description
	 * @return bool|null
	 */
	public function addLinkToCourse($unit_id, $term_type_id, $year, $link_url, $description)
	{
		$params = array('unitId' => $unit_id, 'termTypeId' => $term_type_id, 'year' => $year, 'linkUrl' => $link_url, 'description' => $description);
		try{
			$this->soap_course_interface->__soapCall('addLinkToCourse', $params);
			return true;
		}
		catch(\SoapFault $exception)
		{
			$this->log->error($exception->getMessage());
		}
		return null;
	}

}