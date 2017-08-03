<?php

namespace HisInOneProxy\Soap\Interactions;

use HisInOneProxy\DataModel;
use HisInOneProxy\Log\Log;

class DataPrinter
{
	/**
	 * @var int
	 */
	public $units_counter = 0;

	/**
	 * @var int
	 */
	public $depth = 0;

	/**
	 * @var Log
	 */
	protected $log;

	/**
	 * DataPrinter constructor.
	 */
	public function __construct()
	{
		$this->log = DataCache::getInstance()->getLog();
	}
	
	/**
	 * @param DataModel\Unit[] $units
	 * @param int $level
	 */
	public function printUnits($units, $level = 0)
	{
		$tabs = $this->buildTabs($level);
		foreach($units as $unit)
		{
			$this->log->debug(sprintf($tabs . '|* Unit: %s, %s', $unit->getShortText(), $unit->getLongText()));
			$this->log->debug(sprintf($tabs . "\t|- %s, %s, %s, %s", $unit->getId(), $unit->getLid(), $unit->getStatusId(), $unit->getElementNr()));
			$this->printCourseMapping($unit->getCourseMappingContainer(), $level + 2);
			$this->printPlanElementContainer($unit->getPlanElementContainer(), $level + 2);
			$this->printOrgUnitForUnit($unit->getOrgUnitsContainer(), $level + 2);
		}
	}

	/**
	 * @param DataModel\PlanElement[] $plan_element_container
	 * @param $level
	 */
	public function printPlanElementContainer($plan_element_container, $level)
	{
		$tabs = $this->buildTabs($level);
		foreach($plan_element_container as $plan_element)
		{
			$this->log->debug(sprintf($tabs . '|* PlanElement: %s, %s, %s', $plan_element->getShortText(), $plan_element->getLongText(), $plan_element->getId()));
			$this->log->debug(sprintf($tabs ."\t|- ". 'Attendee Min: %s, Attendee Max:%s', $plan_element->getAttendeeMinimum(), $plan_element->getAttendeeMaximum()));
			$this->log->debug(sprintf($tabs ."\t|- ". 'Cancelled: %s, Credits:%s', $plan_element->getCancelled(), $plan_element->getCredits()));
			$this->log->debug(sprintf($tabs ."\t|- ". 'Hours: %s, ParallelGroupId:%s => %s', $plan_element->getHoursPerWeek(), $plan_element->getParallelGroupId(), DataCache::getInstance()
																																											 ->getParallelGroupValues()
																																											 ->getGroupValueById($plan_element->getParallelGroupId())
																																											 ->getLongText()));
			$this->printPersonPlanElementContainer($plan_element->getPersonPlanElementContainer(), $level + 1);
		}
	}

	/**
	 * @param DataModel\Container\ExamRelationContainer $exams_relation
	 * @param $level
	 */
	public function printExamRelation($exams_relation, $level)
	{
		$tabs = $this->buildTabs($level);
		foreach($exams_relation->getExamRelationContainer() as $exam_relation)
		{
			$this->log->debug(sprintf($tabs . '|* ExamRelation: %s, %s, %s', $exam_relation->getPersonId(), $exam_relation->getUnitId(), $exam_relation->getPlanElementId()));
			$this->log->debug(sprintf($tabs ."\t|- ". 'WorkStatus id: %s (%s), Cancellation: %s', $exam_relation->getWorkStatusId(), DataCache::getInstance()->getWorkStatus()->translateIdToDefaultText($exam_relation->getWorkStatusId()), (int) $exam_relation->getCancellation()));
		}
	}

	/**
	 * @param DataModel\PersonPlanElement[] | DataModel\ExamRelation $person_plan_element_container
	 * @param $level
	 */
	public function printPersonPlanElementContainer($person_plan_element_container, $level)
	{
		$tabs = $this->buildTabs($level);
		foreach($person_plan_element_container as $person)
		{
			$role = DataCache::STUDENT;
			if(is_a($person, 'HisInOneProxy\DataModel\PersonPlanElement'))
			{
				$role = DataCache::COURSE_ADMINISTRATOR;
			}
			$this->log->debug(sprintf($tabs . '|* Person: %s, %s, role: %s', $person->getPersonId(), $person->getPlanElementId(), $role));
			$per = DataCache::getInstance()->getPersonDetails($person->getPersonId());
			$this->log->debug(sprintf($tabs . "\t|* Person: %s, %s, %s", $per->getFirstName(), $per->getSurName(), $per->getTitleId()));
		}
	}

	/**
	 * @param DataModel\ElearningCourseMapping[] $course_mapping_container
	 * @param $level
	 */
	public function printCourseMapping($course_mapping_container, $level)
	{
		$tabs = $this->buildTabs($level);
		foreach($course_mapping_container as $courseMapping)
		{
			$this->log->debug(sprintf($tabs . '|* Mapping: eSystemId: %s (%s), MappingId: %s', 
															$courseMapping->getELearningSystemId(), 
															DataCache::getInstance()->getElearningPlatformContainer()->translateIdToDefaultText($courseMapping->getELearningSystemId()), 
															$courseMapping->getCourseMappingTypeId()));
		}
	}

	/**
	 * @param DataModel\OrgUnit $obj
	 * @param DataModel\CourseOfStudy $course_of_studies
	 * @param int $level
	 */
	public function printOrgUnit($obj, $course_of_studies, $level = 0)
	{
		$tabs = $this->buildTabs($level);
		if ($obj->getContainer() != null)
		{
			$level++;
			$this->printOrgUnitDetail($obj, $course_of_studies, $tabs);
			foreach ($obj->getContainer() as $x)
			{
				$this->printOrgUnit($x, $course_of_studies, $level);
			}
		}
	}

