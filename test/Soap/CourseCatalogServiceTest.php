<?php

include_once './libs/composer/vendor/autoload.php';

use HisInOneProxy\Soap;

require_once 'test/TestCaseExtension.php';

/**
 * Class CourseCatalogServiceTest
 */
class CourseCatalogServiceTest extends TestCaseExtension
{

	/**
	 * @var Soap\SoapServiceRouter
	 */
	protected $soap_client_router;

	protected function setUp(): void
	{
		parent::setUp();

		$this->soap_client_router = new Soap\SoapServiceRouter($this->log);
		$this->soap_client_router->setSoapClientCourseCatalog($this->createSoapClientMock());
	}

	public function test_getRootIdOfTerm_shouldReturnValue()
	{
		$this->soap_client_router->getSoapClientCourseCatalog()->method('__soapCall')
			->willReturn((object) ['rootIdOfTerm' => 6756876]);
		$soap_client = new Soap\CourseCatalogService($this->log, $this->soap_client_router);
		$value = $soap_client->getRootIdOfTerm(2017, 'WS');
		$this->assertEquals(6756876, $value);
	}

	public function test_getCourseCatalogLeaf_shouldReturnValue()
	{
		$this->soap_client_router->getSoapClientCourseCatalog()->method('__soapCall')
						   ->willReturn(simplexml_load_string(file_get_contents('test/fixtures/course_catalog_leaf.xml')));
		$soap_client = new Soap\CourseCatalogService($this->log, $this->soap_client_router);
		$value = $soap_client->getCourseCatalogLeaf(6756876);
		$this->assertInstanceOf('\HisInOneProxy\DataModel\CourseCatalogLeaf', $value);
	}

	public function test_getChildren_shouldReturnValue()
	{
		$this->soap_client_router->getSoapClientCourseCatalog()->method('__soapCall')
						   ->willReturn(simplexml_load_string('<resp><courseCatalogChildrenList></courseCatalogChildrenList></resp>'));
		$soap_client = new Soap\CourseCatalogService($this->log, $this->soap_client_router);
		$leaf = new \HisInOneProxy\DataModel\CourseCatalogLeaf();
		$leaf->setId(1);
		$value = $soap_client->getChildren($leaf);
		$this->assertEquals(0, count($leaf->getChildren()));
	}

	public function test_getRootIdOfTerm_shouldLogErrors()
	{
		$this->soap_client_router->getSoapClientCourseCatalog()->method('__soapCall')
						  ->willThrowException(new SoapFault('Server', 'Course catalog root not found for term WS 2017.'));
		$soap_client = new Soap\CourseCatalogService($this->log, $this->soap_client_router );
		$soap_client->getRootIdOfTerm(2017, 'WS');
		$this->assertEqualClearedString('Error: Course catalog root not found for term WS 2017.', array_pop($this->collectedMessages));
	}

	public function test_getCourseCatalogLeaf_shouldLogErrors()
	{
		$this->soap_client_router->getSoapClientCourseCatalog()->method('__soapCall')
						  ->willThrowException(new SoapFault('Server', 'Course catalog leaf with id 6756876 not found.'));
		$soap_client = new Soap\CourseCatalogService($this->log, $this->soap_client_router );
		$soap_client->getCourseCatalogLeaf(6756876);
		$this->assertEqualClearedString('Error: Course catalog leaf with id 6756876 not found.', array_pop($this->collectedMessages));
	}

	public function test_getChildren_shouldLogErrors()
	{
		$this->soap_client_router->getSoapClientCourseCatalog()->method('__soapCall')
						  ->willThrowException(new SoapFault('Server', 'Course catalog children could not be loaded.'));
		$soap_client = new Soap\CourseCatalogService($this->log, $this->soap_client_router );
		$leaf = new \HisInOneProxy\DataModel\CourseCatalogLeaf();
		$leaf->setId(3);
		$soap_client->getChildren($leaf);
		$this->assertEqualClearedString('Error: Course catalog children could not be loaded.', array_pop($this->collectedMessages));
	}

	public function test_getUnitChildren_shouldLogErrors()
	{
		$this->soap_client_router->getSoapClientCourseCatalog()->method('__soapCall')
						  ->willThrowException(new SoapFault('Server', 'Unit children could not be loaded for catalog 6756876.'));
		$soap_client = new Soap\CourseCatalogService($this->log, $this->soap_client_router );
		$soap_client->getUnitChildren(6756876, 55, 2017);
		$this->assertEqualClearedString('Error: Unit children could not be loaded for catalog 6756876.', array_pop($this->collectedMessages));
	}

	public function test_getUnitChildren_shouldReturnValue()
	{
		$curriculum_service = $this->createMock(Soap\CurriculumDesignerService::class);
		$curriculum_service->method('readChildUnitRelations')
			->willReturn(new \HisInOneProxy\DataModel\Unit());
		$ref = new \ReflectionClass(\HisInOneProxy\Soap\Interactions\DataCache::class);
		$prop = $ref->getProperty('curriculum_designer_service');
		$prop->setAccessible(true);
		$prop->setValue(null, $curriculum_service);

		$this->soap_client_router->getSoapClientCourseCatalog()->method('__soapCall')
						   ->willReturn(simplexml_load_string('<resp>' . file_get_contents('test/fixtures/visible_children.xml') . '</resp>'));
		$soap_client = new Soap\CourseCatalogService($this->log, $this->soap_client_router);
		$value = $soap_client->getUnitChildren(6756876, 55, 2017);
		$this->assertEquals(1, count($value));
	}

	public function test_getCourseCatalogElementIdsForPlanElement_shouldLogErrors()
	{
		$this->soap_client_router->getSoapClientCourseCatalog()->method('__soapCall')
								 ->willThrowException(new SoapFault('Server', 'Plan element mapping not found for catalog 6756876.'));
		$soap_client = new Soap\CourseCatalogService($this->log, $this->soap_client_router );
		$soap_client->getCourseCatalogElementIdsForPlanElement(6756876);
		$this->assertEqualClearedString('Error: Plan element mapping not found for catalog 6756876.', array_pop($this->collectedMessages));
	}

	public function test_getCourseCatalogElementIdsForPlanElement_shouldReturnValue()
	{
		$this->soap_client_router->getSoapClientCourseCatalog()->method('__soapCall')
								 ->willReturn(simplexml_load_string('<resp>' . file_get_contents('test/fixtures/course_catalog_element_ids.xml') . '</resp>'));
		$soap_client = new Soap\CourseCatalogService($this->log, $this->soap_client_router);
		$value = $soap_client->getCourseCatalogElementIdsForPlanElement(6756876);
		$this->assertEquals(1, $value->getSizeOfContainer());
	}

}
