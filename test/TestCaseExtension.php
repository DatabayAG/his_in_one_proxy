<?php

include_once __DIR__ . '/../libs/composer/vendor/autoload.php';

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

	protected function setUp(): void
	{
		$this->log = $this->createMock('HisInOneProxy\Log\Log');
		$this->log->method('info')
				  ->willReturnCallback(
					  function ($message) {
						  $this->collectedMessages[] = 'Info: ' . $message;
					  }
				  );
		$this->log->method('warning')
				  ->willReturnCallback(
					  function ($message) {
						  $this->collectedMessages[] = 'Warning: ' . $message;
					  }
				  );
		$this->log->method('error')
				  ->willReturnCallback(
					  function ($message) {
						  $this->collectedMessages[] = 'Error: ' . $message;
					  }
				  );
		$this->log->method('emergency')
				  ->willReturnCallback(
					  function ($message) {
						  $this->collectedMessages[] = 'Emergency: ' . $message;
					  }
				  );
		$this->log->method('debug')
				  ->willReturnCallback(
					  function ($message) {
						  $this->collectedMessages[] = 'Debug: ' . $message;
					  }
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
		if ($str === null) {
			return '';
		}

		return preg_replace('/[\n\t\s+]/', '', $str);
	}

	protected function createSoapClientMock(): \SoapClient
	{
		return $this->createMock(\SoapClient::class);
	}

	/**
	 * @var array<string, string>
	 */
	private static $fixtureCache = array();

	protected function loadFixture(string $relativePath): string
	{
		if (!isset(self::$fixtureCache[$relativePath])) {
			self::$fixtureCache[$relativePath] = file_get_contents($relativePath);
		}

		return self::$fixtureCache[$relativePath];
	}
}