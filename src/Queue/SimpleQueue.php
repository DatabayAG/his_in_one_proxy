<?php

namespace HisInOneProxy\Queue;

use HisInOneProxy\Config\GlobalSettings;
use HisInOneProxy\Soap\Interactions\DataCache;

require_once './libs/composer/vendor/autoload.php';

/**
 * Class SimpleQueue
 * @package HisInOneProxy\Queue
 */
class SimpleQueue
{

    /**
     * @var array
     */
    protected $router = array();

    /**
     * @var
     */
    protected $base_path;

    /**
     * @var int
     */
    protected $permissions = 0740;

    /**
     * @var \HisInOneProxy\Log\Log
     */
    protected $log;

    /**
     * @var bool
     */
    protected $keep_elements;

    /**
     * SimpleQueue constructor.
     */
    function __construct()
    {
        $this->base_path     = GlobalSettings::getInstance()->getPathToQueue();
        $this->keep_elements = GlobalSettings::getInstance()->isKeepElementInQueue();
        $this->log           = DataCache::getInstance()->getLog();
    }

    /**
     * @param $keep
     */
    protected function keepElements($keep)
    {
        $this->keep_elements = $keep;
    }

    /**
     * @param $queue_name
     * @return array
     */
    public function pop($queue_name)
    {
        if ($this->queueExists($queue_name)) {
            $queue_dir = $this->getQueueDirectory($queue_name);
            $it        = new \GlobIterator($queue_dir . DIRECTORY_SEPARATOR . '*.job', \FilesystemIterator::KEY_AS_FILENAME);
            $files     = array_keys(iterator_to_array($it));
            natsort($files);

            $files = array_reverse($files, true);
            {
                if ($files) {
                    $id = array_pop($files);

                    try {

                        $file = new \SplFileObject($queue_dir . DIRECTORY_SEPARATOR . $id, 'r+');
                        $file->flock(LOCK_EX);
                        $data = array(file_get_contents($queue_dir . DIRECTORY_SEPARATOR . $id), $id);
                        rename($queue_dir . DIRECTORY_SEPARATOR . $id, $queue_dir . DIRECTORY_SEPARATOR . $id . '.done');
                        $file->flock(LOCK_UN);
                        $this->log->debug(sprintf('Read entry from queue %s.', $queue_name));

                        return $data;

                    } catch (\Exception $e) {
                        $this->log->error(sprintf('File could not be renamed %s.', $e->getMessage()));
                    }
                }
            }
        }

        return array(null, null);
    }

    /**
     * @param $queue_name
     * @return bool
     */
    public function queueExists($queue_name)
    {
        if (!is_dir($this->getQueueDirectory($queue_name))) {
            mkdir($this->getQueueDirectory($queue_name), $this->permissions, true);
            $this->log->debug(sprintf('Queue %s not found, initialised it.', $queue_name));
        }
        return true;
    }

    /**
     * @param $queue_name
     * @return string
     */
    private function getQueueDirectory($queue_name)
    {
        return $this->base_path . str_replace(array('\\', '.'), '-', $queue_name);
    }

    /**
     * @param $queue_name
     * @return int
     */
    public function getSize($queue_name)
    {
        if ($this->queueExists($queue_name)) {
            $iterator = new \RecursiveDirectoryIterator(
                $this->getQueueDirectory($queue_name),
                \FilesystemIterator::SKIP_DOTS
            );

            $iterator = new \RecursiveIteratorIterator($iterator);
            $iterator = new \RegexIterator($iterator, '#\.job$#');

            return iterator_count($iterator);
        }
        return 0;
    }

    /**
     *
     */
    public function cleanUpStaleJobs()
    {
        $queue_dir = $this->getQueueDirectory(QueueConstants::SERVICE_QUEUE);
        $it        = new \GlobIterator($queue_dir . DIRECTORY_SEPARATOR . '*.job.done', \FilesystemIterator::KEY_AS_FILENAME);
        $files     = array_keys(iterator_to_array($it));
        $sec_a_day = 86400;
        $yesterday = time() - $sec_a_day;
        natsort($files);

        if ($files) {
            foreach ($files as $file) {
                $info = new \SplFileInfo($queue_dir . DIRECTORY_SEPARATOR . $file);
                $time = $info->getCTime();
                if ($time <= $yesterday) {
                    unlink($queue_dir . DIRECTORY_SEPARATOR . $file);
                    $this->log->debug(sprintf('Removed stale file %s this was created %s', $file, $time));
                }
            }
        }

        $this->push(QueueConstants::MAINTENANCE_QUEUE, array(), QueueConstants::CLEAN_UP_STALE_JOBS, '', time() + $sec_a_day);
    }

    /**
     * @param        $queue_name
     * @param        $data
     * @param        $receiver
     * @param string $function
     * @param int    $unix_time
     */
    public function push($queue_name, $data, $function = '', $receiver = '', $unix_time = 0)
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

    /**
     * @param $queue_name
     * @return string
     */
    private function getJobFilename($queue_name)
    {
        $path = $this->base_path . '/simple_queue.meta';
        if (!is_file($path)) {
            touch($path);
            chmod($path, $this->permissions);
        }

        $file = new \SplFileObject($path, 'r+');
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

    /**
     * @param $queue_name
     * @param $file
     */
    public function acknowledgeMessage($queue_name, $file)
    {
        $queue_dir = $this->getQueueDirectory($queue_name);
        $path      = $queue_dir . DIRECTORY_SEPARATOR . $file . '.done';
        if (!is_file($path)) {
            return;
        }
        $this->log->debug(sprintf('Acknowledged entry %s from queue %s, removing it.', $file, $queue_name));

        if (!$this->keep_elements) {
            unlink($path);
        }
    }

    /**
     * @param $queue_name
     * @param $file
     */
    public function reAddMessageToQueue($queue_name, $file)
    {
        $queue_dir = $this->getQueueDirectory($queue_name);
        rename($queue_dir . DIRECTORY_SEPARATOR . $file . '.done', $queue_dir . DIRECTORY_SEPARATOR . $file);
        $this->log->debug(sprintf('Re-added entry %s to queue %s.', $file, $queue_name));
    }
}