	/**
	 * @param     $obj
	 * @param int $level
	 */
	public function printOrgUnitForUnit($obj, $level = 0)
	{
		$tabs = $this->buildTabs($level);
		if (is_array($obj))
		{
			foreach($obj as $x)
			{
				$this->printOrgUnitDetailForUnit($x, $tabs);
			}
		}
		else
		{
			$this->printOrgUnitDetailForUnit($obj, $tabs);
		}
	}

	/**
	 * @param DataModel\CourseCatalogLeaf $leaf
	 * @param int $level
	 */
	public function printCourseCatalog($leaf, $level = 0)
	{
		$tabs = $this->buildTabs($level);
		if($leaf instanceof DataModel\CourseCatalogLeaf)
		{
			$children = $leaf->getChildren();
			if ($children != null)
			{
				$level++;
				$this->printCatalogDetail($leaf, $tabs);
				foreach ($children as $child)
				{
					$this->printCourseCatalog($child, $level);
				}
			}
			else
			{
				$this->printCatalogDetail($leaf, $tabs);
			}
		}
		else if(is_array($leaf) && count($leaf) > 0)
		{
			foreach($leaf as $obj)
			{
				if($obj instanceof DataModel\Unit)
				{
					$this->gatherMissingDetailFromCourseCatalog($obj);
					$this->printUnitDetailFromCourseCatalog2($obj, $obj->getId(), $level + 1);
				}
			}
		}
	}

	/**
	 * @param DataModel\CourseCatalogLeaf $leaf
	 * @param string $tabs
	 */
	public function printCatalogDetail($leaf, $tabs)
	{
		$this->log->debug($tabs . "|- " . $leaf->getTitle() . ' Id: (' . $leaf->getId() . ')');
	}

	/**
	 * @param DataModel\Unit $obj
	 */
	public function gatherMissingDetailFromCourseCatalog($obj)
	{

		$container = $obj->getChildContainer();
		if(count($container) > 0)
		{
			foreach($container as $child)
			{
				if($child instanceof DataModel\Unit)
				{
					$this->units_counter++;
					$this->gatherMissingDetailFromCourseCatalog($child);
				}
				else if(array_key_exists($child->getChildId(), DataCache::getInstance()->getUnitCache()))
				{
					$obj->replaceChildInContainer($child->getChildId(),  DataCache::getInstance()->getUnitCache()[$child->getChildId()]);
					$this->gatherMissingDetailFromCourseCatalog($obj);
				}
				else
				{
					$obj->replaceChildInContainer($child->getChildId(),  DataCache::getInstance()->getUnitService()->readUnitWithChildren($child->getChildId()));
					$this->gatherMissingDetailFromCourseCatalog($obj);
				}
			}
		}
	}

	/**
	 * @param DataModel\Unit $obj
	 * @param $parent
	 * @param $level
	 */
	public function printUnitDetailFromCourseCatalog2($obj, $parent,  $level)
	{
		$tabs = $this->buildTabs($level);
		$this->log->debug($tabs . "|- " . $obj->getDefaultText() . ' Lid: (' . $obj->getLid() . ') Id: (' . $obj->getId() . ') Type: ('.$obj->getElementTypeId().') Number: ('.$obj->getElementNr().') ValidFrom: ('.$obj->getValidFrom().') ValidTo: ('.$obj->getValidTo().')');

		$container = $obj->getChildContainer();
		if(count($container) > 0)
		{
			$level++;
			if($level > $this->depth)
			{
				$this->depth = $level;
			}
			foreach($container as $child)
			{
				if($child instanceof DataModel\Unit)
				{
					#$parent_id = DataCache::getInstance()->getParentForChild($child->getId());

					#if($parent_id == $parent || $parent_id == null)
					{
						$this->units_counter++;
						$this->printUnitDetailFromCourseCatalog2($child, $child->getId(), $level);
					}
				}
				else
				{
					$a = 'oh';
				}
			}
		}
	}


	/**
	 * @param DataModel\OrgUnit $obj
	 * @param array $course_of_studies
	 * @param $tabs
	 */
	public function printOrgUnitDetail($obj, $course_of_studies, $tabs)
	{
		$this->log->debug($tabs . "|- " . $obj->getDefaultText() . ' Lid: (' . $obj->getLid() . ') Id: (' . $obj->getId() . ') ParentId: (' . $obj->getParentId() . ")");

		if(array_key_exists($obj->getLid(), $course_of_studies))
		{
			$course_of_study = $course_of_studies[$obj->getLid()];
			$this->log->debug($tabs . "\t|* " . $course_of_study->getDefaultText() . ' Org-Lid: (' . $course_of_study->getOrgUnitLid() . ') Id: (' . $course_of_study->getId() . ')');
		}
		else
		{
			$this->log->debug($tabs . "\t|* " . $obj->getDefaultText() . ' Org-Lid: (' . $obj->getLid() . ') Id: (' . $obj->getId() . ')');
		}
	}

	/**
	 * @param DataModel\OrgUnit $obj
	 * @param $tabs
	 */
	public function printOrgUnitDetailForUnit($obj, $tabs)
	{
		$this->log->debug($tabs . "|- " . $obj->getDefaultText() . ' Org-Lid: (' . $obj->getLid() . ') Id: (' . $obj->getId() . ')');
	}

	/**
	 * @param int $level
	 * @return string
	 */
	public function buildTabs($level = 0)
	{
		return str_repeat("\t", $level);
	}
}