<?php

namespace HisInOneProxy\Soap\Interactions;

use HisInOneProxy\DataModel\Container\UnitIdList;
use HisInOneProxy\DataModel\Unit;
use HisInOneProxy\Log\Log;
use HisInOneProxy\Queue\QueueConstants;
use HisInOneProxy\Queue\SimpleQueue;
use HisInOneProxy\Soap\SoapServiceRouter;

/**
 * Class Conductor
 * @package HisInOneProxy\Soap\Interactions
 */
class Conductor
{

	/**
	 * @var Log
	 */
	protected $log;

	/**
	 * @var SoapServiceRouter
	 */
	protected $router;

	/**
	 * @var
	 */
	protected $course_of_studies;
	
	/**
	 * @var
	 */
	protected $course_of_studies_org;

	/**
	 * @var DataPrinter
	 */
	protected $data_printer;

	/**
	 * @var int
	 */
	protected $year;

	/**
	 * @var int
	 */
	protected $term_id;

	/**
	 * Conductor constructor.
	 * @param null $term
	 * @param null $year
	 * @param null $log
	 */
	public function __construct($term = null, $year = null, $log = null)
	{
		DataCache::getInstance();
		if($log == null)
		{
			$this->log = new Log();
		}
		else
		{
			$this->log = $log;
		}

		if($term == null || $year == null)
		{
			$term_value		= $this->getCurrentTerm();
			$this->term_id	= $term_value->getTermNumber();
			$this->year		= $term_value->getYear();
		}
		else
		{
			$this->term_id	= $term;
			$this->year		= $year;
		}
		DataCache::getInstance()->setLog($this->log);
		$this->course_of_studies = array();
		$this->course_of_studies_org = array();
		$this->data_printer = new DataPrinter();
	}

	/**
	 * @param $cos_lid
	 * @param $cos_already
	 * @return mixed
	 */
	protected function getCourseOfStudyDetails($cos_lid, $cos_already)
	{
		$course_of_study = DataCache::getInstance()->getCourseOfStudyService()->getCourseOfStudyById($cos_lid);
		if($course_of_study != null)
		{
			$this->course_of_studies_org[$course_of_study->getOrgUnitLid()] = $course_of_study;
			$this->course_of_studies[$course_of_study->getLid()]            = $course_of_study;
			$cos_already[$cos_lid]                                          = $cos_lid;
		}
		return $cos_already;
	}

	/**
	 * @return \HisInOneProxy\DataModel\CourseCatalogLeaf|null
	 */
	public function getCourseCatalog()
	{
		$year               = $this->year;
		$term_type_value_id = $this->term_id;
		$service = DataCache::getInstance()->getCourseCatalogService();
		$term_id = $service->getRootIdOfTerm($year, $term_type_value_id);

		if($term_id != null && $term_id != '')
		{
			$this->log->debug(sprintf('Found term id with value %s.', $term_id));
			$catalog_leaf = $service->getCourseCatalogLeaf($term_id);
			$this->data_printer->printCourseCatalog($catalog_leaf);

			$this->log->info($this->data_printer->depth . ' Max Depth.');
			if($catalog_leaf != null && $catalog_leaf->getId() != null )
			{
				$this->log->debug(sprintf('Found catalog leaf with id %s.', $catalog_leaf->getId()));
			}
			else
			{
				$this->log->warning(sprintf('No catalog leaf found for term id %s.', $term_id));
			}
		}
		else
		{
			$this->log->warning(sprintf('No term id found for year %s and term type value id.', $year, $term_type_value_id));
		}
		return $catalog_leaf;
	}

	public function getAllLecturesForThisTerm()
	{
		$services           = DataCache::getInstance();
		$cos_map            = $services->getCourseOfStudyService()->findCourseOfStudy();
		$cos_already        = array();

		$year               = $this->year;
		$term_type_value_id = $this->term_id;

		$unit_list = DataCache::getInstance()->getCourseInterfaceService()->findUnit($term_type_value_id, $year);

		if($unit_list != null && $unit_list->getSizeOfContainer() > 0)
		{
			$this->log->info(sprintf('Starting looking for all lectures in term id %s and year %s.',
				$term_type_value_id, $year));

			$units = $this->startHandlingUnitList($unit_list, $cos_map, $cos_already);
			$this->finishHandlingUnits($units);

			$this->log->info(sprintf('Unit relevant for export %s. Unit irrelevant for export %s', 
				$services->getRelevantForExport(), $services->getIrRelevantForExport()));
		}
		else
		{
			$this->log->warning(sprintf('No unit ids found for year %s and term type value id.', $year, $term_type_value_id));
		}
	}

