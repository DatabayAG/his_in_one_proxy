<?php

namespace HisInOneProxy\System;

use Exception;
use FilesystemIterator;
use HisInOneProxy\Log\Log;
use HisInOneProxy\Soap\Interactions\DataCache;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;
use RegexIterator;

/**
 * Class ProcessHandling
 * @package HisInOneProxy\System
 */
class ProcessHandling
{
    /**
     * @var Log
     */
    protected $log;

    /**
     * ProcessHandling constructor.
     */
    public function __construct()
    {
        $this->log = DataCache::getInstance()->getLog();
    }

    /**
     * @param $cmd
     * @param $pid_file
     * @return bool
     */
    public function startProcess($cmd, $pid_file)
    {
        $pid = exec($cmd . ' > /dev/null & echo $!');
        if ($pid) {
            $this->log->info(sprintf('Process started with pid %s.', $pid));
            file_put_contents($pid_file, $pid);
            return true;
        }
        return false;
    }

    /**
     * @param $pid_file
     * @return bool
     */
    public function killProcess($pid_file)
    {
        $this->log->debug(sprintf('Pid file (%s) found trying to kill the process...', $pid_file));
        $pid = file_get_contents($pid_file);

        if ($pid != '') {
            $response = false;

            try {
                $response = posix_kill($pid, SIGKILL);
            } catch (Exception $e) {
                $this->log->error(sprintf('Process with id (%s) could not be killed, %s!', $pid, $e->getMessage()));
            }

            if ($response == true) {
                $this->log->debug(sprintf('Killed the process successfully removing pid (%s) file.', $pid_file));
                unlink($pid_file);
                return true;
            } else {
                $this->log->warning(sprintf('Process with pid (%s) could not be killed!', $pid));
            }
        } else {
            $this->log->warning(sprintf('No pid found in file (%s)!', $pid_file));
        }

        return false;
    }

    /**
     * @param $process_name
     * @return string
     */
    public function getMultiProcessName($process_name)
    {
        $iterator = new RecursiveDirectoryIterator(
            'pid/',
            FilesystemIterator::SKIP_DOTS
        );

        $iterator = new RecursiveIteratorIterator($iterator);
        $iterator = new RegexIterator($iterator, '/' . $process_name . '_(\d+)\.pid/');

        return 'pid/' . $process_name . '_' . iterator_count($iterator) . '.pid';

    }
}