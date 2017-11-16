<?php

include_once './libs/composer/vendor/autoload.php';

use HisInOneProxy\Soap;

require_once 'test/TestCaseExtension.php';

/**
 * Class StudentServiceTest
 */
class StudentServiceTest extends TestCaseExtension
{

	/**
	 * @var array
	 */
	protected $collectedMessages = array();

	/**
	 * @var Soap\SoapServiceRouter
	 */
	protected $soap_client_router;

	protected function setUp()
	{

		parent::setUp();

		$this->soap_client_router = new Soap\SoapServiceRouter($this->log);
		$this->soap_client_router->setSoapClientStudentService($this->getMockFromWsdl(\HisInOneProxy\Config\GlobalSettings::getInstance()->getHisServerUrl().'StudentService.wsdl'));
	}

	public function test_readStudentWithCoursesOfStudyByStudentId_shouldReturnStudentExisting()
	{
		$this->soap_client_router->getSoapClientStudentService()->expects($this->any())
			->method('__soapCall')
			->willReturn(simplexml_load_string('<resp>'.file_get_contents('test/fixtures/student_existing.xml').'</resp>'));
		$soap_client = new Soap\StudentService($this->log, $this->soap_client_router);
		$value = $soap_client->readStudentWithCoursesOfStudyByStudentId(1999);
		$this->assertInstanceOf('HisInOneProxy\DataModel\StudentExisting', $value);
	}

}