	/**
	 * @param $unit_id
	 */
	public function getLectureByUnitIdForTerm($unit_id)
	{
		$services           = DataCache::getInstance();
		$cos_map            = $services->getCourseOfStudyService()->findCourseOfStudy();
		$cos_already        = array();

		$unit_list = new UnitIdList();
		$unit_list->appendUnitId($unit_id);

		$units = $this->startHandlingUnitList($unit_list, $cos_map, $cos_already);
		$this->finishHandlingUnits($units);
	}

	/**
	 * @param UnitIdList $unit_list
	 * @param $cos_map
	 * @param $cos_already
	 * @return array
	 */
	protected function startHandlingUnitList($unit_list, $cos_map, $cos_already)
	{
		$units = array();
		$year               = $this->year;
		$term_type_value_id = $this->term_id;

		foreach($unit_list->getUnitId() as $unit_id)
		{
			if(DataCache::getInstance()->getCourseInterfaceService()->doesCombinationForCourseExist($unit_id, $term_type_value_id, $year))
			{
				$unit = $this->gatherUnitDetails($unit_id, $cos_map, $cos_already);
				if($unit != null)
				{
					$units[] = $unit;
				}
			}
			else
			{
				DataCache::getInstance()->incrementIrrelevantForExport();
			}
		}

		return $units;
	}

	/**
	 * @param $unit_id
	 * @param $cos_map
	 * @param $cos_already
	 * @return Unit|null
	 */
	protected function gatherUnitDetails($unit_id, $cos_map, $cos_already)
	{
		$services	= DataCache::getInstance();
		$unit		= $services->getCourseInterfaceService()->readUnit($unit_id);
		$year               = $this->year;
		$term_type_value_id = $this->term_id;

		if($unit->getId() != null)
		{
			$services->getCourseInterfaceService()->getCombinationForCourse($unit, $term_type_value_id, $year);
			if($unit->getSizeOfCourseMappingContainer() >= 1 && $unit->getCourseMappingContainer()[0]->getELearningSystemId() != null)
			{
				$this->log->debug(sprintf('Read modules for unit %s.', $unit->getId()));

				$modules_list = $services->getCourseInterfaceService()->getModulesForUnit($unit->getId());
				if($modules_list != null && $modules_list->getSizeOfContainer() > 0)
				{
					$this->log->debug(sprintf('Found %s modules for unit %s.', $modules_list->getSizeOfContainer(), $unit->getId()));
					$this->readDetailsForOrgUnits($unit, $modules_list);
				}

				$this->readCourseOfStudyForUnit($unit, $cos_map, $cos_already);
				$this->readPlanElementsForUnit($unit);

				$services->incrementRelevantForExport();
			}
			return $unit;
		}
		return null;
	}

	/**
	 * @param Unit $unit
	 * @param UnitIdList $unit_id_list
	 */
	protected function readDetailsForOrgUnits($unit, $unit_id_list)
	{
		$org_units = array();
		foreach($unit_id_list->getUnitIdContainer() as $module_unit_id)
		{
			$module = DataCache::getInstance()->getCourseInterfaceService()->readUnit($module_unit_id);
			if($module->getId() != null)
			{
				$org_units[] = $this->getOrgUnitDetails($module);
			}
		}
	}

	/**
	 * @param Unit $unit
	 * @param $cos_map
	 * @param $cos_already
	 */
	protected function readCourseOfStudyForUnit($unit, $cos_map, $cos_already)
	{
		$this->log->debug(sprintf('Read course of study for unit id %s.', $unit->getId()));
		$this->getDetailOfCourseOfStudy($unit, $cos_map, $cos_already);
	}

	/**
	 * @param $unit
	 */
	protected function readPlanElementsForUnit($unit)
	{
		DataCache::getInstance()->getCourseInterfaceService()->readPlanElementsForUnit($unit, $this->term_id, $this->year);
	}

	/**
	 * @param Unit $module
	 * @return array
	 */
	protected function getOrgUnitDetails($module)
	{
		$services           = DataCache::getInstance();
		$this->log->debug(sprintf('Read details for module %s.', $module->getLid()));
		$org_units = array();
		if($module->getSizeOfOrgUnitContainer() > 0)
		{
			foreach($module->getOrgUnitsContainer() as $org_unit)
			{
				if(!array_key_exists($org_unit->getLid(), $org_units))
				{
					$org_units[$org_unit->getLid()] = $services->getOrgUnitService()->readOrgUnit($org_unit->getLid());
				}
			}
		}
		return $org_units;
	}

