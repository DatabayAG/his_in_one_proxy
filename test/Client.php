<?php

namespace HisInOneProxy\Soap;

use HisInOneProxy\Config;
use HisInOneProxy\DataModel\OrgUnit;
use HisInOneProxy\DataModel\PlanElement;
use HisInOneProxy\DataModel\Unit;
use HisInOneProxy\Log\Log;
use HisInOneProxy\REST\EcsCommunication;
use HisInOneProxy\Queue;
use HisInOneProxy\Soap;
use HisInOneProxy\REST\GuzzleWrapper;
use HisInOneProxy\System\ProcessHandling;
use \Monolog\Handler\StreamHandler;
use \Monolog\Formatter\LineFormatter;
use RuntimeException;
use HisInOneProxy\Soap\Interactions\DataCache;

require_once './libs/composer/vendor/autoload.php';

$log = new Log('debug');
$streamHandler = new StreamHandler('php://stdout', 'debug');
$output = "[%datetime%] %level_name%: %message%\n";
$formatter = new LineFormatter($output);
$streamHandler->setFormatter($formatter);
$log->getLogger()->pushHandler($streamHandler);

$service = new Soap\Interactions\Conductor(null, null, $log);
#$service->getCourseCatalog(2017,1);
$data = array (
	2523 => 2705,
	2705 => 2519,
	2519 => 2521,
	2520 => 1504,
	1380 => 1381,
	1378 => 2539,
	1376 => 2540,
	1374 => 1375,
	1370 => 1371,
	1372 => 1373,
	1368 => 3189,
	1366 => 2531,
	1364 => 2529,
	1362 => 2530,
	1356 => 2526,
	1358 => 3353,
	1360 => 6687,
	1354 => 2525,
	1352 => 2898,
	1504 => 1505,
	2522 => 2728,
	1430 => 1431,
	1428 => 1429,
	1426 => 1427,
	1424 => 1425,
	1422 => 5359,
	1420 => 1421,
	1418 => 1419,
	1416 => 1417,
	1414 => 1415,
	1412 => 1413,
	1410 => 1411,
	1406 => 1407,
	1408 => 1409,
	1404 => 1405,
	1402 => 1403,
	1400 => 1401,
	1396 => 1397,
	1398 => 1399,
	1394 => 5152,
	3155 => 3156,
	3156 => 3157,
	2728 => 2747,
	2521 => 1383,
	2717 => 2718,
	2718 => 2719,
	2719 => 3008,
	2720 => 2727,
	2725 => 2739,
	2726 => 2741,
	2727 => 2743,
	2721 => 2733,
	2729 => 2749,
	2730 => 2758,
	2731 => 2751,
	2732 => 2754,
	2733 => 2756,
	2899 => 2724,
	2722 => 2761,
	2760 => 2736,
	2737 => 2774,
	2736 => 2771,
	2761 => 2765,
	2764 => 2777,
	2765 => 2779,
	2723 => 2762,
	2759 => 2744,
	2734 => 2783,
	2735 => 2781,
	2762 => 2744,
	2766 => 2785,
	2767 => 2787,
	2724 => 2763,
	2763 => 2769,
	2768 => 2789,
	2769 => 2792,
	3131 => 3132,
	3132 => 3133,
	3133 => 3146,
	3134 => 3142,
	3147 => 1124,
	3135 => 3137,
	3138 => 3141,
	3142 => 3145,
	3146 => 3372,
	3371 => 3369,
	3372 => 3370,
	973 => 974,
	974 => 1040,
	975 => 6701,
	976 => 5306,
	983 => 986,
	987 => 993,
	994 => 997,
	998 => 1001,
	1002 => 1005,
	1006 => 1010,
	1011 => 1014,
	1015 => 1018,
	6701 => 1139,
	1040 => 1044,
	1334 => 1335,
	1335 => 1318,
	1110 => 1137,
	1111 => 5307,
	1115 => 1118,
	1119 => 1122,
	1123 => 1131,
	1132 => 1136,
	1137 => 1141,
	1318 => 1111,
	2801 => 3322,
	2802 => 2803,
	2803 => 3324,
	2804 => 1368,
	2805 => 2830,
	2807 => 2838,
	2808 => 2841,
	2809 => 2844,
	2816 => 2847,
	2810 => 2851,
	2817 => 2854,
	3329 => 5149,
	3331 => 3333,
	3326 => 3328,
	5360 => 5366,
	3324 => 3323,
	2826 => 3335,
	2815 => 2857,
	2814 => 2860,
	2813 => 2863,
	2812 => 2866,
	2811 => 2869,
	2831 => 2872,
	2832 => 2875,
	2833 => 2878,
	2834 => 2881,
	2835 => 2883,
	3335 => 3290,
	2827 => 3335,
	2829 => 2815,
	2828 => 2815,
	2830 => 2815,
	2806 => 2894,
	2887 => 2897,
	2819 => 5358,
	2818 => 3148,
	2820 => 2896,
	2897 => 2822,
	2888 => 3380,
	3379 => 3380,
	3380 => 3378,
);

