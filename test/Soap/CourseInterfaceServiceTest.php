<?php

include_once './libs/composer/vendor/autoload.php';

use HisInOneProxy\Soap;

require_once 'test/TestCaseExtension.php';

class CourseInterfaceServiceTest extends TestCaseExtension
{

	/**
	 * @var Soap\SoapServiceRouter
	 */
	protected $soap_client_router;

	protected function setUp()
	{
		parent::setUp();

		$this->soap_client_router = new Soap\SoapServiceRouter($this->log);
		$this->soap_client_router->setSoapClientCourseInterfaceService($this->getMockFromWsdl(\HisInOneProxy\Config\GlobalSettings::getInstance()->getHisServerUrl().'CourseInterfaceService.wsdl'));
	}

	public function test_readPersonExamPlanEnrollmentsForUnit_shouldLogError()
	{
		$this->soap_client_router->getSoapClientCourseInterfaceService()->expects($this->any())
			->method('__soapCall')
			->will($this->throwException(new SoapFault('Server', 'Something horrible happened to the exam plan.')));
		$soap_client = new Soap\CourseInterfaceService($this->log, $this->soap_client_router);
		$soap_client->readPersonExamPlanEnrollmentsForUnit(1999, '12-12-1254', '1990', '23', 'false', '12-01-2015');
		$this->assertEquals('Error: Something horrible happened to the exam plan.', array_pop($this->collectedMessages));
	}

	public function test_getCourseCatalogLeaf_shouldReturnValue()
	{
		$xml = file_get_contents('test/fixtures/exam_relation.xml');
		$this->soap_client_router->getSoapClientCourseInterfaceService()->expects($this->any())
										  ->method('__soapCall')
										  ->willReturn(simplexml_load_string('<resp><examplans>' .$xml .'</examplans></resp>' ));
		$soap_client = new Soap\CourseInterfaceService($this->log, $this->soap_client_router);
		$plan = new \HisInOneProxy\DataModel\PlanElement();
		$value = $soap_client->readPersonExamPlanEnrollmentsForUnit($plan, 1999, '12-12-1254', '1990', '23', 'false', '12-01-2015');
		$this->assertInstanceOf('\HisInOneProxy\DataModel\ExamRelation',  $plan->getPersonPlanElementContainer()[0]);
	}

	public function test_readPersonExamPlanEnrollments_shouldLogError()
	{
		$this->soap_client_router->getSoapClientCourseInterfaceService()->expects($this->any())
													->method('__soapCall')
													->will($this->throwException(new SoapFault('Server', 'Something horrible happened to the exam plan 2.')));
		$soap_client = new Soap\CourseInterfaceService($this->log, $this->soap_client_router);
		$plan_element = new \HisInOneProxy\DataModel\PlanElement();
		$plan_element->setId(324);
		$soap_client->readPersonExamPlanEnrollments($plan_element, '90', 'false',  '12-01-2015');
		$this->assertEquals('Error: Something horrible happened to the exam plan 2.', array_pop($this->collectedMessages));
	}

	public function test_findUnit_shouldLogError()
	{
		$this->soap_client_router->getSoapClientCourseInterfaceService()->expects($this->any())
								 ->method('__soapCall')
								 ->will($this->throwException(new SoapFault('Server', 'Something horrible happened to the unit id list.')));
		$soap_client = new Soap\CourseInterfaceService($this->log, $this->soap_client_router);
		$soap_client->findUnit(1999, '1254');
		$this->assertEquals('Error: Something horrible happened to the unit id list.', array_pop($this->collectedMessages));
	}

	public function test_findUnit_shouldReturnValue()
	{
		$xml = file_get_contents('test/fixtures/unit_id_list.xml');
		$this->soap_client_router->getSoapClientCourseInterfaceService()->expects($this->any())
								 ->method('__soapCall')
								 ->willReturn(simplexml_load_string($xml));
		$soap_client = new Soap\CourseInterfaceService($this->log, $this->soap_client_router);
		$value = $soap_client->findUnit(1999, '1254');
		$this->assertInstanceOf('\HisInOneProxy\DataModel\Container\UnitIdList', $value);
		$this->assertEquals(1, $value->getSizeOfContainer());
	}

	public function test_readUnit_shouldLogError()
	{
		$this->soap_client_router->getSoapClientCourseInterfaceService()->expects($this->any())
								 ->method('__soapCall')
								 ->will($this->throwException(new SoapFault('Server', 'Something horrible happened to the unit.')));
		$soap_client = new Soap\CourseInterfaceService($this->log, $this->soap_client_router);
		$soap_client->readUnit(1999);
		$this->assertEquals('Error: Something horrible happened to the unit.', array_pop($this->collectedMessages));
	}

	public function test_readUnit_shouldReturnValue()
	{
		$xml = file_get_contents('test/fixtures/unit.xml');
		$this->soap_client_router->getSoapClientCourseInterfaceService()->expects($this->any())
								 ->method('__soapCall')
								 ->willReturn(simplexml_load_string('<resp>'.$xml.'</resp>'));
		$soap_client = new Soap\CourseInterfaceService($this->log, $this->soap_client_router);
		$value = $soap_client->readUnit(1999);
		$this->assertInstanceOf('\HisInOneProxy\DataModel\Unit', $value);
		$this->assertEquals(213213123, $value->getLid());
	}

