<?php

namespace HisInOneProxy\Queue;

/**
 * Class QueueConstants
 * @package HisInOneProxy\Queue
 */
class QueueConstants
{

    const HIS_EVENTS = 'his_events';

    const INSTITUTION_ORG_SERVICE = 'get_institutions_and_org_units';

    const PUBLISH_MEMBERS_TO_ECS = 'publish_members_to_ecs';

    const PUBLISH_COURSE_TO_ECS = 'publish_course_to_ecs';

    const PUBLISH_COURSE_CATALOG_TO_ECS = 'publish_course_catalog_to_ecs';

    const CLEAN_UP_STALE_JOBS = 'clean_up_stale_jobs';

    const LECTURE_SERVICE = 'get_all_lectures_for_this_term';

    const SERVICE_QUEUE = 'service_queue';

    const MAINTENANCE_QUEUE = 'maintenance_queue';

}