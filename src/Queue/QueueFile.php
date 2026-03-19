<?php

namespace HisInOneProxy\Queue;

use Exception;
use FilesystemIterator;
use GlobIterator;
use HisInOneProxy\Config\GlobalSettings;
use HisInOneProxy\Log\Log;
use HisInOneProxy\Soap\Interactions\DataCache;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;
use RegexIterator;
use SplFileInfo;
use SplFileObject;

require_once './libs/composer/vendor/autoload.php';

/**
 * Class SimpleQueueInterface
 * @package HisInOneProxy\Queue
 */
class QueueFile extends QueueBase
{
    protected array $router = [];
    protected string $base_path;
    protected int $permissions = 0740;
    protected bool $keep_elements;
    protected Log $log;


    function __construct()
    {
        $this->log = DataCache::getInstance()->getLog();
        $this->base_path     = GlobalSettings::getInstance()->getPathToQueue();
        $this->keep_elements = GlobalSettings::getInstance()->isKeepElementInQueue();
    }

    public function pop(string $queue_name) : array
    {
        if ($this->queueExists($queue_name)) {
            $queue_dir = $this->getQueueDirectory($queue_name);
            $it        = new GlobIterator($queue_dir . DIRECTORY_SEPARATOR . '*.job', FilesystemIterator::KEY_AS_FILENAME);
            $files     = array_keys(iterator_to_array($it));
            natsort($files);

            $files = array_reverse($files, true);
            {
                if ($files) {
                    $id = array_pop($files);

                    try {

                        $file = new SplFileObject($queue_dir . DIRECTORY_SEPARATOR . $id, 'r+');
                        $file->flock(LOCK_EX);
                        $data = array(file_get_contents($queue_dir . DIRECTORY_SEPARATOR . $id), $id);
                        rename($queue_dir . DIRECTORY_SEPARATOR . $id, $queue_dir . DIRECTORY_SEPARATOR . $id . '.done');
                        $file->flock(LOCK_UN);
                        $this->log->debug(sprintf('Read entry from queue %s.', $queue_name));

                        return $data;

                    } catch (Exception $e) {
                        $this->log->error(sprintf('File could not be renamed %s.', $e->getMessage()));
                    }
                }
            }
        }

        return array(null, null);
    }

    public function queueExists(string $queue_name) : bool
    {
        if (!is_dir($this->getQueueDirectory($queue_name))) {
            if (!mkdir($concurrentDirectory = $this->getQueueDirectory($queue_name), $this->permissions, true) && !is_dir($concurrentDirectory)) {
                throw new \RuntimeException(sprintf('Directory "%s" was not created', $concurrentDirectory));
            }
            $this->log->debug(sprintf('Queue %s not found, initialised it.', $queue_name));
        }
        return true;
    }

    private function getQueueDirectory(string $queue_name) : string
    {
        return $this->base_path . str_replace(array('\\', '.'), '-', $queue_name);
    }

    public function getSize(string $queue_name) : int
    {
        if ($this->queueExists($queue_name)) {
            $iterator = new RecursiveDirectoryIterator(
                $this->getQueueDirectory($queue_name),
                FilesystemIterator::SKIP_DOTS
            );

            $iterator = new RecursiveIteratorIterator($iterator);
            $iterator = new RegexIterator($iterator, '#\.job$#');

            return iterator_count($iterator);
        }
        return 0;
    }

    public function cleanUpStaleJobs() : void
    {
        $queue_dir = $this->getQueueDirectory(QueueConstants::SERVICE_QUEUE);
        $it        = new GlobIterator($queue_dir . DIRECTORY_SEPARATOR . '*.job.done', FilesystemIterator::KEY_AS_FILENAME);
        $files     = array_keys(iterator_to_array($it));
        $sec_a_day = 86400;
        $yesterday = time() - $sec_a_day;
        natsort($files);

        if ($files) {
            foreach ($files as $file) {
                $info = new SplFileInfo($queue_dir . DIRECTORY_SEPARATOR . $file);
                $time = $info->getCTime();
                if ($time <= $yesterday) {
                    unlink($queue_dir . DIRECTORY_SEPARATOR . $file);
                    $this->log->debug(sprintf('Removed stale file %s this was created %s', $file, $time));
                }
            }
        }

        $this->push(QueueConstants::MAINTENANCE_QUEUE, '', QueueConstants::CLEAN_UP_STALE_JOBS, '', time() + $sec_a_day);
    }

    public function push(string $queue_name, string $data, string $function = '', string $receiver = '', int $unix_time = 0) : void
    {
        if ($this->queueExists($queue_name)) {
            $queue_dir = $this->getQueueDirectory($queue_name);
            $filename  = $this->getJobFilename($queue_name);

            $envelope = array('data' => $data, 'cmd' => $function, 'receiver' => $receiver, 'unix_time' => $unix_time);

            file_put_contents($queue_dir . DIRECTORY_SEPARATOR . $filename, json_encode($envelope));
            chmod($queue_dir . DIRECTORY_SEPARATOR . $filename, $this->permissions);

            $this->log->debug(sprintf('Added new entry to queue %s.', $queue_name));
        }
    }

    private function getJobFilename(string $queue_name) : string
    {
        $path = $this->base_path . '/simple_queue.meta';
        if (!is_file($path)) {
            touch($path);
            chmod($path, $this->permissions);
        }

        $file = new SplFileObject($path, 'r+');
        $file->flock(LOCK_EX);
        $meta = unserialize($file->fgets());
        $id   = isset($meta[$queue_name]) ? $meta[$queue_name] : 0;
        $id++;

        $filename          = sprintf('%d.job', $id);
        $meta[$queue_name] = $id;
        $content           = serialize($meta);

        $file->fseek(0);
        $file->fwrite($content, strlen($content));
        $file->flock(LOCK_UN);

        return $filename;
    }

    public function removeMessage(string $queue_name, string $id) : void
    {
        $queue_dir = $this->getQueueDirectory($queue_name);
        $path      = $queue_dir . DIRECTORY_SEPARATOR . $id . '.done';
        if (!is_file($path)) {
            return;
        }
        $this->log->debug(sprintf('Acknowledged entry %s from queue %s, removing it.', $id, $queue_name));

        if (!$this->keep_elements) {
            unlink($path);
        }
    }

    public function reAddMessageToQueue(string $queue_name, string $id) : void
    {
        $queue_dir = $this->getQueueDirectory($queue_name);
        rename($queue_dir . DIRECTORY_SEPARATOR . $id . '.done', $queue_dir . DIRECTORY_SEPARATOR . $id);
        $this->log->debug(sprintf('Re-added entry %s to queue %s.', $id, $queue_name));
    }
}
