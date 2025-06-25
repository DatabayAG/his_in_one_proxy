<?php

namespace HisInOneProxy\EcsLocal\Routes;
require_once '../../../libs/composer/vendor/autoload.php';

use HisInOneProxy\Config\GlobalSettings;
use HisInOneProxy\EcsLocal\EcsLocalFunctions;
use HisInOneProxy\Log\Log;
use HisInOneProxy\Queue\QueueConstants;
use HisInOneProxy\Queue\QueueDatabase;
use HisInOneProxy\Soap\Interactions\DataCache;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;

const HEADER_AUTH_ID = 'X-EcsAuthId';
const HEADER_PASSWORD = 'X-EcsPassword';
const HEADER_ECS_RECEIVER_MEMBERSHIPS = 'X-EcsReceiverMemberships';
const SLASH = '/';
const SYS = 'sys';
const EVENTS = 'events';
const FIFO = 'fifo';
const MEMBERSHIPS = 'memberships';
const CAMPUS_CONNECT = 'campusconnect';
const COURSES = 'courses';
const ORGANISATION = 'organisation_units';
const TERMS = 'terms';
const COURSE_MEMBERS = 'course_members';
const DIRECTORY_TREES = 'directory_trees';
const COURSE_LINKS = 'courselinks';
const COURSE_URLS = 'course_urls';
const ID_PARAM = '[/{id}]';
const JSON_CONTENT_TYPE = 'application/json';
const SYS_EVENTS = SLASH . SYS . SLASH . EVENTS;
const SYS_EVENTS_FIFO = SYS_EVENTS . SLASH . FIFO;
const SYS_MEMBERSHIPS = SLASH . SYS . SLASH . MEMBERSHIPS;
const CC = SLASH . CAMPUS_CONNECT . SLASH;
const CC_COURSES = CC . COURSES . ID_PARAM;
const CC_ORG = CC . ORGANISATION . ID_PARAM;
const CC_COURSE_MEMBERS = CC . COURSE_MEMBERS . ID_PARAM;
const CC_TERMS = CC . TERMS . ID_PARAM;
const CC_DIRECTORY_TREES = CC . DIRECTORY_TREES . ID_PARAM;
const CC_COURSE_LINKS = CC . COURSE_LINKS . ID_PARAM;
const CC_COURSE_URLS = CC . COURSE_URLS ;

$app = AppFactory::create();
$app->addErrorMiddleware(true, true, true);
$app->addBodyParsingMiddleware();
$logging = new Log();
$db = new QueueDatabase();
$local_functions = new EcsLocalFunctions();

$app->get(SLASH, function (Request $request, Response $response) use ($logging, $local_functions) {
    if($local_functions->isValidParticipant()->isInvalidAuth()) {
        return $response;
    }

    $response->getBody()->write('Nothing to see here.');

    return $response;
});

$app->get(SYS_EVENTS_FIFO, function (Request $request, Response $response) use ($db, $logging, $local_functions)  {
    $valid_participant = $local_functions->isValidParticipant();
    if($valid_participant->isInvalidAuth()) {
        return $response;
    }

    $value = [];
    $data = $db->pop(QueueConstants::SERVICE_QUEUE);
    if(sizeof($data) > 0) {
        foreach ($data as $row) {
            if (isset($row['service_id']) && $row['service_id'] > 0 && isset($row['cmd'])) {
                $value[] = $local_functions->convertEventsFifoData($row);
            }
        }

        $json = json_encode($value, JSON_PRETTY_PRINT);
        $response->getBody()->write(print_r($json, true));
        $logging->info(sprintf('Transmitted fifo event with following data: "status" => %s, "ressource" => %s',
            $value[0]['status'] ?? '', $value[0]['ressource'] ?? ''));
    }

    return $response;
});

$app->post(SYS_EVENTS_FIFO, function (Request $request, Response $response) use ($db, $logging, $local_functions)  {
    if($local_functions->isValidParticipant()->isInvalidAuth()) {
        return $response;
    }

    $data = $db->pop(QueueConstants::SERVICE_QUEUE);
    foreach($data as $row) {
        if(isset($row['service_id'])) {
            $service_id = $row['service_id'];
            $db->updateSentField($service_id);
        }
    }

    return $response;
});

