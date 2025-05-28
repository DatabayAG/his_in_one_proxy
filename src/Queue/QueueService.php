<?php

namespace HisInOneProxy\Queue;

use Exception;
use GuzzleHttp\Exception\GuzzleException;
use HisInOneProxy\EcsLocal\EcsCommunicationLocal;
use HisInOneProxy\REST\EcsCommunication;
use HisInOneProxy\Soap\Interactions\Conductor;
use HisInOneProxy\Soap\Interactions\DataCache;

/**
 * Class QueueService
 * @package HisInOneProxy\Queue
 */
class QueueService
{

    protected Conductor $service;
    private static bool $use_local_ecs = false;

    public static function doesFunctionExists(string $string) : bool
    {
        return method_exists(__CLASS__, $string);
    }

    /**
     * @throws Exception
     */
    public static function get_institutions_and_org_units(string $json = null, $receiver = null) : bool
    {
        $service = new Conductor(null, null, DataCache::getInstance()->getLog());
        if ($service->getInstitutionsAndOrgUnits()) {
            return true;
        }
        return false;
    }

    /**
     * @throws GuzzleException
     */
    public static function publish_course_to_ecs(string $json, $receiver) : bool
    {
        if(self::$use_local_ecs) {
            $ecs = new EcsCommunicationLocal($receiver);
            if ($ecs->publishCourseToEcs(json_decode($json))) {
                return true;
            }
        } else {
            $ecs = new EcsCommunication($receiver);
            if ($ecs->publishCourseToEcs(json_decode($json))) {
                return true;
            }
        }

        //Todo: change this
        return true;
        return false;
    }

    /**
     * @throws GuzzleException
     */
    public static function publish_members_to_ecs(string $json, $receiver) : bool
    {
        if(self::$use_local_ecs) {
            $ecs = new EcsCommunicationLocal($receiver);
            if ($ecs->publishMembersToEcs(json_decode($json))) {
                return true;
            }
        } else {
            $ecs = new EcsCommunication($receiver);
            if ($ecs->publishMembersToEcs(json_decode($json))) {
                return true;
            }
        }

        return false;
    }

    /**
     * @throws GuzzleException
     */
    public static function publish_course_catalog_to_ecs(string $json, $receiver) : bool
    {
        if(self::$use_local_ecs) {
            $ecs = new EcsCommunicationLocal($receiver);
            if ($ecs->publishCourseCatalogToEcs(json_decode($json))) {
                return true;
            }
        } else {
            $ecs = new EcsCommunication($receiver);
            if ($ecs->publishCourseCatalogToEcs(json_decode($json))) {
                return true;
            }
        }

        return false;
    }

    public static function clean_up_stale_jobs(?string $json = null, $receiver = null) : bool
    {
        $queue = new QueueBase();
        $queue->cleanUpStaleJobs();
        return true;
    }

    /**
     * @throws Exception
     */
    public static function get_all_lectures_for_this_term(?string $json = null, $receiver = null) : bool
    {
        $conductor = new Conductor();
        $conductor->getAllLecturesForThisTerm();
        return true;
    }

    public static function setUseLocalEcs(bool $use_local_ecs): void
    {
        self::$use_local_ecs = $use_local_ecs;
    }

}
