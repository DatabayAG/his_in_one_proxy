<?php

include_once './libs/composer/vendor/autoload.php';

/**
 * Class TestCaseExtension
 */
class TestCaseExtension extends \PHPUnit\Framework\TestCase
{
	/**
	 * @var \HisInOneProxy\Log\Log
	 */
	protected $log;

	/**
	 * @var array
	 */
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

	/**
	 * @param       $obj
	 * @param       $name
	 * @param array $args
	 * @return mixed
	 */
	public static function callMethod($obj, $name, array $args) 
	{
		$class = new \ReflectionClass($obj);
		$method = $class->getMethod($name);
		$method->setAccessible(true);
		return $method->invokeArgs($obj, $args);
	}
	
	public function setHiddenProperty($obj, $property, $value)
	{
		$refObject   = new ReflectionObject( $obj );
		$refProperty = $refObject->getProperty( $property );
		$refProperty->setAccessible( true );
		$refProperty->setValue(null, $value);
	}

	/**
	 * @param string $str1
	 * @param string $str2
	 */
	public function assertEqualClearedString($str1, $str2)
	{
		$this->assertEquals($this->clearString($str1), $this->clearString($str2));
	}

	/**
	 * @param $str
	 * @return string
	 */
	protected function clearString($str)
	{
		return preg_replace('/[\n\t\s+]/', '', $str);
	}
}