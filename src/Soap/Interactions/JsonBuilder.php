<?php

namespace HisInOneProxy\Soap\Interactions;

use HisInOneProxy\Config\GlobalSettings;
use HisInOneProxy\DataModel\CourseCatalogChild;
use HisInOneProxy\DataModel\CourseCatalogLeaf;
use HisInOneProxy\DataModel\ElearningCourseMapping;
use HisInOneProxy\DataModel\ExamRelation;
use HisInOneProxy\DataModel\HisToEcsCourseIdMapping;
use HisInOneProxy\DataModel\OrgUnit;
use HisInOneProxy\DataModel\PersonPlanElement;
use HisInOneProxy\DataModel\PlanElement;
use HisInOneProxy\DataModel\Unit;

/**
 * Class JsonBuilder
 * @package HisInOneProxy\Soap\Interactions
 */
class JsonBuilder
{
	/**
	 * @var array
	 */
	protected static $person_plan_elements = array();

	/**
	 * @var array
	 */
	public static $mapping_e_learning_id_to_lecture_id = array();

	/**
	 * @var array 
	 */
	protected static $course_user_groups_map = array();

	/**
	 * @param Unit[] $units
	 * @return array
	 */
	public static function convertUnitsToArray($units)
	{
		$array = array();

		foreach($units as $unit)
		{
			$plan_element_id = self::getPlanElementId($unit);

			/**
			 * @var Unit $unit
			 */
			$mapping					= $unit->getCourseMappingContainer();
			$row						= new \stdClass();
			$course_container 			= $unit->getCourseContainer();
			if(count($course_container) > 0)
			{
				$course					= $course_container[0];
				$row->workload			= $course->getWorkload();
			}

			$row->lectureID				= $course->getId();
			$row						= self::appendMapping($mapping, $row);
			self::addMappingToArray($course->getId(), $row->elearning_sys_string);
			self::addSimpleTypes($row, $unit);
			self::addComplexTypes($row, $unit, $course->getId());

			$array[] = $row;
		}

		return $array;
	}

	/**
	 * @param Unit $unit
	 * @return string
	 */
	protected static function getPlanElementId($unit)
	{
		$plan_element_id = $unit->getPlanElementContainer();
		if(array_key_exists(0, $plan_element_id))
		{
			$plan_element_id = $plan_element_id[0]->getId();
		}
		else
		{
			$plan_element_id = $unit->getLid();
		}
		return (string) $plan_element_id;
	}

	/**
	 * @param $row
	 * @param Unit $unit
	 */
	protected static function addSimpleTypes($row, $unit)
	{
		$row->abstract				= $unit->getLongText();
		$row->comment1				= $unit->getComment();
		$row->courseID				= $unit->getLid();
		$row->lectureAssessmentType	= '';
		$row->number				= '';
		$row->organisation			= '';
		$row->status				= $unit->getStatusId();
		$row->study_courses			= $unit->getLid();
		$row->termID				= '';
		$row->lectureType			= $unit->getElementTypeId();
		$plan_element_cont 			= $unit->getPlanElementContainer();
		if(count($plan_element_cont) == 1)
		{
			$row->title				= $plan_element_cont[0]->getDefaultText();
		}
		else
		{
			$row->title				= $unit->getDefaultText();
		}
		$row->url					= '';
	}

	/**
	 * @param $row
	 * @param Unit $unit
	 * @param $course_id
	 */
	protected static function addComplexTypes($row, $unit, $course_id)
	{
		$row->allocations			= self::addAllocations($unit);
		$row->degreeProgrammes		= self::addDegreeProgrammes($unit);
		$row->organisationalUnits	= self::addOrgUnits($unit->getOrgUnitsContainer());
		$row->targetAudiences		= self::addTargetAudience($unit);
		self::appendGroups($unit, $row, $course_id);
		self::buildMembers();
	}

	/**
	 * 
	 */
	public static function buildMembers()
	{
		$skip			= false;
		$element		= null;

		foreach(self::$course_user_groups_map as $course_id => $course)
		{
			$person_element  = null;
			foreach($course as $user_name => $user)
			{
				$element         = new \stdClass();
				$person          = new \stdClass();
				$group_container = array();

				foreach($user as $group_id => $group)
				{
					if(in_array($group['blocked'], GlobalSettings::getInstance()->getBlockedIds()))
					{
						DataCache::getInstance()->getLog()->debug(sprintf('Account with name (%s) will be ignored, since it is not active, blocked id(%s)!', $account->getUserName(), $account->getBlockedId()));
						$skip = true;
						continue;
					}
					$user = current($user);
					$person->personID     = $user_name . GlobalSettings::getInstance()->getLoginSuffix();
					$person->personIDtype = GlobalSettings::getInstance()->getPersonIdType();
					$person->role		  = $user['role'];
					$group_element        = new \stdClass();
					$group_element->id    = $group_id;
					$group_element->role  = $group['role'];
					$group_container[]    = $group_element;
				}
				$person->groups   = $group_container;
				if( ! $skip)
				{
					$person_element[] = $person;
				}
			}

			if($course_id !== null && $person_element !== null)
			{
				$element->lectureID = $course_id;
				$element->members	= $person_element;
			}

			if($element !== null)
			{
				self::$person_plan_elements[$course_id] = $element;
			}
		}

	$a= 0;
	}
	
