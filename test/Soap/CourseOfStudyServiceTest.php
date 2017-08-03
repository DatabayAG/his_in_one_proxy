<?php

include_once './libs/composer/vendor/autoload.php';

use HisInOneProxy\Soap;

require_once 'test/TestCaseExtension.php';

class CourseOfStudyServiceTest extends TestCaseExtension
{
	/**
	 * @var Soap\SoapServiceRouter
	 */
	protected $soap_client_router;

	protected function setUp()
	{
		parent::setUp();
		$this->soap_client_router = new Soap\SoapServiceRouter($this->log);
		$this->soap_client_router->setSoapClientCourseOfStudyService($this->getMockFromWsdl(\HisInOneProxy\Config\GlobalSettings::getInstance()->getHisServerUrl().'CourseOfStudyService.wsdl'));
	}

	public function test_getCourseOfStudyById_shouldLogErrors()
	{
		$this->soap_client_router->getSoapClientCourseOfStudyService()->expects($this->any())
								 ->method('__soapCall')
								 ->will($this->throwException(new SoapFault('Server', 'Something horrible happened to the course of study.')));
		$soap_client = new Soap\CourseOfStudyService($this->log, $this->soap_client_router );
		$soap_client->getCourseOfStudyById(1999);
		$this->assertEquals('Error: Something horrible happened to the course of study.', array_pop($this->collectedMessages));
	}


	public function test_getCourseOfStudyById_shouldReturnValue()
	{
		$this->soap_client_router->getSoapClientCourseOfStudyService()->expects($this->any())
			->method('__soapCall')
			->willReturn(simplexml_load_string(file_get_contents('test/fixtures/course_of_study_children.xml')));
		$soap_client = new Soap\CourseOfStudyService($this->log, $this->soap_client_router);
		$value = $soap_client->getCourseOfStudyById(1999);
		$this->assertInstanceOf('HisInOneProxy\DataModel\CourseOfStudy', $value);
	}

}