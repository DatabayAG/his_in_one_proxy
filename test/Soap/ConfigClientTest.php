<?php

include_once './libs/composer/vendor/autoload.php';

use HisInOneProxy\Config\GlobalSettings;
use HisInOneProxy\Soap;

require_once 'test/TestCaseExtension.php';

/**
 * Class ConfigClientTest
 */
class ConfigClientTest extends TestCaseExtension
{

	/**
	 * @var Soap\SoapServiceRouter
	 */
	protected $soap_client_router;

	protected function setUp()
	{
	}

	public function test_getRootIdOfTerm_shouldReturnValue()
	{
		$config = new Soap\SoapService\ConfigClient();
		GlobalSettings::getInstance()->setValidateSsl("true");
		$stream1 = $config->getSSlConfig();
		GlobalSettings::getInstance()->setValidateSsl("false");
		$stream2 = $config->getSSlConfig();
		$this->assertNotEquals($stream1, $stream2);

	}

}