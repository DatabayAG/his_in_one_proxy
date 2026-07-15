<?php

include_once './libs/composer/vendor/autoload.php';

require_once 'test/TestCaseExtension.php';

use HisInOneProxy\Soap;

/**
 * Class CurriculumDesignerServiceTest
 */
class CurriculumDesignerServiceTest extends TestCaseExtension
{
	/**
	 * @var Soap\SoapServiceRouter
	 */
	protected $soap_client_router;

	protected function setUp(): void
	{
		parent::setUp();
		$this->soap_client_router = new Soap\SoapServiceRouter($this->log);
		$this->soap_client_router->setSoapClientCurriculumDesignerService($this->createSoapClientMock());
	}

	public function test_getRootIdOfTerm_shouldReturnValue()
	{
		$this->soap_client_router->getSoapClientCurriculumDesingerService()->method('__soapCall')
			->willReturn(simplexml_load_string('<resp>'.file_get_contents('test/fixtures/unit.xml').'</resp>'));
		$soap_client = new Soap\CurriculumDesignerService($this->log, $this->soap_client_router);
		$value = $soap_client->readUnit(55);
		$this->assertInstanceOf('HisInOneProxy\DataModel\Unit', $value);
	}

}
