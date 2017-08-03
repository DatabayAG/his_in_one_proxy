<?php

include_once './libs/composer/vendor/autoload.php';

require_once 'test/TestCaseExtension.php';
use HisInOneProxy\Soap\Interactions\DataCache;

class QueueWatcherTest extends TestCaseExtension
{
	/**
	 * @var \HisInOneProxy\Queue\QueueWatcher
	 */
	protected $watcher;
	
	protected $base_path;

	/**
	 * @var \HisInOneProxy\Queue\SimpleQueue
	 */
	protected $queue;

	protected function setUp()
	{
		\HisInOneProxy\Config\GlobalSettings::getInstance()->readCustomConfig('test/php_unit_config.json');
		$this->base_path = \HisInOneProxy\Config\GlobalSettings::getInstance()->getPathToQueue();

		mkdir($this->base_path .\HisInOneProxy\Queue\QueueConstants::SERVICE_QUEUE.'/', 0777, true);
		mkdir($this->base_path .\HisInOneProxy\Queue\QueueConstants::MAINTENANCE_QUEUE.'/', 0777, true);

		parent::setUp();

		DataCache::getInstance()->setLog($this->log);
		$this->watcher = new \HisInOneProxy\Queue\QueueWatcher();
	}

	function removeDirectory($path)
	{
		$files = glob($path . '/*');
		foreach ($files as $file)
		{
			is_dir($file) ? $this->removeDirectory($file) : unlink($file);
		}
		rmdir($path);
		return;
	}

	protected function tearDown()
	{
		$this->removeDirectory($this->base_path);
	}

	public function test_jobCanBeProcessed_shouldReturnTrue()
	{
		$exists = $this->watcher->jobCanBeProcessed(time() - 60, '1.job', \HisInOneProxy\Queue\QueueConstants::SERVICE_QUEUE);
		$this->assertTrue($exists);
	}

	public function test_jobCanBeProcessed2_shouldReturnTrue()
	{
		$exists = $this->watcher->jobCanBeProcessed(time() + 60, '1.job', \HisInOneProxy\Queue\QueueConstants::SERVICE_QUEUE);
		$this->assertFalse($exists);
		$exists = $this->watcher->jobCanBeProcessed(time() + 60, '1.job', \HisInOneProxy\Queue\QueueConstants::SERVICE_QUEUE);
		$this->assertFalse($exists);
	}

	public function test_jobCanBeProcessed3_shouldReturnTrue()
	{
		$this->watcher->jobCanBeProcessed(time() + 1, '1.job', \HisInOneProxy\Queue\QueueConstants::SERVICE_QUEUE);
		sleep(1);
		$exists = $this->watcher->jobCanBeProcessed(time() + 1, '1.job', \HisInOneProxy\Queue\QueueConstants::SERVICE_QUEUE);
		$this->assertTrue($exists);
	}

	public function test_processMessage_shouldReturnLogUnknownCommand()
	{
		$queue = new \HisInOneProxy\Queue\SimpleQueue();
		$queue->push(HisInOneProxy\Queue\QueueConstants::SERVICE_QUEUE, json_encode(['{cmd => custom, data => custom, receiver = "", unix_time => null }']), 'customFunction');
		$this->watcher->processMessage(HisInOneProxy\Queue\QueueConstants::SERVICE_QUEUE);
		$this->assertEquals(rtrim('Warning: 	Empty/Invalid command (customFunction) found in queue, ignoring.',"\n\r"), rtrim(array_pop($this->collectedMessages),"\n\r"));
	}
}