$app->get(SYS_MEMBERSHIPS, function (Request $request, Response $response) use ($db, $logging, $local_functions)  {
    $valid_participant = $local_functions->isValidParticipant();
    if($valid_participant->isInvalidAuth()) {
        return $response;
    }

    $memberships_json = json_encode($local_functions->getMemberships($valid_participant));
    $response->getBody()->write($memberships_json);

    return $response;
});

$app->get('/campusconnect/courses/{id}/details', function (Request $request, Response $response, $args) use ($db, $logging, $local_functions)  {
    $valid_participant = $local_functions->isValidParticipant();
    if($valid_participant->isInvalidAuth()) {
        return $response;
    }

    $courseId = (int) $args['id'];
    $payload = $local_functions->getPayloadForCourses($valid_participant, $courseId);
    $memberships_json = json_encode($payload);
    $response->getBody()->write($memberships_json);
    $logging->info(sprintf('Sent message details for %s', CC_COURSES . '/details'));

    return $response;
});

$app->get(CC_COURSES, function (Request $request, Response $response, array $args) use ($db, $logging, $local_functions)  {
    if($local_functions->isValidParticipant()->isInvalidAuth()) {
        return $response;
    }

    $courseId = $args['id'];
    $data = $db->select($courseId);
    $json = json_encode($data, JSON_PRETTY_PRINT);
    $response->getBody()->write($json);

    return $response;
});

$app->get('/campusconnect/course_members/{id}/details', function (Request $request, Response $response, array $args) use ($db, $logging, $local_functions)  {
    $valid_participant = $local_functions->isValidParticipant();
    if($valid_participant->isInvalidAuth()) {
        return $response;
    }

    $courseId = (int) $args['id'];
    $payload = $local_functions->getPayloadForCourseMembers($valid_participant, $courseId);
    $json = json_encode($payload, JSON_PRETTY_PRINT);
    $response->getBody()->write($json);
    $logging->info(sprintf('Sent message details for %s', '/campusconnect/course_members/{id}/details'));

    return $response;
});

$app->get('/campusconnect/course_members/{id}', function (Request $request, Response $response, array $args) use ($db, $logging, $local_functions)  {
    if($local_functions->isValidParticipant()->isInvalidAuth()) {
        return $response;
    }

    $membersId = $args['id'];
    if($membersId > 0) {
        $data = $db->select($membersId);
    } else {
        $data = [];
    }
    $json = json_encode($data, JSON_PRETTY_PRINT);
    $response->getBody()->write($json);

    return $response;
});

$app->get('/campusconnect/categories', function (Request $request, Response $response) {
    return $response;
});

$app->get('/campusconnect/categories/{id}/details', function (Request $request, Response $response) {
    return $response;
});

$app->get(CC_COURSE_LINKS, function (Request $request, Response $response, array $args) use ($db, $logging, $local_functions)  {
    if($local_functions->isValidParticipant()->isInvalidAuth()) {
        return $response;
    }

    $a = [[]];
    $json = json_encode($a, JSON_PRETTY_PRINT);
    $response->getBody()->write($json);

    return $response;
});

$app->post(CC_COURSE_URLS, function (Request $request, Response $response, array $args) use ($db, $logging, $local_functions) {
    if($local_functions->isValidParticipant()->isInvalidAuth()) {
        return $response;
    }
    if(GlobalSettings::getInstance()->isCreateLinks()) {
        $post = $request->getParsedBody();
        if(is_array($post)) {
            $course_urls = $local_functions->parseCourseUrls($post);
            $lectureId = $course_urls->getCmsLectureId() ?: '';
            $ecs_course_url = $course_urls->getEcsCourseUrl() ?: '';
            $lms_course_urls = $course_urls->getLmsCourseUrls();
            $first_found_url = reset($lms_course_urls);
            $term_type_id = GlobalSettings::getInstance()->getActualTermId();
            $term_year = GlobalSettings::getInstance()->getActualTermYear();

            if($lectureId !== '') {
                $db->insertLink($lectureId, $term_type_id, $term_year, $first_found_url->getTitle(), $first_found_url->getUrl(), $ecs_course_url, $logging);
            }

        } else {
            $logging->warning('This does not seem to be a valid course urls array');
        }
    }

    return $response;
});
$app->run();