	/**
	 * @param $plan_element_id
	 * @param $e_learning_sys_string
	 */
	protected static function addMappingToArray($plan_element_id, $e_learning_sys_string)
	{
		$plan_element_id = (string) $plan_element_id;
		if( ! array_key_exists($plan_element_id, self::$mapping_e_learning_id_to_lecture_id))
		{
			self::$mapping_e_learning_id_to_lecture_id[$plan_element_id] = $e_learning_sys_string;
		}
	}

	/**
	 * @param $plan_element_id
	 * @return string
	 */
	public static function getElearningSystemStringFromPlanElementId($plan_element_id)
	{
		$plan_element_id = (string) $plan_element_id;
		if(array_key_exists($plan_element_id, self::$mapping_e_learning_id_to_lecture_id))
		{
			return self::$mapping_e_learning_id_to_lecture_id[$plan_element_id];
		}
		DataCache::getInstance()->getLog()->error(sprintf('No e-learning system found for plan element id (%s), this should not be possible.', $plan_element_id));
		return '';
	}

	/**
	 * @param ElearningCourseMapping[] $mapping
	 * @param $row
	 * @return mixed
	 */
	protected static function appendMapping($mapping, $row)
	{
		$row->elearning_sys_string = '';
		if(count($mapping) > 0)
		{
			$row->term_type		= $mapping[0]->getTermTypeValueId();
			$row->term			= $mapping[0]->getYear();
			$row->groupScenario	= HisToEcsCourseIdMapping::getEcsCourseIdFromCourseHisId($mapping[0]->getCourseMappingTypeId());

			foreach($mapping as $map)
			{
				if($row->elearning_sys_string != '')
				{
					$row->elearning_sys_string .= ',';
				}
				$row->elearning_sys_string .= $map->getELearningSystemId();
			}
			
		}
		return $row;
	}

	/**
	 * @param Unit $unit
	 * @param $row
	 * @param $course_id
	 * @return mixed
	 */
	protected static function appendGroups($unit, $row, $course_id)
	{
		$row->groups  = array();
		$collection  = array();
		$plan_element = $unit->getPlanElementContainer();

		foreach($plan_element as $element)
		{
			$group					= new \stdClass();
			$group->id				= $element->getId();
			$group->title			= DataCache::getInstance()
												->getParallelGroupValues()
												->getGroupValueById($element->getParallelGroupId())
												->getLongText();
			$group->maxParticipants = $element->getAttendeeMaximum();
			$group->hours			= $element->getHoursPerWeek();
			$lecturer				= new \stdClass();
			#$lecturer->firstName	= 'holla';
			#$lecturer->lastName	= 'dieWaldFee';
			$group->lectureres		= array($lecturer);
			$group->datesAndVenues	= '';
			$row->groups[]			= $group;
			$row->hoursPerWeek		= $element->getHoursPerWeek();
			$row->recommendedReading= $element->getLiterature();
			$row->prerequisites		= $element->getRecommendedRequirement();
			self::analysePersonContainer($element, $unit->getId(), $course_id);
		}
		return $row;
	}

	/**
	 * @param $plan_element PlanElement
	 * @param $unit_id
	 * @param $course_id
	 */
	protected static function analysePersonContainer($plan_element, $unit_id, $course_id)
	{
		$lecture = null;
		foreach($plan_element->getPersonPlanElementContainer() as $element)
		{
			$accounts = DataCache::getInstance()->getAccountsForPersonId($element->getPersonId());

			if(count($accounts) > 0)
			{
				/**
				 * @var \HisInOneProxy\DataModel\CompleteAccount $account
				 */
				foreach($accounts as $account)
				{

					$person				= new \stdClass();
					$role				= DataCache::STUDENT;
					if(is_a($element, 'HisInOneProxy\DataModel\PersonPlanElement') || is_a($element, 'HisInOneProxy\DataModel\PersonExternals'))
					{
						$role = DataCache::COURSE_ADMINISTRATOR;
					}
					$person->role		= $role;

					$usr_name = $account->getUserName() . GlobalSettings::getInstance()->getLoginSuffix();
					self::$course_user_groups_map[$course_id][$usr_name][$element->getPlanElementId()] = array('role' => $role, 'blocked' => $account->getBlockedId());
				}
			}
		}
	}