/*$service = new PersonService($log, $router);
// person ids 2037, 1588, 924, 429, 1566, 2346
var_dump($service->readPerson(2184));
$service = new UnitService($log, $router);

var_dump($service->findUnit(1));
$service = new FacilityService($log, $router);
var_dump($service->readRoom( '2'));
var_dump($service->readRoom( '1'));

$service = new CourseInterfaceService($log, $router);
$services->getCourseInterfaceService()->getModulesForUnit($unit->getId());
var_dump($service->getCourseOfStudiesForUnit( '1'));
var_dump($service->readPersonExamPlanEnrollmentsForUnit( '1', '1', '2017'));
var_dump($service->readPersonExamPlanEnrollments( '2'));
$unit_list = $service->findUnit();
var_dump($service->readUnit(972));
//don't know the term_type_id
var_dump($service->getCombinationForCourse(972, 3, 2017));
//don't know the term_type_id
var_dump($service->readPlanElementsForUnit(972, 3, 2017));
//don't know the plan_element_id
var_dump($service->getPersonResponsibleForPlanElement(1, new PlanElement()));

$service = new CourseOfStudyService($log, $router);
var_dump($service->getCourseOfStudyById( '100387'));

$conductor = new Conductor();
$conductor->getCourseCatalog(2017, 'de');


$service = new ValueService($log, $router);
$term_types = $service->getAllTermTypes( 'de');
var_dump($term_types);

$service = new CourseInterfaceService($log, $router);

#foreach($unit_list->getUnitId() as $unit_id)
{
	#var_dump($service->readUnit($unit_id));
}
$container = $unit_list->getSizeOfContainer();
var_dump($container);

file_put_contents('/tmp/test.xml', $router->getSoapClientCourseInterfaceService()->__getLastRequest());
echo $unit_list->getSizeOfContainer();

$service = new StudentService($log, $router);
var_dump($service->readStudentWithCoursesOfStudyByStudentId(25));

$service = new OrgUnitService($log, $router);
var_dump($service->readOrgUnit(2));
$end_time = microtime(TRUE);
$log->info(sprintf('Queries took %s seconds.',round($end_time - $start_time, 4) ));
#file_put_contents('/tmp/test.xml', $router->getSoapClientCourseInterfaceService()->__getLastRequest());
$ulid = $service->getUniversityLid();
$start_time = microtime(TRUE);
$org_unit_root = $service->getOrgUnitWithChildren(2);
$service->printStructure($org_unit_root);*/

#var_dump($service->getEnrollments(1126, 1, 2017));
#var_dump($service->getEnrollments(1124, 1, 2017));
#var_dump($service->getEnrollments(1128, 1, 2017));
#$service->getLecture(2017, 1);
#$service->getCourseCatalog(2017, 1);
#$service->getParallelGroupValues();
#$service->getInstitutionsAndOrgUnits();
#$service->getEnrollments(2742, 1, 2017);
#$details = DataCache::getInstance()->readStudentDetailsToCache();
#var_dump($details);