	public function test_getCourseOfStudiesForUnit_shouldLogError()
	{
		$this->soap_client_router->getSoapClientCourseInterfaceService()->expects($this->any())
								 ->method('__soapCall')
								 ->will($this->throwException(new SoapFault('Server', 'Something horrible happened to the course of study.')));
		$soap_client = new Soap\CourseInterfaceService($this->log, $this->soap_client_router);
		$soap_client->getCourseOfStudiesForUnit(1999);
		$this->assertEquals('Error: Something horrible happened to the course of study.', array_pop($this->collectedMessages));
	}

	public function test_getCourseOfStudiesForUnit_shouldReturnValue()
	{
		$xml = file_get_contents('test/fixtures/unit.xml');
		$this->soap_client_router->getSoapClientCourseInterfaceService()->expects($this->any())
								 ->method('__soapCall')
								 ->willReturn(simplexml_load_string($xml));
		$soap_client = new Soap\CourseInterfaceService($this->log, $this->soap_client_router);
		$value = $soap_client->getCourseOfStudiesForUnit(1999);
		$this->assertInstanceOf('\HisInOneProxy\DataModel\Container\CourseOfStudyIdList', $value);
	}

	public function test_getCombinationForCourse_shouldLogError()
	{
		$this->soap_client_router->getSoapClientCourseInterfaceService()->expects($this->any())
								 ->method('__soapCall')
								 ->will($this->throwException(new SoapFault('Server', 'Something horrible happened to the course mapping.')));
		$soap_client = new Soap\CourseInterfaceService($this->log, $this->soap_client_router);
		$unit = new \HisInOneProxy\DataModel\Unit();
		$unit->setId(1999);
		$soap_client->getCombinationForCourse($unit, 23, 1000);
		$this->assertEquals('Error: Something horrible happened to the course mapping.', array_pop($this->collectedMessages));
	}

	public function test_getCombinationForCourse_shouldReturnValue()
	{
		$xml = file_get_contents('test/fixtures/unit.xml');
		$this->soap_client_router->getSoapClientCourseInterfaceService()->expects($this->any())
								 ->method('__soapCall')
								 ->willReturn(simplexml_load_string($xml));
		$soap_client = new Soap\CourseInterfaceService($this->log, $this->soap_client_router);
		$unit = new \HisInOneProxy\DataModel\Unit();
		$unit->setId(1999);
		$value = $soap_client->getCombinationForCourse($unit, 23, 1000);
		$this->assertEquals(array(), $unit->getCourseMappingContainer());
	}

	public function test_readPlanElementsForUnit_shouldLogError()
	{
		$this->soap_client_router->getSoapClientCourseInterfaceService()->expects($this->any())
								 ->method('__soapCall')
								 ->will($this->throwException(new SoapFault('Server', 'Something horrible happened to the unit.')));
		$soap_client = new Soap\CourseInterfaceService($this->log, $this->soap_client_router);
		$cache = array();
		$unit = new \HisInOneProxy\DataModel\Unit();
		$unit->setId(1999);
		$soap_client->readPlanElementsForUnit($unit, 23, 2017,$cache);
		$this->assertEquals('Error: Something horrible happened to the unit.', array_pop($this->collectedMessages));
	}

	public function test_readPlanElementsForUnit_shouldReturnValue()
	{
		$xml = file_get_contents('test/fixtures/unit.xml');
		$this->soap_client_router->getSoapClientCourseInterfaceService()->expects($this->any())
								 ->method('__soapCall')
								 ->willReturn(simplexml_load_string($xml));
		$soap_client = new Soap\CourseInterfaceService($this->log, $this->soap_client_router);
		$cache = array();
		$unit = new \HisInOneProxy\DataModel\Unit();
		$value = $soap_client->readPlanElementsForUnit($unit, 23, 2017);
		$this->assertInstanceOf('\HisInOneProxy\DataModel\Unit', $value);
	}

	public function test_getPersonResponsibleForPlanElement_shouldLogError()
	{
		$this->soap_client_router->getSoapClientCourseInterfaceService()->expects($this->any())
								 ->method('__soapCall')
								 ->will($this->throwException(new SoapFault('Server', 'Something horrible happened to the unit.')));
		$soap_client = new Soap\CourseInterfaceService($this->log, $this->soap_client_router);
		$soap_client->getPersonResponsibleForPlanElement(1999, new \HisInOneProxy\DataModel\PlanElement());
		$this->assertEquals('Error: Something horrible happened to the unit.', array_pop($this->collectedMessages));
	}

	public function test_addLinkToCourse_shouldLogError()
	{
		$this->soap_client_router->getSoapClientCourseInterfaceService()->expects($this->any())
								 ->method('__soapCall')
								 ->will($this->throwException(new SoapFault('Server', 'Something horrible happened while adding a link.')));
		$soap_client = new Soap\CourseInterfaceService($this->log, $this->soap_client_router);
		$soap_client->addLinkToCourse(1, 2,1999, 'httpS://toller_kaputer_link', 'my description');
		$this->assertEquals('Error: Something horrible happened while adding a link.', array_pop($this->collectedMessages));
	}

	public function test_addLinkToCourse_shouldReturnValue()
	{
		$xml = file_get_contents('test/fixtures/person_plan_elements.xml');
		$this->soap_client_router->getSoapClientCourseInterfaceService()->expects($this->any())
								 ->method('__soapCall')
								 ->willReturn(true);
		$soap_client = new Soap\CourseInterfaceService($this->log, $this->soap_client_router);
		$value = $soap_client->addLinkToCourse(1, 2,1999, 'httpS://toller_kaputer_link', 'my description');
		$this->assertEquals(true, $value);
	}

}