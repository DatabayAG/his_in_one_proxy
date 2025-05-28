<?php

namespace HisInOneProxy\Queue;

require_once './libs/composer/vendor/autoload.php';

use Exception;
use HisInOneProxy\Config\GlobalSettings;
use HisInOneProxy\Log\Log;
use HisInOneProxy\Queue;
use HisInOneProxy\Soap\Interactions\DataCache;
use React\EventLoop;
use React\EventLoop\ExtEventLoop;
use React\EventLoop\StreamSelectLoop;

/**
 * Class QueueWatcher
 * @package HisInOneProxy\Queue
 */
class QueueWatcher
{
    protected array $jobs_to_be_processed_later = [];
    protected string|int|false $start_time = 0;
    protected int $events = 0;
    protected LibEventLoop|EventLoop\LoopInterface|null|ExtEventLoop|LibEvLoop|StreamSelectLoop $loop;
    protected QueueInterface $queue;
    protected Log $log;
    private bool $use_local_ecs = false;

    /**
     * @throws Exception
     */
    public function __construct()
    {
        $this->loop = EventLoop\Loop::get();
        $this->addServicesTimer(Queue\QueueConstants::SERVICE_QUEUE, GlobalSettings::getInstance()->getQueueTimer());
        $this->addServicesTimer(Queue\QueueConstants::MAINTENANCE_QUEUE, 10);
        $queue = new Queue\QueueBase();
        $this->queue = $queue->getQueueType();
        $this->log   = DataCache::getInstance()->getLog();
        $this->use_local_ecs = GlobalSettings::getInstance()->isUseLocalEcs();
    }

    /**
     * @param $queue_name
     * @param $interval
     */
    protected function addServicesTimer($queue_name, $interval): void
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
    public function processMessage($queue_name): void
    {
        $message   = $this->queue->pop($queue_name);
        if($message !== []) {
            $file_name = $message[1];
            $message   = json_decode($message[0]);
        }

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
                $service->setUseLocalEcs($this->use_local_ecs);

                if ($cmd != null && $service->doesFunctionExists($cmd)) {
                    if ($service->$cmd($data, $receiver)) {
                        $this->queue->removeMessage($queue_name, $file_name);
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

    public function jobCanBeProcessed($unix_time, $file_name, $queue_name): bool
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

    public function run(): void
    {
        $this->loop->run();
    }

}

if (!defined('PHPUNIT')) {
    $server = new QueueWatcher();
    $server->run();
}
