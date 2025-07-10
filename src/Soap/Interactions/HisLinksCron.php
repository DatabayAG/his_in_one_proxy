<?php

namespace HisInOneProxy\Soap\Interactions;

require_once './libs/composer/vendor/autoload.php';

use HisInOneProxy\Config\GlobalSettings;
use HisInOneProxy\Log\Log;
use HisInOneProxy\Queue\QueueDatabase;
use HisInOneProxy\Soap\CourseInterfaceService;
use HisInOneProxy\Soap\SoapServiceRouter;
use HisInOneProxy\System\Utils;

class HisLinksCron
{
    private int $messages = 5;
    private QueueDatabase $db;

    public function __construct()
    {
        $this->db = new QueueDatabase();
        $this->checkForNewLinks();
        $this->messages = GlobalSettings::getInstance()->getProcessLinksCount();
    }

    private function checkForNewLinks() {
        $unit_ids = $this->db->getUnitIdsFromJson();
        $log = new Log();
        $router                      = new SoapServiceRouter($log);
        $course_interface_service    = new CourseInterfaceService($log, $router);

        for($i=0; $i<= $this->messages; $i++) {
            $link_id = 0;
            $unit_id = 0;

            $link = $this->db->popLink();
            if($link === []) {
                $msg = 'No more links found.';
                $log->info($msg);
                Utils::LogToShellAndExit($msg);
            } else {
                $lecture_id = $link['unit_id'];

                if(isset($unit_ids[$lecture_id]['unit_id'])) {
                    $unit_id = $unit_ids[$lecture_id]['unit_id'];
                }

                $term_type = $link['term_type'];
                $term_year = $link['term_year'];
                $desc = $link['description'];
                $link_id = $link['link_id'];
                $link_lcms = $link['link'];

                if($unit_id !== 0 && $link_id !== 0) {
                    $course_interface_service->deleteLinkFromCourse($unit_id, $term_type, $term_year, $link_lcms);
                    $course_interface_service->addLinkToCourse($unit_id, $term_type, $term_year,  $desc, $link_lcms);
                    $log->info(sprintf('Link id (%s) created for unit id %s', $link_id, $unit_id));
                } else {
                    $log->warning(sprintf('No unit id found for lecture id %s, ignoring entry.', $lecture_id));
                }

                $this->db->markSentLink($link_id);
            }
        }

    }
}

new HisLinksCron();
