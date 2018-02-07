<?php

namespace HisInOneProxy\DataModel;

use HisInOneProxy\DataModel\Container\ChildRelationContainer;
use HisInOneProxy\DataModel\Traits;
use HisInOneProxy\Exceptions;

/**
 * Class Unit
 * @package HisInOneProxy\DataModel
 */
class Unit
{
	use Traits\Comment, Traits\DefaultLanguage, Traits\Lid, Traits\LockVersion, Traits\ObjGuid, Traits\Text, Traits\Valid, Traits\Version;

	/**
	 * @var string
	 */
	protected $element_nr;

	/**
	 * @var int
	 */
	protected $element_type_id;

	/**
	 * @var int
	 */
	protected $status_id;

	/**
	 * @var int
	 */
	protected $event_type_id;

	/**
	 * @var Course[]
	 */
	protected $course_container = array();

	/**
	 * @var ElearningCourseMapping[]
	 */
	protected $course_mapping_container = array();

	/**
	 * @var OrgUnit[]
	 */
	protected $org_units_container = array();

	/**
	 * @var PlanElement[]
	 */
	protected $plan_elements_container = array();

	/**
	 * @var ChildRelationContainer
	 */
	protected $child_container;

	/**
	 * @return string
	 */
	public function getElementNr()
	{
		return $this->element_nr;
	}

	/**
	 * @param string $element_nr
	 */
	public function setElementNr($element_nr)
	{
		$this->element_nr = $element_nr;
	}

	/**
	 * @return int
	 */
	public function getElementTypeId()
	{
		return $this->element_type_id;
	}

	/**
	 * @param int $element_type_id
	 */
	public function setElementTypeId($element_type_id)
	{
		$this->element_type_id = (int) $element_type_id;
	}

	/**
	 * @return int
	 */
	public function getStatusId()
	{
		return $this->status_id;
	}

	/**
	 * @param int $status_id
	 */
	public function setStatusId($status_id)
	{
		$this->status_id = (int) $status_id;
	}

	/**
	 * @return Course[]
	 */
	public function getCourseContainer()
	{
		return $this->course_container;
	}

	/**
	 * @param Course $course
	 */
	public function appendCourse($course)
	{
		if(is_a($course, '\HisInOneProxy\DataModel\Course'))
		{
			$this->course_container[] = $course;
		}
		else
		{
			throw new Exceptions\InvalidCourse();
		}
	}

	/**
	 * @return OrgUnit[]
	 */
	public function getOrgUnitsContainer()
	{
		return $this->org_units_container;
	}

	/**
	 * @param $org_units
	 */
	public function setOrgUnitsContainer($org_units)
	{
		$this->org_units_container = $org_units;
	}

	/**
	 * @return OrgUnit[]
	 */
	public function getSizeOfOrgUnitContainer()
	{
		return count($this->org_units_container);
	}
	
	/**
	 * @param OrgUnit $org_unit
	 */
	public function appendOrgUnit($org_unit)
	{
		if(is_a($org_unit, '\HisInOneProxy\DataModel\OrgUnit'))
		{
			$this->org_units_container[] = $org_unit;
		}
		else
		{
			throw new Exceptions\InvalidOrgUnit();
		}
	}

	/**
	 * @return PlanElement[]
	 */
	public function getPlanElementContainer()
	{
		return $this->plan_elements_container;
	}

	/**
	 * @return PlanElement[]
	 */
	public function getSizeOfPlanElementContainer()
	{
		return count($this->plan_elements_container);
	}

	/**
	 * @param PlanElement $plan_element
	 */
	public function appendPlanElement($plan_element)
	{
		if(is_a($plan_element, '\HisInOneProxy\DataModel\PlanElement'))
		{
			$this->plan_elements_container[] = $plan_element;
		}
		else
		{
			throw new Exceptions\InvalidPlanElement();
		}
	}

	/**
	 * @return ElearningCourseMapping[]
	 */
	public function getCourseMappingContainer()
	{
		return $this->course_mapping_container;
	}

	/**
	 * @return int
	 */
	public function getSizeOfCourseMappingContainer()
	{
		return count($this->course_mapping_container);
	}

	/**
	 * @param ElearningCourseMapping[] $course_mapping_container
	 */
	public function appendCourseMappingContainer($course_mapping_container)
	{
		if(count($course_mapping_container) > 0)
		{
			$this->course_mapping_container = $course_mapping_container;
		}
	}

	/**
	 * @return ChildRelation[]
	 */
	public function getChildContainer()
	{
		if($this->child_container != null)
		{
			return $this->child_container->getChildRelationContainer();
		}
	}

	/**
	 * @param ChildRelationContainer $child_container
	 */
	public function setChildContainer($child_container)
	{
		$this->child_container = $child_container;
	}

	/**
	 * @param $id
	 * @param ChildRelation|Unit $child
	 */
	public function replaceChildInContainer($id, $child)
	{
		$this->child_container->replaceChildInContainer($id, $child);
	}

	/**
	 * @return int
	 */
	public function getEventTypeId()
	{
		return $this->event_type_id;
	}

	/**
	 * @param int $event_type_id
	 */
	public function setEventTypeId($event_type_id)
	{
		$this->event_type_id = $event_type_id;
	}

}
