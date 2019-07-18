<?php

namespace HisInOneProxy\Config;

/**
 * Trait LogConfig
 * @package HisInOneProxy\Config
 */
trait LogConfig
{
    /**
     * @var string
     */
    protected $log_path;

    /**
     * @var int
     */
    protected $log_level;

    /**
     * @return string
     */
    public function getLogPath()
    {
        return $this->log_path;
    }

    /**
     * @param string $log_path
     */
    public function setLogPath($log_path)
    {
        $this->log_path = $log_path;
    }

    /**
     * @return int
     */
    public function getLogLevel()
    {
        return $this->log_level;
    }

    /**
     * @param int $log_level
     */
    public function setLogLevel($log_level)
    {
        $this->log_level = $log_level;
    }
}
