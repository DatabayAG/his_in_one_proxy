<?php

include_once './libs/composer/vendor/autoload.php';

use HisInOneProxy\Soap;

require_once 'test/TestCaseExtension.php';

/**
 * Class SoapServiceRouterTest
 */
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
		$this->assertEqualClearedString('Info: ', $starting_string[0]);
		$this->assertEqualClearedString('initializing all Services done', $starting_string[3]);
		$this->soap_client_router->setSoapClientCourseOfStudyService(null);
		$this->soap_client_router->getSoapClientCourseOfStudyService();
		$this->assertEqualClearedString('Emergency: Course of study service not initialised!', array_pop($this->collectedMessages));

		$this->soap_client_router->setSoapClientCourseCatalog(null);
		$this->soap_client_router->getSoapClientCourseCatalog();
		$this->assertEqualClearedString('Emergency: Course catalog service not initialised!', array_pop($this->collectedMessages));

		$this->soap_client_router->setSoapClientCourseService(null);
		$this->soap_client_router->getSoapClientCourseService();
		$this->assertEqualClearedString('Emergency: Course service not initialised!', array_pop($this->collectedMessages));

		$this->soap_client_router->setSoapClientUnitService(null);
		$this->soap_client_router->getSoapClientUnitService();
		$this->assertEqualClearedString('Emergency: Unit service not initialised!', array_pop($this->collectedMessages));

		$this->soap_client_router->setSoapClientOrgUnitService(null);
		$this->soap_client_router->getSoapClientOrgUnitService();
		$this->assertEqualClearedString('Emergency: Org unit service not initialised!', array_pop($this->collectedMessages));

		$this->soap_client_router->setSoapClientCourseInterfaceService(null);
		$this->soap_client_router->getSoapClientCourseInterfaceService();
		$this->assertEqualClearedString('Emergency: Course interface service not initialised!', array_pop($this->collectedMessages));

		$this->soap_client_router->setSoapClientPersonService(null);
		$this->soap_client_router->getSoapClientPersonService();
		$this->assertEqualClearedString('Emergency: Person service not initialised!', array_pop($this->collectedMessages));

		$this->soap_client_router->setSoapClientStudentService(null);
		$this->soap_client_router->getSoapClientStudentService();
		$this->assertEqualClearedString('Emergency: Student service not initialised!', array_pop($this->collectedMessages));

		$this->soap_client_router->setSoapClientFacilityService(null);
		$this->soap_client_router->getSoapClientFacilityService();
		$this->assertEqualClearedString('Emergency: Facility service not initialised!', array_pop($this->collectedMessages));

		$this->soap_client_router->setSoapClientAddressService(null);
		$this->soap_client_router->getSoapClientAddressService();
		$this->assertEqualClearedString('Emergency: Address service not initialised!', array_pop($this->collectedMessages));

		$this->soap_client_router->setSoapClientKeyValueService(null);
		$this->soap_client_router->getSoapClientKeyValueService();
		$this->assertEqualClearedString('Emergency: KeyValue service not initialised!', array_pop($this->collectedMessages));

		$this->soap_client_router->setSoapClientTermService(null);
		$this->soap_client_router->getSoapClientTermService();
		$this->assertEqualClearedString('Emergency: Term service not initialised!', array_pop($this->collectedMessages));

		$this->soap_client_router->setSoapClientAddressService(null);
		$this->soap_client_router->getSoapClientAddressService();
		$this->assertEqualClearedString('Emergency: Address service not initialised!', array_pop($this->collectedMessages));

		$this->soap_client_router->setSoapSystemEventAbonnenmentClient(null);
		$this->soap_client_router->getSoapSystemEventAbonnenmentClient();
		$this->assertEqualClearedString('Emergency: System Event service not initialised!', array_pop($this->collectedMessages));

		$this->soap_client_router->setSoapClientAccountService(null);
		$this->soap_client_router->getSoapClientAccountService();
		$this->assertEqualClearedString('Emergency: Account service not initialised!', array_pop($this->collectedMessages));

	}

	public function test_ConstructNeedsAllServices2_shouldLogErrors()
	{
		$this->assertNull(array_pop($this->collectedMessages));
		$this->soap_client_router = new Soap\SoapServiceRouter($this->log);
		$this->soap_client_router->setServiceNumber(20);
		$this->soap_client_router->initialiseClientServices();
		$this->assertEqualClearedString('Emergency: Not all Soap Services where initialised! Only 14 from 20 where initialised!', array_pop($this->collectedMessages));
		$this->assertInstanceOf('HisInOneProxy\Soap\WSSoapClient', $this->soap_client_router->getSoapClientCourseService());
		$this->assertInstanceOf('HisInOneProxy\Soap\WSSoapClient', $this->soap_client_router->getSoapClientTermService());
	}
}