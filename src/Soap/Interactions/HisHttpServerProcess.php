<?php

namespace HisInOneProxy\Soap\Interactions;

use HisInOneProxy\Config\GlobalSettings;
use HisInOneProxy\System\ProcessHandling;

/**
 * Class HisHttpServerProcess
 * @package HisInOneProxy\Soap\Interactions
 */
class HisHttpServerProcess
{
	const HIS_SERVER_PID = 'pid/server.pid';

	/**
	 * @var \HisInOneProxy\Log\Log
	 */
	protected $log;

	/**
	 * @var ProcessHandling 
	 */
	protected $process;

	/**
	 * HisHttpServerProcess constructor.
	 */
	public function __construct()
	{
		$this->log = DataCache::getInstance()->getLog();
		$this->process = new ProcessHandling();
	}

	/**
	 * @return bool
	 */
	protected function isServerStillActive()
	{
		$this->log->debug(sprintf('Checking if port is in use...'));
		$url        = GlobalSettings::getInstance()->getEndPoint()->getUrlWithPort();
		$parts      = preg_split('/:/', $url);
		$connection = @fsockopen($parts[0], $parts[1]);
		if(is_resource($connection))
		{
			$this->log->debug(sprintf('Port is in use server probably running.'));
			return true;
		}
		return false;
	}

	/**
	 * 
	 */
	public function checkIfOldHisServerInstanceExists()
	{
		$this->isServerStillActive();
		$this->log->debug(sprintf('Checking if pid file exists...'));

		if(file_exists(self::HIS_SERVER_PID))
		{
			$this->killServerProcess();
		}
	}

	/**
	 * @return bool
	 */
	protected function killServerProcess()
	{
		return $this->process->killProcess(self::HIS_SERVER_PID);
	}

	/**
	 * @return bool
	 */
	public function startHisServer()
	{
		if($this->isServerStillActive())
		{
			$this->killServerProcess();
		}
		return $this->process->startProcess('php src/Soap/HisHttpServer.php', self::HIS_SERVER_PID);
	}

	public function restartServer()
	{
		$this->checkIfOldHisServerInstanceExists();
		$this->startHisServer();
	}
}