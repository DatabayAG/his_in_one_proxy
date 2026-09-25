<?php

include_once './libs/composer/vendor/autoload.php';

use HisInOneProxy\Soap;

require_once 'test/TestCaseExtension.php';

/**
 * Class CourseOfStudyServiceTest
 */
class CourseOfStudyServiceTest extends TestCaseExtension
{
	/**
	 * @var Soap\SoapServiceRouter
	 */
	protected $soap_client_router;

	protected function setUp(): void
	{
		parent::setUp();
		$this->soap_client_router = new Soap\SoapServiceRouter($this->log);
		$this->soap_client_router->setSoapClientCourseOfStudyService($this->createSoapClientMock());
	}

	public function test_getCourseOfStudyById_shouldLogErrors()
	{
		$this->soap_client_router->getSoapClientCourseOfStudyService()->method('__soapCall')
								 ->willThrowException(new SoapFault('Server', 'Course of study with id 12 not found.'));
		$soap_client = new Soap\CourseOfStudyService($this->log, $this->soap_client_router );
		$soap_client->getCourseOfStudyById(12);
		$this->assertEqualClearedString('Error: Course of study with id 12 not found.', array_pop($this->collectedMessages));
	}


	public function test_getCourseOfStudyById_shouldReturnValue()
	{
		$this->soap_client_router->getSoapClientCourseOfStudyService()->method('__soapCall')
			->willReturn(simplexml_load_string(file_get_contents('test/fixtures/course_of_study_children.xml')));
		$soap_client = new Soap\CourseOfStudyService($this->log, $this->soap_client_router);
		$value = $soap_client->getCourseOfStudyById(12);
		$this->assertInstanceOf('HisInOneProxy\DataModel\CourseOfStudy', $value);
	}

}
