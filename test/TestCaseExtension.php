<?php

include_once './libs/composer/vendor/autoload.php';

class TestCaseExtension extends \PHPUnit\Framework\TestCase
{
	/**
	 * @var \HisInOneProxy\Log\Log
	 */
	protected $log;

	protected $collectedMessages = array();

	protected function setUp()
	{
		$this->log = $this->createMock('HisInOneProxy\Log\Log');
		$this->log->expects($this->any())
				  ->method('info')
				  ->will($this->returnCallback(
					  function ($message) use (&$collectedMessages)
					  {
						  $this->collectedMessages[] = 'Info: ' . $message;
					  })
				  );
		$this->log->expects($this->any())
				  ->method('warning')
				  ->will($this->returnCallback(
					  function ($message) use (&$collectedMessages)
					  {
						  $this->collectedMessages[] = 'Warning: ' . $message;
					  })
				  );
		$this->log->expects($this->any())
				  ->method('error')
				  ->will($this->returnCallback(
					  function ($message) use (&$collectedMessages)
					  {
						  $this->collectedMessages[] = 'Error: ' . $message;
					  })
				  );
		$this->log->expects($this->any())
				  ->method('emergency')
				  ->will($this->returnCallback(
					  function ($message) use (&$collectedMessages)
					  {
						  $this->collectedMessages[] = 'Emergency: ' . $message;
					  })
				  );
		$this->log->expects($this->any())
				  ->method('debug')
				  ->will($this->returnCallback(
					  function ($message) use (&$collectedMessages)
					  {
						  $this->collectedMessages[] = 'Debug: ' . $message;
					  })
				  );
		\HisInOneProxy\Soap\Interactions\DataCache::getInstance()->setLog($this->log);
	}

	public static function callMethod($obj, $name, array $args) {
		$class = new \ReflectionClass($obj);
		$method = $class->getMethod($name);
		$method->setAccessible(true);
		return $method->invokeArgs($obj, $args);
	}
}