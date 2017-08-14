<?php

namespace HisInOneProxy\Queue;

use HisInOneProxy\REST\EcsCommunication;
use HisInOneProxy\Soap\Interactions\Conductor;
use HisInOneProxy\Soap\Interactions\DataCache;

/**
 * Class QueueService
 * @package HisInOneProxy\Queue
 */
class QueueService
{

	/**
	 * @var Conductor
	 */
	protected $service;

	/**
	 * @param $string
	 * @return bool
	 */
	public static function doesFunctionExists($string)
	{
		return method_exists(__CLASS__, $string);
	}

	/**
	 * @param null $json
	 * @param null $receiver
	 * @return bool
	 */
	public static function get_institutions_and_org_units($json = null, $receiver = null)
	{
		$service = new Conductor(DataCache::getInstance()->getLog());
		if($service->getInstitutionsAndOrgUnits())
		{
			return true;
		}
		return false;
	}

	/**
	 * @param $json
	 * @param $receiver
	 * @return bool
	 */
	public static function publish_course_to_ecs($json, $receiver)
	{
		$ecs = new EcsCommunication($receiver);
		if($ecs->publishCourseToEcs(json_decode($json)))
		{
			return true;
		}
		return false;
	}

	/**
	 * @param $json
	 * @param $receiver
	 * @return bool
	 */
	public static function publish_members_to_ecs($json, $receiver)
	{
		$ecs = new EcsCommunication($receiver);
		if($ecs->publishMembersToEcs(json_decode($json)))
		{
			return true;
		}
		return false;
	}

	/**
	 * @param $json
	 * @param $receiver
	 * @return bool
	 */
	public static function publish_course_catalog_to_ecs($json, $receiver)
	{
		$ecs = new EcsCommunication($receiver);
		if($ecs->publishCourseCatalogToEcs(json_decode($json)))
		{
			return true;
		}
		return false;
	}

	/**
	 * @param null $json
	 * @param null $receiver
	 * @return bool
	 */
	public static function clean_up_stale_jobs($json = null, $receiver = null)
	{
		$queue = new SimpleQueue();
		$queue->cleanUpStaleJobs();
		return true;
	}

	/**
	 * @param null $json
	 * @param null $receiver
	 * @return bool
	 */
	public static function get_all_lectures_for_this_term($json = null, $receiver = null)
	{
		$conductor = new Conductor();
		$conductor->getAllLecturesForThisTerm();
		return true;
	}
}