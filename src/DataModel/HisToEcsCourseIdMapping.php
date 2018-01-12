<?php

namespace HisInOneProxy\DataModel;

class HisToEcsCourseIdMapping
{

	/**
	 * @var array
	 */
	protected static $mapping = array();

	/**
	 * HisToEcsIdMapping constructor.
	 * @param $config
	 */
	public function __construct($config)
	{
		$this->readMapping($config);
	}

	/**
	 * @param $config
	 */
	protected function readMapping($config)
	{
		if(is_array($config) && count($config) > 0)
		{
			foreach($config as $his_course_id => $ecs_course_id)
			{
				self::$mapping[$his_course_id] = $ecs_course_id;
			}
		}
	}

	/**
	 * @param $his_course_id
	 * @param $ecs_course_id
	 */
	public function appendMapping($his_course_id, $ecs_course_id)
	{
		self::$mapping["$his_course_id"] = $ecs_course_id;
	}

	/**
	 * @param $his_course_id
	 * @return string
	 */
	public static function getEcsCourseIdFromCourseHisId($his_course_id)
	{
		if(array_key_exists($his_course_id, self::$mapping))
		{
			return self::$mapping[$his_course_id];
		}
		else
		{
			return 0;
		}
	}

}