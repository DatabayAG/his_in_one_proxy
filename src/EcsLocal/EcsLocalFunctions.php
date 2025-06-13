<?php

namespace HisInOneProxy\EcsLocal;

use HisInOneProxy\Config\GlobalSettings;
use HisInOneProxy\EcsLocal\Data\CourseUrls;
use HisInOneProxy\Queue\QueueConstants;
use HisInOneProxy\Queue\QueueDatabase;
use HisInOneProxy\Soap\Interactions\DataCache;
use HisInOneProxy\System\Utils;
use const HisInOneProxy\EcsLocal\Routes\JSON_CONTENT_TYPE;

class EcsLocalFunctions
{
    const PARTICIPANTS = '../../../participants.json';
    const PID = 'pid';
    const MID = 'mid';
    const ITS_YOU = 'itsyou';
    private ?array $participants = null;
    private EcsAuth $valid_participant;
    private array $id_list = [];

    public function getMemberships(EcsAuth $valid_participant) : array {
        $this->valid_participant = $valid_participant;
        $participants = $this->readParticipants($valid_participant);

        return [
                [
                    "community" => [
                        "name" => "ECS light campus connection",
                        "description" => "ECS light campus connection small community",
                        "cid" => (int) GlobalSettings::getInstance()->getEcsCommunityId()
                    ],
                    "participants" => $participants
                ]
            ];
    }

    public function convertEventsFifoData(array $event) : array {
        $value = [];
        if(isset($event['service_id'])) {
            $service_id = $event['service_id'];
            if($event['cmd'] === QueueConstants::PUBLISH_COURSE_TO_ECS) {
                $value = $this->buildCourseCreatedRessource($service_id);
            } elseif($event['cmd'] === QueueConstants::PUBLISH_MEMBERS_TO_ECS) {
                $value = $this->buildMembersRessource($service_id);
            }
            else {
                DataCache::getInstance(false)->getLog()->warning(sprintf('!! No known command "%s" found in event with service id "%s".', $event['cmd'], $event['service_id']));
            }
        }
        return $value;
    }

    protected function buildCourseCreatedRessource($service_id): array
    {
        return [
            QueueConstants::STATUS => QueueConstants::CREATED,
            QueueConstants::RESSOURCE => QueueConstants::ECS_CAMPUS_LIGHT_COURSES . $service_id
        ];
    }

    protected function buildMembersRessource($service_id): array
    {
        return [
            QueueConstants::STATUS => QueueConstants::CREATED,
            QueueConstants::RESSOURCE => QueueConstants::ECS_CAMPUS_LIGHT_COURSE_MEMBERS . $service_id
        ];
    }

    public function parseCourseUrls(array $body): CourseUrls {
        $cms_lecture_id = $ecs_course_url = null;
        $lms_course_urls = [];
        if(isset($body['cms_lecture_id'])) {
            $cms_lecture_id = $body['cms_lecture_id'];
        }
        if(isset($body['ecs_course_url'])) {
            $ecs_course_url = $body['ecs_course_url'];
        }
        if(isset($body['lms_course_urls'])) {
            $lms_course_urls = $body['lms_course_urls'];
        }

        return new CourseUrls($cms_lecture_id, $ecs_course_url, $lms_course_urls);
    }

    /**
     * @return mixed object | false
     */
    public function isValidParticipant() : EcsAuth {
        $user = $_SERVER['REMOTE_USER'] ?: '';
        if($user === '') {
            Utils::LogToShellAndExit('Unknown user given or no known user found, exiting process');
        } else {
            $database = new QueueDatabase();
            $participants = $database->getParticipants();
            foreach($participants as $user_data) {
                if(isset($user_data['name']) && $user_data['name'] === $user) {
                    $cid = GlobalSettings::getInstance()->getEcsCommunityId();
                    $pid = $user_data['pid'];
                    $mid = $user_data['mid'];
                    return new EcsAuth($cid, $pid, $mid);
                } else {
                    Utils::LogToShellAndExit(sprintf('Given user name "%s" is not know, please check your participants table, if the user exists.', $user));
                }
            }
        }
    }

    /**
     * @param EcsAuth $valid_participant
     * @return array|void|null
     */
    protected function readParticipants(EcsAuth $valid_participant)
    {
        if($this->participants === null) {
            $database = new QueueDatabase();
            $json = $database->getParticipants();
            $participants = [];
            $auth_pid = $valid_participant->getPid();

            foreach ($json as $participant) {
                if (isset($participant[self::PID])) {
                    if ($participant[self::PID] === $auth_pid) {
                        $participant[self::ITS_YOU] = true;
                    } else {
                        $participant[self::ITS_YOU] = false;
                    }
                }
                $participants[] = $participant;

                if(isset($this->id_list[$participant[self::PID]])) {
                    $this->id_list[$participant[self::PID]] = $participant[self::MID];
                }
            }
            $this->participants = $participants;
        }

        return $this->participants;
    }

    public function getPayloadForCourses(EcsAuth $valid_participant, int $courseId) {

        return [
            "receivers" => [
                [
                    "itsyou" => true,
                    "mid" => $valid_participant->getMid(),
                    "cid" => $valid_participant->getCid(),
                    "pid" => $valid_participant->getPid()
                ]
            ],
            "senders" => [
                [
                    "mid" => $valid_participant->getMid()
                ]
            ],
            "url" => "courselinks/" . $courseId,
            "lectureId" => $courseId,
            "content_type" => JSON_CONTENT_TYPE,
            "owner" => [
                "pid" => $valid_participant->getPid(),
                "itsyou" => true
            ]
        ];
    }

    public function getPayloadForCourseMembers(EcsAuth $valid_participant, int $courseId) {

        return [
            "receivers" => [
                [
                    "itsyou" => true,
                    "mid" => $valid_participant->getMid(),
                    "cid" => $valid_participant->getCid(),
                    "pid" => $valid_participant->getPid()
                ]
            ],
            "senders" => [
                [
                    "mid" => $valid_participant->getMid()
                ]
            ],
            "url" => "courselinks/" . $courseId,
            "content_type" => JSON_CONTENT_TYPE,
            "owner" => [
                "pid" => $valid_participant->getPid(),
                "itsyou" => true
            ]
        ];
    }
}
