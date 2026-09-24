<?php

include_once './libs/composer/vendor/autoload.php';

use HisInOneProxy\Soap;

require_once 'test/TestCaseExtension.php';

/**
 * Class CourseInterfaceServiceTest
 */
class CourseInterfaceServiceTest extends TestCaseExtension
{

	/**
	 * @var Soap\SoapServiceRouter
	 */
	protected $soap_client_router;

	protected function setUp(): void
	{
		parent::setUp();

		$this->soap_client_router = new Soap\SoapServiceRouter($this->log);
		$this->soap_client_router->setSoapClientCourseInterfaceService($this->createSoapClientMock());
	}

	public function test_readPersonExamPlanEnrollmentsForUnit_shouldLogError()
	{
		$this->soap_client_router->getSoapClientCourseInterfaceService()->method('__soapCall')
			->willThrowException(new SoapFault('Server', 'Exam plan enrollments not found for unit 55.'));
		$soap_client = new Soap\CourseInterfaceService($this->log, $this->soap_client_router);
		$soap_client->readPersonExamPlanEnrollmentsForUnit(55, '2017-04-01', '2017', 'false', '2017-10-15');
		$this->assertEqualClearedString('Error: Exam plan enrollments not found for unit 55.', array_pop($this->collectedMessages));
	}

	public function test_getCourseCatalogLeaf_shouldReturnValue()
	{
		$xml = file_get_contents('test/fixtures/exam_relation.xml');
		$this->soap_client_router->getSoapClientCourseInterfaceService()->method('__soapCall')
										  ->willReturn(simplexml_load_string('<resp><examplans>' .$xml .'</examplans></resp>' ));
		$soap_client = new Soap\CourseInterfaceService($this->log, $this->soap_client_router);
		$plan = new \HisInOneProxy\DataModel\PlanElement();
		$soap_client->readPersonExamPlanEnrollmentsForUnit($plan, 55, '2017-04-01', '2017',  'false', '2017-10-15');
		$this->assertInstanceOf('\HisInOneProxy\DataModel\ExamRelation',  $plan->getPersonPlanElementContainer()[0]);
	}

	public function test_readPersonExamPlanEnrollments_shouldLogError()
	{
		$this->soap_client_router->getSoapClientCourseInterfaceService()->method('__soapCall')
													->willThrowException(new SoapFault('Server', 'Exam plan enrollments not found for plan element 123123.'));
		$soap_client = new Soap\CourseInterfaceService($this->log, $this->soap_client_router);
		$plan_element = new \HisInOneProxy\DataModel\PlanElement();
		$plan_element->setId(123123);
		$soap_client->readPersonExamPlanEnrollments($plan_element, '2017', 'false',  '2017-10-15');
		$this->assertEquals('Error: Exam plan enrollments not found for plan element 123123.', array_pop($this->collectedMessages));
	}

	public function test_findUnit_shouldLogError()
	{
		$this->soap_client_router->getSoapClientCourseInterfaceService()->method('__soapCall')
								 ->willThrowException(new SoapFault('Server', 'Unit search failed for person 122.'));
		$soap_client = new Soap\CourseInterfaceService($this->log, $this->soap_client_router);
		$soap_client->findUnit(122, '2017');
		$this->assertEquals('Error: Unit search failed for person 122.', array_pop($this->collectedMessages));
	}

	public function test_findUnit_shouldReturnValue()
	{
		$xml = file_get_contents('test/fixtures/unit_id_list.xml');
		$this->soap_client_router->getSoapClientCourseInterfaceService()->method('__soapCall')
								 ->willReturn(simplexml_load_string($xml));
		$soap_client = new Soap\CourseInterfaceService($this->log, $this->soap_client_router);
		$value = $soap_client->findUnit(122, '2017');
		$this->assertInstanceOf('\HisInOneProxy\DataModel\Container\UnitIdList', $value);
		$this->assertEquals(1, $value->getSizeOfContainer());
	}

	public function test_countUnits_shouldReturnSizeWithoutListingIds()
	{
		$xml = '<resp><unitIds><unitId>972</unitId><unitId>973</unitId></unitIds></resp>';
		$this->soap_client_router->getSoapClientCourseInterfaceService()->expects($this->once())
								 ->method('__soapCall')
								 ->with('findUnit81', array(array(
									 'termTypeValueId'          => 2,
									 'termYear'                 => 2026,
									 'termYearForMapping'       => 2026,
									 'termTypeValueIdForMapping'=> 2,
									 'elearningSystemId'        => 7,
								 )))
								 ->willReturn(simplexml_load_string($xml));
		$soap_client = new Soap\CourseInterfaceService($this->log, $this->soap_client_router);
		$value = $soap_client->countUnits(2, 2026, array(
			'termYearForMapping'        => 2026,
			'termTypeValueIdForMapping' => 2,
			'elearningSystemId'         => 7,
		));
		$this->assertEquals(2, $value);
		$this->assertEmpty($this->collectedMessages);
	}

	public function test_countUnits_shouldReturnNullOnSoapFault()
	{
		$this->soap_client_router->getSoapClientCourseInterfaceService()->method('__soapCall')
								 ->willThrowException(new SoapFault('Server', 'Unit search failed.'));
		$soap_client = new Soap\CourseInterfaceService($this->log, $this->soap_client_router);
		$this->assertNull($soap_client->countUnits(2, 2026));
		$this->assertEquals('Error: Unit search failed.', array_pop($this->collectedMessages));
	}

