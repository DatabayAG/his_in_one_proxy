<?php

include_once './libs/composer/vendor/autoload.php';

use HisInOneProxy\Soap;

require_once 'test/TestCaseExtension.php';

class CourseCatalogServiceTest extends TestCaseExtension
{

	/**
	 * @var Soap\SoapServiceRouter
	 */
	protected $soap_client_router;

	protected function setUp()
	{
		parent::setUp();

		$this->soap_client_router = new Soap\SoapServiceRouter($this->log);
		$this->soap_client_router->setSoapClientCourseCatalog($this->getMockFromWsdl(\HisInOneProxy\Config\GlobalSettings::getInstance()->getHisServerUrl().'CourseCatalogService.wsdl'));
	}

	public function test_getRootIdOfTerm_shouldReturnValue()
	{
		$this->soap_client_router->getSoapClientCourseCatalog()->expects($this->any())
			->method('__soapCall')
			->willReturn((object) ['rootIdOfTerm' => 4444]);
		$soap_client = new Soap\CourseCatalogService($this->log, $this->soap_client_router);
		$value = $soap_client->getRootIdOfTerm(1999, 'bla');
		$this->assertEquals(4444, $value);
	}

	public function test_getCourseCatalogLeaf_shouldReturnValue()
	{
		$this->soap_client_router->getSoapClientCourseCatalog()->expects($this->any())
						   ->method('__soapCall')
						   ->willReturn(simplexml_load_string(file_get_contents('test/fixtures/course_catalog_leaf.xml')));
		$soap_client = new Soap\CourseCatalogService($this->log, $this->soap_client_router);
		$value = $soap_client->getCourseCatalogLeaf(4444);
		$this->assertInstanceOf('\HisInOneProxy\DataModel\CourseCatalogLeaf', $value);
	}

	public function test_getChildren_shouldReturnValue()
	{
		$this->soap_client_router->getSoapClientCourseCatalog()->expects($this->any())
						   ->method('__soapCall')
						   ->willReturn(simplexml_load_string('' . file_get_contents('test/fixtures/course_catalog_children.xml') . ''));
		$soap_client = new Soap\CourseCatalogService($this->log, $this->soap_client_router);
		$leaf = new \HisInOneProxy\DataModel\CourseCatalogLeaf();
		$leaf->setId(1);
		$value = $soap_client->getChildren($leaf);
		$this->assertEquals(0, count($leaf->getChildren()));
	}

	public function test_getRootIdOfTerm_shouldLogErrors()
	{
		$this->soap_client_router->getSoapClientCourseCatalog()->expects($this->any())
						  ->method('__soapCall')
						  ->will($this->throwException(new SoapFault('Server', 'Something horrible happened here.')));
		$soap_client = new Soap\CourseCatalogService($this->log, $this->soap_client_router );
		$soap_client->getRootIdOfTerm(1999, 'bla');
		$this->assertEquals('Error: Something horrible happened here.', array_pop($this->collectedMessages));
	}

	public function test_getCourseCatalogLeaf_shouldLogErrors()
	{
		$this->soap_client_router->getSoapClientCourseCatalog()->expects($this->any())
						  ->method('__soapCall')
						  ->will($this->throwException(new SoapFault('Server', 'Something horrible happened to the leafs.')));
		$soap_client = new Soap\CourseCatalogService($this->log, $this->soap_client_router );
		$soap_client->getCourseCatalogLeaf(4444);
		$this->assertEquals('Error: Something horrible happened to the leafs.', array_pop($this->collectedMessages));
	}

	public function test_getChildren_shouldLogErrors()
	{
		$this->soap_client_router->getSoapClientCourseCatalog()->expects($this->any())
						  ->method('__soapCall')
						  ->will($this->throwException(new SoapFault('Server', 'Something horrible happened to the children.')));
		$soap_client = new Soap\CourseCatalogService($this->log, $this->soap_client_router );
		$leaf = new \HisInOneProxy\DataModel\CourseCatalogLeaf();
		$leaf->setId(3);
		$soap_client->getChildren($leaf);
		$this->assertEquals('Error: Something horrible happened to the children.', array_pop($this->collectedMessages));
	}

	public function test_getUnitChildren_shouldLogErrors()
	{
		$this->soap_client_router->getSoapClientCourseCatalog()->expects($this->any())
						  ->method('__soapCall')
						  ->will($this->throwException(new SoapFault('Server', 'Something horrible happened to the unit children.')));
		$soap_client = new Soap\CourseCatalogService($this->log, $this->soap_client_router );
		$soap_client->getUnitChildren(4444, 44, 1998);
		$this->assertEquals('Error: Something horrible happened to the unit children.', array_pop($this->collectedMessages));
	}

	public function test_getUnitChildren_shouldReturnValue()
	{
		$this->soap_client_router->getSoapClientCourseCatalog()->expects($this->any())
						   ->method('__soapCall')
						   ->willReturn(simplexml_load_string('<resp>' . file_get_contents('test/fixtures/visible_children.xml') . '</resp>'));
		$soap_client = new Soap\CourseCatalogService($this->log, $this->soap_client_router);
		$value = $soap_client->getUnitChildren(4444, 2222, 1900);
		$this->assertEquals(1, count($value));
	}

	public function test_getCourseCatalogElementIdsForPlanElement_shouldLogErrors()
	{
		$this->soap_client_router->getSoapClientCourseCatalog()->expects($this->any())
								 ->method('__soapCall')
								 ->will($this->throwException(new SoapFault('Server', 'Something horrible happened to the plan element.')));
		$soap_client = new Soap\CourseCatalogService($this->log, $this->soap_client_router );
		$soap_client->getCourseCatalogElementIdsForPlanElement(4444);
		$this->assertEquals('Error: Something horrible happened to the plan element.', array_pop($this->collectedMessages));
	}

	public function test_ggetCourseCatalogElementIdsForPlanElement_shouldReturnValue()
	{
		$this->soap_client_router->getSoapClientCourseCatalog()->expects($this->any())
								 ->method('__soapCall')
								 ->willReturn(simplexml_load_string('<resp>' . file_get_contents('test/fixtures/visible_children.xml') . '</resp>'));
		$soap_client = new Soap\CourseCatalogService($this->log, $this->soap_client_router);
		$value = $soap_client->getCourseCatalogElementIdsForPlanElement(4444);
		$this->assertEquals(1, count($value));
	}

}