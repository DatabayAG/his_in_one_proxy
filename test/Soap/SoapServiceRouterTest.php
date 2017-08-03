<?php

include_once './libs/composer/vendor/autoload.php';

use HisInOneProxy\Soap;

require_once 'test/TestCaseExtension.php';

class SoapServiceRouterTest extends TestCaseExtension
{

	/**
	 * @var Soap\SoapServiceRouter
	 */
	protected $soap_client_router;

	protected function setUp()
	{
		parent::setUp();
	}

	public function test_ConstructNeedsAllServices_shouldLogErrors()
	{
		$this->soap_client_router = new Soap\SoapServiceRouter($this->log);
		$starting_string = array_pop($this->collectedMessages);
		$starting_string = preg_split('/\./', $starting_string);
		$this->assertEquals('Info: ', $starting_string[0]);
		$this->assertEquals('initializing all Services done', $starting_string[3]);
		$this->soap_client_router->setSoapClientCourseOfStudyService(null);
		$this->soap_client_router->getSoapClientCourseOfStudyService();
		$this->assertEquals('Emergency: Course of study service not initialised!', array_pop($this->collectedMessages));

		$this->soap_client_router->setSoapClientCourseCatalog(null);
		$this->soap_client_router->getSoapClientCourseCatalog();
		$this->assertEquals('Emergency: Course catalog service not initialised!', array_pop($this->collectedMessages));

		$this->soap_client_router->setSoapClientCourseService(null);
		$this->soap_client_router->getSoapClientCourseService();
		$this->assertEquals('Emergency: Course service not initialised!', array_pop($this->collectedMessages));

		$this->soap_client_router->setSoapClientUnitService(null);
		$this->soap_client_router->getSoapClientUnitService();
		$this->assertEquals('Emergency: Unit service not initialised!', array_pop($this->collectedMessages));

		$this->soap_client_router->setSoapClientOrgUnitService(null);
		$this->soap_client_router->getSoapClientOrgUnitService();
		$this->assertEquals('Emergency: Org unit service not initialised!', array_pop($this->collectedMessages));

		$this->soap_client_router->setSoapClientCourseInterfaceService(null);
		$this->soap_client_router->getSoapClientCourseInterfaceService();
		$this->assertEquals('Emergency: Course interface service not initialised!', array_pop($this->collectedMessages));

		$this->soap_client_router->setSoapClientPersonService(null);
		$this->soap_client_router->getSoapClientPersonService();
		$this->assertEquals('Emergency: Person service not initialised!', array_pop($this->collectedMessages));

		$this->soap_client_router->setSoapClientStudentService(null);
		$this->soap_client_router->getSoapClientStudentService();
		$this->assertEquals('Emergency: Student service not initialised!', array_pop($this->collectedMessages));

		$this->soap_client_router->setSoapClientFacilityService(null);
		$this->soap_client_router->getSoapClientFacilityService();
		$this->assertEquals('Emergency: Facility service not initialised!', array_pop($this->collectedMessages));

		$this->soap_client_router->setSoapClientAddressService(null);
		$this->soap_client_router->getSoapClientAddressService();
		$this->assertEquals('Emergency: Address service not initialised!', array_pop($this->collectedMessages));


		$this->soap_client_router->setSoapClientValueService(null);
		$this->soap_client_router->getSoapClientValueService();
		$this->assertEquals('Emergency: Value service not initialised!', array_pop($this->collectedMessages));

		$this->soap_client_router->setSoapClientTermService(null);
		$this->soap_client_router->getSoapClientTermService();
		$this->assertEquals('Emergency: Term service not initialised!', array_pop($this->collectedMessages));

		$this->soap_client_router->setSoapClientAddressService(null);
		$this->soap_client_router->getSoapClientAddressService();
		$this->assertEquals('Emergency: Address service not initialised!', array_pop($this->collectedMessages));

		$this->soap_client_router->setSoapSystemEventAbonnenmentClient(null);
		$this->soap_client_router->getSoapSystemEventAbonnenmentClient();
		$this->assertEquals('Emergency: System Event service not initialised!', array_pop($this->collectedMessages));

	}

	public function test_ConstructNeedsAllServices2_shouldLogErrors()
	{
		$this->assertNull(array_pop($this->collectedMessages));
		$this->soap_client_router = new Soap\SoapServiceRouter($this->log);
		$this->soap_client_router->setServiceNumber(20);
		$this->soap_client_router->initialiseClientServices();
		$this->assertEquals('Emergency: Not all Soap Services where initialised! Only 13 from 20 where initialised!', array_pop($this->collectedMessages));
		$this->assertInstanceOf('HisInOneProxy\Soap\WSSoapClient', $this->soap_client_router->getSoapClientCourseService());
		$this->assertInstanceOf('HisInOneProxy\Soap\WSSoapClient', $this->soap_client_router->getSoapClientTermService());
	}
}