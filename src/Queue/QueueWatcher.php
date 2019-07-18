<?php

namespace HisInOneProxy\Queue;

require_once './libs/composer/vendor/autoload.php';

use HisInOneProxy\Config\GlobalSettings;
use HisInOneProxy\Log\Log;
use HisInOneProxy\Queue;
use HisInOneProxy\Soap\Interactions\DataCache;
use React\EventLoop;

/**
 * Class QueueWatcher
 * @package HisInOneProxy\Queue
 */
class QueueWatcher
{
    /**
     * @var array
     */
    protected $jobs_to_be_processed_later = array();

    /**
     * @var false|int|string
     */
    protected $start_time = 0;

    /**
     * @var int
     */
    protected $events = 0;

    /**
     * @var \React\EventLoop\ExtEventLoop|\React\EventLoop\LibEventLoop|\React\EventLoop\LibEvLoop|\React\EventLoop\StreamSelectLoop
     */
    protected $loop;

    /**
     * @var Queue\SimpleQueue
     */
    protected $queue;

    /**
     * @var Log
     */
    protected $log;

    /**
     * QueueWatcher constructor.
     */
    public function __construct()
    {
        $this->loop = EventLoop\Factory::create();
        $this->addServicesTimer(Queue\QueueConstants::SERVICE_QUEUE, GlobalSettings::getInstance()->getQueueTimer());
        $this->addServicesTimer(Queue\QueueConstants::MAINTENANCE_QUEUE, 10);
        $this->queue = new Queue\SimpleQueue();
        $this->log   = DataCache::getInstance()->getLog();
    }

    /**
     * @param $queue_name
     * @param $interval
     */
    protected function addServicesTimer($queue_name, $interval)
    {
        $this->loop->addPeriodicTimer($interval, function () use (&$queue_name) {
            $this->log->debug("Looking for new services queue entries...\n");
            if ($this->queue->queueExists($queue_name)) {
                $queue_size = $this->queue->getSize($queue_name);
                $this->log->debug(sprintf("\t..." . $queue_name . " size: %s.\n", $queue_size));
                if ($queue_size > 0) {
                    $this->processMessage($queue_name);
                }
            }
            $this->log->debug("\t...looking fo new services queue entries done.\n");
        });
    }

    /**
     * @param $queue_name
     */
    public function processMessage($queue_name)
    {
        $message   = $this->queue->pop($queue_name);
        $file_name = $message[1];
        $message   = json_decode($message[0]);
        if (isset($message->cmd) && isset($message->data) && isset($message->unix_time)) {
            $cmd       = $message->cmd;
            $data      = $message->data;
            $unix_time = $message->unix_time;
            if (isset($message->receiver)) {
                $receiver = $message->receiver;
            } else {
                $receiver = '';
            }

            if ($this->jobCanBeProcessed($unix_time, $file_name, $queue_name)) {
                $service = new QueueService();

                if ($cmd != null && $service->doesFunctionExists($cmd)) {
                    if ($service->$cmd($data, $receiver)) {
                        $this->queue->acknowledgeMessage($queue_name, $file_name);
                    } else {
                        $this->queue->reAddMessageToQueue($queue_name, $file_name);
                    }
                } else {
                    $this->log->warning(sprintf("\tEmpty/Invalid command (%s) found in queue, ignoring.\n", $cmd));
                }
            } else {
                $this->queue->reAddMessageToQueue($queue_name, $file_name);
                $this->log->warning(sprintf("\tTime attribute is set %s but we have %s, ignoring.\n", $unix_time, time()));
            }
        }
    }

    /**
     * @param $unix_time
     * @param $file_name
     * @param $queue_name
     * @return bool
     */
    public function jobCanBeProcessed($unix_time, $file_name, $queue_name)
    {
        if (in_array($file_name, $this->jobs_to_be_processed_later)) {
            $time = array_search($file_name, $this->jobs_to_be_processed_later);
            if ($time <= time()) {
                unset($this->jobs_to_be_processed_later[$time]);
                return true;
            } else {
                $this->processMessage($queue_name);
            }
        } else {
            if ($unix_time == 0 || $unix_time <= time()) {
                return true;
            } else {
                if ($unix_time > time()) {
                    $this->jobs_to_be_processed_later[$unix_time] = $file_name;
                    $this->processMessage($queue_name);
                }
            }
        }

        return false;
    }

    public function run()
    {
        $this->loop->run();
    }

}

if (!defined('PHPUNIT')) {
    $server = new QueueWatcher();
    $server->run();
}