#$crs = new CourseInterfaceService($log, DataCache::getInstance()->getRouter());
#var_dump($crs->readPersonExamPlanEnrollmentsForUnit(981, 1, 2017));


$test = new EcsCommunication(1);
#$test->getCoursesUrls();
$data	= file_get_contents('/var/gvollbach_data/gvollbach/public_html/spielwiese/1_simpleTools/q2.txt');
$data	= preg_split('/\n/', $data);
for($j=0; $j < 1; $j++)
{
	$c		= count($data);
	$r		= rand(0, $c);
	$a		= $data[$r];
	$i		= '876'.$j.time();
	$course	= json_decode('{
	"lang": "de_DE",
	"lectureID": "'.$i.'",
	"title": "'.$a.' Groupszenario 2",
	"abstract": "'.$a.' (Long)",
	"url": "",
	"courseType": "Vorlesung",
	"status": "online",
	"study_courses": [""],
	"courseID": "'.$i.'",
	"organisation": "Weiterbildungszentrum Databay",
	"organisationalUnits": [{
		"id": "194",
		"title": "Leistungselektronik und Elektrische Antriebe"
	}],
	"number": "'.$i.'",
	"term": "Winter 2016/17",
	"termID": "196",
	"lecturer" : "Jeff Jones",
	"lectureType": "Vorlesung",
	"hoursPerWeek": "12",
	"degreeProgrammes": [{
		"id": "233",
		"title": "'.$a.'",
		"courseUnitYearOfStudy": {
			"from": "",
			"to": ""
		}
	}],
	"allocations": [{
		"parentID": "233",
		"order": "1"
	}],
	"comment1": "",
	"recommendedReading": "",
	"prerequisites": "",
	"lectureAssessmentType": "",
	"targetAudiences": [
		""
	],
	"links": [{
		"title": "",
		"href": ""
	}],
	"groupScenario": 1,
	"groups": [{
			"id": "'.$i.'9821",
			"title": "Gruppe 1",
			"comment": "Comment 1",
			"maxParticipants" : 15
		}
	]
}');
	echo json_encode(json_encode($course));
	$test->publishCourseToEcs($course);

	$members	= json_decode('{
	"lectureID": "876015011640512",
	"members": [{
			"personID": "6435234232",
			"role": "0"
		},
		{
			"personID": "5432524363",
			"role": "1"
		},
		{
			"personID": "3545346",
			"role": "2"
		},
		{
			"personID": "4353453",
			"role": "1"
		},
		{
			"personID": "435234",
			"role": "1"
		},
		{
			"personID": "34523543",
			"role": "1"
		},
		{
			"personID": "234234524",
			"role": "1"
		},
		{
			"personID": "35243423",
			"role": "1"
		},
		{
			"personID": "432432",
			"role": "1"
		},
		{
			"personID": "52324324",
			"role": "1"
		},
		{
			"personID": "245435",
			"role": "1"
		}
	]
}');
	$queue = new Queue\SimpleQueue();
	$queue->push(Queue\QueueConstants::SERVICE_QUEUE, json_encode($members), Queue\QueueConstants::PUBLISH_MEMBERS_TO_ECS, '', time());
#	$queue = new Queue\SimpleQueue();
	#$queue->push(Queue\QueueConstants::MAINTENANCE_QUEUE, [], Queue\QueueConstants::CLEAN_UP_STALE_JOBS);

	for($t = 0; $t > 10000; $t ++)
	{
	#	
	}
		#$test->publishMembersToEcs($members);
	#$course = json_decode('{"lectureID":979,"title":"Einfchrung in die Zellbiologie","abstract":"Einffchrung in die Zellbiologie","url":"","groupScenario":2,"groups":null,"status":979,"courseID":979,"study_courses":979}');

	#$test->publishMembersToEcs($members);
	#$data = $service->getLecture(2017, 1);
	#$printer = new DataPrinter();
	#$courses = $printer->convertUnitsToJson($data);
	#foreach($courses as $course)
	{
		#$test->publishCourseToEcs($course);
		$a = 0;
	}

}

