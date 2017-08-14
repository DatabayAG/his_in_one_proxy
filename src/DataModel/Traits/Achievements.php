<?php

namespace HisInOneProxy\DataModel\Traits;
/**
 * Trait Achievements
 * @package HisInOneProxy\DataModel\Traits
 */
trait Achievements
{

	/**
	 * @var string
	 */
	protected $course_achievement;

	/**
	 * @var string
	 */
	protected $examination_achievement;

	/**
	 * @return string
	 */
	public function getCourseAchievement()
	{
		return $this->course_achievement;
	}

	/**
	 * @param string $course_achievement
	 */
	public function setCourseAchievement($course_achievement)
	{
		$this->course_achievement = $course_achievement;
	}

	/**
	 * @return string
	 */
	public function getExaminationAchievement()
	{
		return $this->examination_achievement;
	}

	/**
	 * @param string $examination_achievement
	 */
	public function setExaminationAchievement($examination_achievement)
	{
		$this->examination_achievement = $examination_achievement;
	}

}