	/**
	 * @param Unit $unit
	 * @param $cos_map
	 * @param $cos_already
	 */
	protected function getDetailOfCourseOfStudy($unit, $cos_map, $cos_already)
	{
		$services	= DataCache::getInstance();

		if(!array_key_exists($unit->getId(), $this->course_of_studies))
		{
			$course_ids = $services->getCourseInterfaceService()->getCourseOfStudiesForUnit($unit->getId());
			foreach($course_ids->getCourseOfStudyIdContainer() as $course_id)
			{
				if(array_key_exists($course_id, $cos_map))
				{
					$cos_lid = $cos_map[$course_id];
					if(!array_key_exists($cos_lid, $cos_already))
					{
						$this->log->debug(sprintf('Read details for course of study %s.', $cos_lid));
						$cos_already = $this->getCourseOfStudyDetails($cos_lid, $cos_already);
					}
					else
					{
						$this->log->debug(sprintf('Course of study %s was already found.', $cos_lid));
					}
				}
				else
				{
					$this->log->warning(sprintf('Course of study with id %s was not found in map.', $course_id));
				}
			}
		}
	}

	/**
	 * @param $units
	 */
	protected function finishHandlingUnits($units)
	{
		DataCache::getInstance()->readPersonDetailsToCache();
		$this->data_printer->printUnits($units);
		$builder = new JsonBuilder();
		$courses = $builder::convertUnitsToArray($units);
		$queue   = new SimpleQueue();
		foreach($courses as $course)
		{
			$queue->push(QueueConstants::SERVICE_QUEUE, json_encode($course), QueueConstants::PUBLISH_COURSE_TO_ECS, $course->elearning_sys_string);
		}
		$persons = $builder::getPersonPlanElements();
		foreach($persons as $plan_element)
		{
			$e_learning_id = $builder->getElearningSystemStringFromPlanElementId($plan_element->lectureID);
			$queue->push(QueueConstants::SERVICE_QUEUE, json_encode($plan_element), QueueConstants::PUBLISH_MEMBERS_TO_ECS, $e_learning_id);
		}
	}

	/**
	 * @return bool
	 */
	public function getInstitutionsAndOrgUnits()
	{
		$org_unit_service = DataCache::getInstance()->getOrgUnitService();

		$lid = $org_unit_service->getUniversityLid();
		$org_unit_root = $org_unit_service->getOrgUnitWithChildren($lid);

		$this->data_printer->printOrgUnit($org_unit_root, $this->course_of_studies_org);
		$this->log->debug('Got institution structure submitting to ecs...');
		$builder = new JsonBuilder();
		$structure = $builder::convertOrgUnitsToJson($org_unit_root);

		$queue = new SimpleQueue();
		$queue->push(QueueConstants::SERVICE_QUEUE, json_encode($structure), QueueConstants::PUBLISH_COURSE_CATALOG_TO_ECS);

		$this->log->debug('...added institution structure to queue done.');

		return true;
	}

	protected function getParallelGroupValues()
	{
		#var_dump(DataCache::getInstance()->getParallelGroupValues());
		#var_dump(DataCache::getInstance()->getTermTypeList());
		var_dump(DataCache::getInstance()->getElearningPlatformContainer()->translateIdToDefaultText(12));
		var_dump(DataCache::getInstance()->getElearningPlatformContainer()->translateIdToDefaultText(7));
		var_dump(DataCache::getInstance()->getElearningPlatformContainer()->translateIdToDefaultText(8));
		var_dump(DataCache::getInstance()->getValueService()->getAllCourseMappingTypes(12));
		var_dump(DataCache::getInstance()->getCourseMappingTypeContainer()->translateIdToDefaultText(4));
	}

	/**
	 * @return \HisInOneProxy\DataModel\CurrentTerm|null
	 */
	protected function getCurrentTerm()
	{
		$term_service = DataCache::getInstance()->getTermService();
		return $term_service->getCurrentTerm();
	}

	/**
	 * @return int|null
	 */
	public function getTerm()
	{
		return $this->term_id;
	}

	/**
	 * @return int|null
	 */
	public function getYear()
	{
		return $this->year;
	}
}