$course_catalog	= json_decode('{
	"rootID": "1",
	"directoryTreeTitle": "My super Title",
	"term": "SoSe 2017",
	"nodes": [{
			"id": "2908667875",
			"title": "First Node",
			"parent": [{
				"id": "1",
				"parent": "1"
			}]
		},
		{
			"id": "29086672875",
			"title": "Second Node",
			"parent": [{
				"id": "1",
				"parent": "1"
			}]
		}
	]
}');


#$arr = $service->getInstitutionsAndOrgUnits();
#$course_catalog = json_encode($arr);
#$test->publishCourseCatalogToEcs($course_catalog);

#'json' =>json_decode('{"lang":"de_DE", "Community":23,"id":"'.$id.'","etype":"application/course","title":"Kurs Community '.$id.'!","abstract":"","url":"","status":"online","study_courses":[""],"courseID":"'.$id.'"}')]);
#'json' =>json_decode('{"lang":"de_DE", "Community":23,"id":"399","etype":"application/course","title":"Einführung in die Zellbiologie 2","abstract":"Einführung in die Zellbiologie","url":"","status":"online","study_courses":[""],"courseID":"399"}')]);
#'json' =>json_decode('{"lang":"de_DE", "Community":23,"id":"'.$id.'","etype":"application/category","title":"Kurs Läuft2!","abstract":"","url":"","status":"online","study_courses":[""],"courseID":"'.$id.'"}')]);



#$test->getCoursesUrls();
#exec("/usr/bin/php src/Soap/HisHttpServer.php > /dev/null &");

#$ser = new HisHttpServerProcess();
#$ser->restartServer();

#$process = new ProcessHandling();
#$qu = new Queue\SimpleQueue();
#$qu->push(Queue\QueueConstants::SERVICE_QUEUE, json_encode(array()), Queue\QueueConstants::LECTURE_SERVICE);

#$queue = new Queue\QueueProcess();

#$queue->startQueueProcess();
#$queue = new Queue\QueueProcess();
#$queue->startQueueProcess();

$start_time = microtime(TRUE);
$con = new Conductor(null, null, $log);
#$con->getAllLecturesForThisTerm();
$end_time = microtime(TRUE);
$log->info(sprintf('Queries took %s seconds.',round($end_time - $start_time, 4) ));


#$service->getAllLecturesForThisTerm();
#$server2 = new Queue\QueueWatcher();
#$server2->run();

#Config\GlobalSettings::getInstance()->save();
/*$service = new CourseInterfaceService($log, DataCache::getInstance()->getRouter());
$unit = new Unit();
$unit->setId(3374);
var_dump($service->readPlanElementsForUnit($unit, 2, 2017));*/

$obj = json_decode('{"data":"{\"abstract\":\"Analysis\",\"allocations\":[],\"comment1\":null,\"courseID\":1124,\"degreeProgrammes\":[],\"groups\":[{\"id\":2233,\"title\":\"1. Parallelgruppe\",\"maxParticipants\":2,\"hours\":\"4.000000\",\"lectureres\":[{\"firstName\":\"holla\",\"lastName\":\"dieWaldFee\"}],\"datesAndVenues\":\"\"}],\"hoursPerWeek\":\"4.000000\",\"recommendedReading\":null,\"prerequisites\":null,\"lectureAssessmentType\":\"\",\"lectureID\":2233,\"number\":\"\",\"organisationalUnits\":[{\"id\":null,\"title\":null}],\"organisation\":\"\",\"status\":2001,\"study_courses\":1124,\"termID\":\"\",\"lectureType\":5,\"title\":\"Analysis\",\"targetAudiences\":[],\"url\":\"\",\"workload\":\"180 h\",\"term_type\":2,\"term\":2017,\"groupScenario\":2,\"elearning_sys_string\":\"7\"}","cmd":"publish_course_to_ecs","unix_time":0}');
$a = 0;
