<?php

namespace HisInOneProxy\Log;

include_once './libs/composer/vendor/autoload.php';

use Exception;
use HisInOneProxy\Config\GlobalSettings;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;

/**
 * Class Log
 * @package HisInOneProxy\Log
 */
class Log
{
    private $logger = null;

    /**
     * Log constructor.
     * @param string $channel
     * @param null   $logger
     * @throws Exception
     */
    public function __construct($channel = 'default', $logger = null)
    {
        if ($logger == null) {
            $this->logger = new Logger($channel);
            $this->logger->pushHandler(new StreamHandler(GlobalSettings::getInstance()->getPathToLog(), Logger::DEBUG));
        } else {
            $this->logger = $logger;
        }
    }

    /**
     * @param       $a_message
     * @param array $a_context
     * @return bool
     */
    public function debug($a_message, $a_context = array())
    {
        return $this->getLogger()->debug($a_message, $a_context);
    }

    /**
     * @return Logger|null
     */
    public function getLogger()
    {
        return $this->logger;
    }

    /**
     * @param $a_message
     * @return bool
     */
    public function info($a_message)
    {
        return $this->getLogger()->info($a_message);
    }

    /**
     * @param $a_message
     * @return bool
     */
    public function notice($a_message)
    {
        return $this->getLogger()->notice($a_message);
    }

    /**
     * @param $a_message
     * @return bool
     */
    public function warning($a_message)
    {
        return $this->getLogger()->warning($a_message);
    }

    /**
     * @param $a_message
     * @return bool
     */
    public function error($a_message)
    {
        return $this->getLogger()->error($a_message);
    }

    /**
     * @param $a_message
     * @return bool
     */
    public function critical($a_message)
    {
        return $this->getLogger()->critical($a_message);
    }

    /**
     * @param $a_message
     * @return bool
     */
    public function alert($a_message)
    {
        return $this->getLogger()->alert($a_message);
    }

    /**
     * @param $a_message
     * @return bool
     */
    public function emergency($a_message)
    {
        return $this->getLogger()->emergency($a_message);
    }

    /**
     * @param $a_level
     * @return bool
     */
    public function isHandling($a_level)
    {
        return $this->getLogger()->isHandling($a_level);
    }

    /**
     * @param     $a_variable
     * @param int $a_level
     * @return bool
     */
    public function dump($a_variable, $a_level = LogLevel::INFO)
    {
        return $this->log(print_r($a_variable, true), $a_level);
    }

    /**
     * @param     $a_message
     * @param int $a_level
     * @return bool
     */
    public function log($a_message, $a_level = LogLevel::INFO)
    {
        return $this->getLogger()->log($a_level, $a_message);
    }
}
