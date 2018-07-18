<?php

namespace HisInOneProxy\Queue;

use HisInOneProxy\Soap\Interactions\DataCache;
use HisInOneProxy\System\ProcessHandling;

/**
 * Class QueueProcess
 * @package HisInOneProxy\Queue
 */
class QueueProcess
{
	/**
	 * @var \HisInOneProxy\Log\Log
	 */
	protected $log;

	/**
	 * @var 
	 */
	protected $process_name = 'queue';

	/**
	 * @var ProcessHandling
	 */
	protected $process;

	/**
	 * @var string
	 */
	protected $process_id;

	/**
	 * QueueProcess constructor.
	 */
	public function __construct()
	{
		$this->log = DataCache::getInstance()->getLog();
		$this->process = new ProcessHandling();
		$this->killAllQueueProcess();
		$this->process_id = $this->process->getMultiProcessName($this->process_name);
	}

	/**
	 * 
	 */
	protected function killAllQueueProcess()
	{
		
		$iterator = new \RecursiveDirectoryIterator(
		'pid/',
		\FilesystemIterator::SKIP_DOTS
		);

		$iterator = new \RecursiveIteratorIterator($iterator);
		$iterator = new \RegexIterator($iterator, '/'. $this->process_name.'_(\d+)\.pid/');

		foreach($iterator as $item)
		{
			if(file_exists($item->getPathName()))
			{
				$this->process->killProcess($item->getPathName());
			}
		}

	}
	
	/**
	 * @return bool
	 */
	protected function killQueueProcess()
	{
		return $this->process->killProcess($this->process_id);
	}

	/**
	 * @return bool
	 */
	public function startQueueProcess()
	{
		return $this->process->startProcess('php src/Queue/QueueWatcher.php', $this->process_id);
	}
	
}