	public function test_readUnit_shouldLogError()
	{
		$this->soap_client_router->getSoapClientCourseInterfaceService()->method('__soapCall')
								 ->willThrowException(new SoapFault('Server', 'Unit with id 55 not found.'));
		$soap_client = new Soap\CourseInterfaceService($this->log, $this->soap_client_router);
		$soap_client->readUnit(55);
		$this->assertEquals('Error: Unit with id 55 not found.', array_pop($this->collectedMessages));
	}

	public function test_getCourseOfStudiesForUnit_shouldLogError()
	{
		$this->soap_client_router->getSoapClientCourseInterfaceService()->method('__soapCall')
								 ->willThrowException(new SoapFault('Server', 'Course of study list not found for unit 55.'));
		$soap_client = new Soap\CourseInterfaceService($this->log, $this->soap_client_router);
		$soap_client->getCourseOfStudiesForUnit(55);
		$this->assertEquals('Error: Course of study list not found for unit 55.', array_pop($this->collectedMessages));
	}

	public function test_getCourseOfStudiesForUnit_shouldReturnValue()
	{
		$xml = file_get_contents('test/fixtures/unit.xml');
		$this->soap_client_router->getSoapClientCourseInterfaceService()->method('__soapCall')
								 ->willReturn(simplexml_load_string($xml));
		$soap_client = new Soap\CourseInterfaceService($this->log, $this->soap_client_router);
		$value = $soap_client->getCourseOfStudiesForUnit(55);
		$this->assertInstanceOf('\HisInOneProxy\DataModel\Container\CourseOfStudyIdList', $value);
	}

	public function test_getCombinationForCourse_shouldLogError()
	{
		$this->soap_client_router->getSoapClientCourseInterfaceService()->method('__soapCall')
								 ->willThrowException(new SoapFault('Server', 'Course mapping not found for unit 55.'));
		$soap_client = new Soap\CourseInterfaceService($this->log, $this->soap_client_router);
		$unit = new \HisInOneProxy\DataModel\Unit();
		$unit->setId(55);
		$soap_client->getCombinationForCourse($unit, 12, 2017);
		$this->assertEquals('Error: Course mapping not found for unit 55.', array_pop($this->collectedMessages));
	}

	public function test_getCombinationForCourse_shouldReturnValue()
	{
		$xml = file_get_contents('test/fixtures/unit.xml');
		$this->soap_client_router->getSoapClientCourseInterfaceService()->method('__soapCall')
								 ->willReturn(simplexml_load_string($xml));
		$soap_client = new Soap\CourseInterfaceService($this->log, $this->soap_client_router);
		$unit = new \HisInOneProxy\DataModel\Unit();
		$unit->setId(55);
		$value = $soap_client->getCombinationForCourse($unit, 12, 2017);
		$this->assertEquals(array(), $unit->getCourseMappingContainer());
	}

	public function test_readPlanElementsForUnit_shouldLogError()
	{
		$this->soap_client_router->getSoapClientCourseInterfaceService()->method('__soapCall')
								 ->willThrowException(new SoapFault('Server', 'Plan elements not found for unit 55.'));
		$soap_client = new Soap\CourseInterfaceService($this->log, $this->soap_client_router);
		$cache = array();
		$unit = new \HisInOneProxy\DataModel\Unit();
		$unit->setId(55);
		$soap_client->readPlanElementsForUnit($unit, 12, 2017, $cache);
		$this->assertEquals('Error: Plan elements not found for unit 55.', array_pop($this->collectedMessages));
	}

	public function test_readPlanElementsForUnit_shouldReturnValue()
	{
		$xml = file_get_contents('test/fixtures/unit.xml');
		$this->soap_client_router->getSoapClientCourseInterfaceService()->method('__soapCall')
								 ->willReturn(simplexml_load_string($xml));
		$soap_client = new Soap\CourseInterfaceService($this->log, $this->soap_client_router);
		$cache = array();
		$unit = new \HisInOneProxy\DataModel\Unit();
		$value = $soap_client->readPlanElementsForUnit($unit, 12, 2017);
		$this->assertInstanceOf('\HisInOneProxy\DataModel\Unit', $value);
	}

	public function test_getPersonResponsibleForPlanElement_shouldLogError()
	{
		$this->soap_client_router->getSoapClientCourseInterfaceService()->method('__soapCall')
								 ->willThrowException(new SoapFault('Server', 'Responsible person not found for plan element.'));
		$soap_client = new Soap\CourseInterfaceService($this->log, $this->soap_client_router);
		$soap_client->getPersonResponsibleForPlanElement(55, new \HisInOneProxy\DataModel\PlanElement());
		$this->assertEquals('Error: Responsible person not found for plan element.', array_pop($this->collectedMessages));
	}

	public function test_addLinkToCourse_shouldLogError()
	{
		$this->soap_client_router->getSoapClientCourseInterfaceService()->method('__soapCall')
								 ->willThrowException(new SoapFault('Server', 'Failed to add ILIAS link to course.'));
		$soap_client = new Soap\CourseInterfaceService($this->log, $this->soap_client_router);
		$soap_client->addLinkToCourse(12, 123123, 55, 'https://ilias.uni-example.de/crs/12345', 'ILIAS-Kursverknüpfung');
		$this->assertEquals('Error: Failed to add ILIAS link to course.', array_pop($this->collectedMessages));
	}

	public function test_addLinkToCourse_shouldReturnValue()
	{
		$this->soap_client_router->getSoapClientCourseInterfaceService()->method('__soapCall')
								 ->willReturn(true);
		$soap_client = new Soap\CourseInterfaceService($this->log, $this->soap_client_router);
		$value = $soap_client->addLinkToCourse(12, 123123, 55, 'https://ilias.uni-example.de/crs/12345', 'ILIAS-Kursverknüpfung');
		$this->assertEquals(true, $value);
	}

}
