<?php

namespace HisInOneProxy\DataModel;


use HisInOneProxy\System\Utils;

class HisToEcsIdMapping
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
			foreach($config as $his_id => $ecs_id)
			{
				self::$mapping[$his_id] = $ecs_id;
			}
		}
	}

	/**
	 * @param $his_id
	 * @param $ecs_id
	 */
	public function appendMapping($his_id, $ecs_id)
	{
		self::$mapping["$his_id"] = $ecs_id;
	}

	/**
	 * @param $his_id
	 * @return mixed
	 */
	public static function getEcsIdFromHisId($his_id)
	{
		if(array_key_exists($his_id, self::$mapping))
		{
			return self::$mapping["$his_id"];
		}
		else
		{
			Utils::LogToShellAndExit(sprintf('The given HisId %s is not known, please ensure you update your his_id to ecs_id mapping.', $his_id));
		}
	}
}