	/**
	 * @param OrgUnit[] $container
	 * @return array
	 */
	protected static function addOrgUnits($container)
	{
		$org_units = array();
		foreach($container as $org)
		{
			$org_unit			= new \stdClass();
			$org_unit->id		= $org->getLid();
			$org_unit->title	= $org->getDefaultText();
			$org_units[]		= $org_unit;
		}
		return $org_units;
	}

	/**
	 * @param $container
	 * @return array
	 */
	protected static function addLinks($container)
	{
		$links = array();
		foreach($container as $lin)
		{
			$link			= new \stdClass();
			$link->title	= '';
			$link->href		= '';
			$links[] = $link;
		}
		return $links;
	}

	/**
	 * @param $container
	 * @return array
	 */
	protected static function addTargetAudience($container)
	{
		$audience = array();
		foreach($container as $aud)
		{
			$org_units[] = $aud;
		}
		return $audience;
	}

	/**
	 * @param $container
	 * @return array
	 */
	protected static function addAllocations($container)
	{
		$allocations = array();
		foreach($container as $loc)
		{
			$allocation				= new \stdClass();
			$allocation->parentID	= '';
			$allocation->order		= '';
			$allocations[] = $allocation;
		}
		return $allocations;
	}

	/**
	 * @param $container
	 * @return array
	 */
	protected static function addDegreeProgrammes($container)
	{
		$programs = array();
		foreach($container as $prog)
		{
			$program						= new \stdClass();
			$program->id					= '';
			$program->title					= '';
			$program->courseUnitYearOfStudy = '';
			$program->from					= '';
			$program->to					= '';
			$programs[] = $program;
		}
		return $programs;
	}

	/**
	 * @return array
	 */
	public static function getPersonPlanElements()
	{
		return self::$person_plan_elements;
	}

	/**
	 * 
	 */
	public static function resetPersonPlanElement()
	{
		self::$person_plan_elements = array();
	}

	/**
	 * @param CourseCatalogLeaf $course_catalog
	 * @return array
	 */
	public static function convertCourseCatalogToArray($course_catalog)
	{

		$array = array();

		$row						= new \stdClass();
		$row->rootID				= $course_catalog->getId();
		$row->directoryTreeTitle	= $course_catalog->getTitle();
		$row->term					= '';
		$row->nodes					= self::appendNodes($course_catalog);
		$array[] = $row;
		return $array;
	}

	/**
	 * @param CourseCatalogLeaf | CourseCatalogChild $leaf
	 * @return array
	 */
	protected static function appendNodes($leaf)
	{
		$nodes = array();
		if(is_a($leaf, 'HisInOneProxy\DataModel\CourseCatalogLeaf'))
		{
			$children = $leaf->getChildren();
			foreach($children as $n)
			{
				if($n != null)
				{
					/** @var CourseCatalogChild $n */
					$node			= new \stdClass();
					$node->id		= $n->getCourseCatalogId();
					$node->title	= $n->getType();
					$node->nodes	= array();
					$node->nodes[]	= self::appendNodes($n);
					$nodes[] = $node;
				}
			}
		}
		return $nodes;
	}

	/**
	 * @param OrgUnit $org_unit
	 * @return array
	 */
	public static function convertOrgUnitsToJson($org_unit)
	{

		$array = array();
		$row						= new \stdClass();
		$row->rootID				= $org_unit->getId();
		$row->directoryTreeTitle	= $org_unit->getLongText();
		$row->parent				= '';
		$row->term					= '';
		$row->nodes					= self::recursiveAppendOrgUnits($org_unit, $org_unit->getId());
		$array[] = $row;
		return $array;
	}

	/**
	 * @param OrgUnit $org_unit
	 * @param $parent_id
	 * @return array
	 */
	protected static function recursiveAppendOrgUnits($org_unit, $parent_id)
	{
		$nodes = array();
		$children = $org_unit->getContainer();
		foreach($children as $n)
		{
			if($n != null)
			{
				/** @var OrgUnit $n */
				$node			= new \stdClass();
				$node->id		= $n->getId();
				$node->title	= $n->getLongText();
				$node->parent	= $parent_id;
				$node->nodes	= array();
				$node->nodes[]	= self::recursiveAppendOrgUnits($n, $n->getId());
				$nodes[] = $node;
			}
		}
		return $nodes;
	}
}