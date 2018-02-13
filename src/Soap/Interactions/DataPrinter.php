<?php

namespace HisInOneProxy\Soap\Interactions;

use HisInOneProxy\Config\GlobalSettings;
use HisInOneProxy\DataModel;
use HisInOneProxy\Log\Log;

/**
 * Class DataPrinter
 * @package HisInOneProxy\Soap\Interactions
 */
class DataPrinter
{

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
			$this->log->debug(sprintf($tabs . '|* Unit: %s, %s', $unit->getDefaultText(), $unit->getLongText()));
			$this->log->debug(sprintf($tabs . "\t|- %s, %s, %s, %s", $unit->getId(), $unit->getLid(), $unit->getStatusId(), $unit->getElementNr()));
			$this->printPlanElementContainer($unit->getPlanElementContainer(), $unit,$level + 2);
			$this->printOrgUnitForUnit($unit->getOrgUnitsContainer(), $level + 2);
		}
	}

	/**
	 * @param DataModel\PlanElement[] $plan_element_container
	 * @param DataModel\Unit $unit
	 * @param $level
	 */
	public function printPlanElementContainer($plan_element_container, $unit, $level)
	{
		$tabs = $this->buildTabs($level);
		foreach($plan_element_container as $plan_element)
		{
			$this->printCourseMapping($unit->getCourseMappingContainer(), $level);
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
			if(is_a($person, 'HisInOneProxy\DataModel\PersonPlanElement') || is_a($person, 'HisInOneProxy\DataModel\PersonExternals'))
			{
				$role = DataCache::COURSE_ADMINISTRATOR;
			}
			$this->log->debug(sprintf($tabs . '|* Person: %s, %s, role: %s', $person->getPersonId(), $person->getPlanElementId(), $role));
			$per = DataCache::getInstance()->getPersonDetails($person->getPersonId());
			$this->log->debug(sprintf($tabs . "\t|* Person: %s, %s, %s", $per->getFirstName(), $per->getSurName(), $per->getTitleId()));
			$this->printPersonAccounts(DataCache::getInstance()->getAccountsForPersonId($person->getPersonId()), $level + 2);
			$this->printPersonEAddress($per->getEAddresses(), $level + 3);
		}
	}

	/**
	 * @param DataModel\Person $person
	 * @param $level
	 */
	public function printPerson($person, $level)
	{
		if($person instanceof DataModel\Person)
		{
			$tabs = $this->buildTabs($level);
			$per = DataCache::getInstance()->getPersonDetails($person->getId());
			$this->log->debug(sprintf($tabs . "\t|* Person: %s, %s, %s", $per->getFirstName(), $per->getSurName(), $per->getTitleId()));
			$this->printPersonAccounts(DataCache::getInstance()->getAccountsForPersonId($person->getId()), $level + 2);
			$this->printPersonEAddress($per->getEAddresses(), $level + 3);
		}
	}

	/**
	 * @param DataModel\Person[] $persons
	 * @param $level
	 */
	public function printMultiplePersons($persons, $level)
	{
		foreach($persons as $person)
		{
			$this->printPerson($person, $level);
		}
	}

	/**
	 * @param array $ea_list
	 * @param $level
	 */
	public function printPersonEAddress($ea_list, $level)
	{
		$tabs = $this->buildTabs($level);
		if(is_array($ea_list))
		{
			foreach($ea_list as $ea)
			{
				/** @var $ea DataModel\ElectronicAddress */
				$this->log->debug(sprintf($tabs . '|* eAddress: Id (%s), objGuid (%s), SortOrder (%s), AddressType (%s), AddressTypeReadable (%s), Address (%s)',
					$ea->getid(),
					$ea->getObjGuid(),
					$ea->getSortOrder(),
					$ea->getEAddressTypeId(),
					DataCache::getInstance()->resolveEAddressTypeById($ea->getEAddressTypeId()),
					$ea->getEAddress()
				));
			}
		}
	}

	/**
	 * @param array $account_list
	 * @param $level
	 */
	public function printPersonAccounts($account_list, $level)
	{
		$tabs = $this->buildTabs($level);
		if(is_array($account_list))
		{
			foreach($account_list as $account)
			{
				/** @var $account DataModel\CompleteAccount */
				$this->log->debug(sprintf($tabs . '|* Account: Id (%s), PersonId (%s), Username (%s), BlockedId(%s), Ldap (%s), AuthId (%s), AuthInfo (%s), ExternalId (%s)',
					$account->getid(),
					$account->getPersonId(),
					$account->getUserName() . GlobalSettings::getInstance()->getLoginSuffix(),
					$account->getBlockedId(),
					$account->isLdapAccount(),
					$account->getAccountAuthId(),
					$account->getAuthInfo(),
					$account->getExternalSystemId(),
					$account->getPurposeId(),
					DataCache::getInstance()->resolvePurposeTypeById($account->getPurposeId())
				));

				if(in_array($account->getBlockedId(), GlobalSettings::getInstance()->getBlockedIds()))
				{
					$this->log->debug(sprintf($tabs . "\n" . '|* Account will be ignored, since it is not active!'));
				}

				$this->log->debug(sprintf($tabs . "\n" . '|* Purpose: %s (%s)',
					DataCache::getInstance()->resolvePurposeTypeById($account->getPurposeId()),
					$account->getPurposeId()
				));
			}
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
															DataModel\HisToEcsCourseIdMapping::getEcsCourseIdFromCourseHisId($courseMapping->getCourseMappingTypeId())));
		}
	}

	/**
	 * @param DataModel\OrgUnit $obj
	 * @param DataModel\CourseOfStudy | array $course_of_studies
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
	 * @param DataModel\CourseCatalogLeaf | DataModel\CourseCatalogChild $leaf
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
	 * @param array | DataModel\CourseOfStudy $course_of_studies
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
		if(is_a($obj, 'HisInOneProxy\DataModel\OrgUnitListItem'))
		{
			$obj = DataCache::getInstance()->resolveOrgUnitByLid($obj->getLid());
		}
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