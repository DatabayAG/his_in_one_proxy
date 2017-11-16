<?php

include_once './libs/composer/vendor/autoload.php';

require_once 'test/TestCaseExtension.php';

/**
 * Class SimpleQueueTest
 */
class SimpleQueueTest extends TestCaseExtension
{
	
	protected $path = '';
	
	protected $base_path;

	/**
	 * @var \HisInOneProxy\Queue\SimpleQueue
	 */
	protected $queue;

	protected function setUp()
	{
		\HisInOneProxy\Config\GlobalSettings::getInstance()->readCustomConfig('test/php_unit_config.json');
		$this->base_path = \HisInOneProxy\Config\GlobalSettings::getInstance()->getPathToQueue();

		mkdir($this->base_path .\HisInOneProxy\Queue\QueueConstants::SERVICE_QUEUE, 0777, true);
		mkdir($this->base_path .'/'.\HisInOneProxy\Queue\QueueConstants::MAINTENANCE_QUEUE.'/', 0777, true);
		$this->queue = new \HisInOneProxy\Queue\SimpleQueue();

		parent::setUp();
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

	public function test_createQueueTest_shouldCreateQueue()
	{
		$exists = $this->queue->queueExists(\HisInOneProxy\Queue\QueueConstants::SERVICE_QUEUE);
		$this->assertTrue($exists);
	}

	public function test_popOnEmptyQueue_shouldReturnArray()
	{
		$value = $this->queue->pop(\HisInOneProxy\Queue\QueueConstants::SERVICE_QUEUE);
		$this->assertEquals(array(null, null), $value);
	}

	public function test_pushOnEmptyQueue_shouldAppendElement()
	{
		$queue = new \HisInOneProxy\Queue\SimpleQueue();
		$queue->push(\HisInOneProxy\Queue\QueueConstants::SERVICE_QUEUE, array(), 'my_great_function');
		$value = $queue->pop(\HisInOneProxy\Queue\QueueConstants::SERVICE_QUEUE);
		$this->assertEquals(array('{"data":[],"cmd":"my_great_function","receiver":"","unix_time":0}', '1.job'), $value);
	}

	public function test_getSize_shouldReturnSize()
	{
		$this->assertEquals(0, $this->queue->getSize(\HisInOneProxy\Queue\QueueConstants::SERVICE_QUEUE));
		$this->queue->push(\HisInOneProxy\Queue\QueueConstants::SERVICE_QUEUE, array(), 'my_great_function');
		$this->assertEquals(1, $this->queue->getSize(\HisInOneProxy\Queue\QueueConstants::SERVICE_QUEUE));
	}

	public function test_getSize_shouldReturnZeroIfQueueDoesNotExists()
	{
		$this->assertEquals(0, $this->queue->getSize('my_custom_queue'));
	}

	public function test_cleanUpStaleJobs_shouldReAddMaintenance()
	{
		$this->assertEquals(0, $this->queue->getSize(\HisInOneProxy\Queue\QueueConstants::MAINTENANCE_QUEUE));
		$this->queue->push(\HisInOneProxy\Queue\QueueConstants::SERVICE_QUEUE, array(), 'my_great_function');
		$this->queue->pop(\HisInOneProxy\Queue\QueueConstants::SERVICE_QUEUE);
		$this->queue->cleanUpStaleJobs();
		$this->assertEquals(1, $this->queue->getSize(\HisInOneProxy\Queue\QueueConstants::MAINTENANCE_QUEUE));
	}

	public function test_acknowledgeMessage_shouldDeleteMessage()
	{
		TestCaseExtension::callMethod(
			$this->queue,
			'keepElements',
			array(false)
		);

		$this->assertEquals(0, $this->queue->getSize(\HisInOneProxy\Queue\QueueConstants::MAINTENANCE_QUEUE));
		$this->queue->push(\HisInOneProxy\Queue\QueueConstants::SERVICE_QUEUE, array(), 'my_great_function');
		$this->assertEquals(1, $this->queue->getSize(\HisInOneProxy\Queue\QueueConstants::SERVICE_QUEUE));
		$this->queue->pop(\HisInOneProxy\Queue\QueueConstants::SERVICE_QUEUE);
		$this->queue->acknowledgeMessage(\HisInOneProxy\Queue\QueueConstants::SERVICE_QUEUE, '1.job');
		$this->queue->acknowledgeMessage(\HisInOneProxy\Queue\QueueConstants::SERVICE_QUEUE, '2.job');
		$this->assertEquals(0, $this->queue->getSize(\HisInOneProxy\Queue\QueueConstants::SERVICE_QUEUE));
	}

	public function test_reAddMessageToQueue_shouldReAddMessageToQueue()
	{
		$this->assertEquals(0, $this->queue->getSize(\HisInOneProxy\Queue\QueueConstants::SERVICE_QUEUE));
		$this->queue->push(\HisInOneProxy\Queue\QueueConstants::SERVICE_QUEUE, array(), 'my_great_function');
		$this->assertEquals(1, $this->queue->getSize(\HisInOneProxy\Queue\QueueConstants::SERVICE_QUEUE));
		$this->queue->pop(\HisInOneProxy\Queue\QueueConstants::SERVICE_QUEUE);
		$this->assertEquals(0, $this->queue->getSize(\HisInOneProxy\Queue\QueueConstants::SERVICE_QUEUE));
		$this->queue->reAddMessageToQueue(\HisInOneProxy\Queue\QueueConstants::SERVICE_QUEUE, '1.job');
		$this->assertEquals(1, $this->queue->getSize(\HisInOneProxy\Queue\QueueConstants::SERVICE_QUEUE));
	}

}