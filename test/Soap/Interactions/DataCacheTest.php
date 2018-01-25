<?php

require_once 'test/TestCaseExtension.php';
use HisInOneProxy\Soap\Interactions\DataCache;

/**
 * Class DataCacheTest
 */
class DataCacheTest extends TestCaseExtension
{

	/**
	 * @var HisInOneProxy\Soap\SoapServiceRouter
	 */
	protected $soap_client_router;

	/**
	 * @var DataCache
	 */
	protected $instance;

	protected function setUp()
	{
		parent::setUp();
		$this->instance = DataCache::getInstance();
		$this->soap_client_router = new HisInOneProxy\Soap\SoapServiceRouter($this->log);
	}

	public function test_getInstance_shouldReturnInstance()
	{
		$this->assertInstanceOf('HisInOneProxy\Soap\Interactions\DataCache', $this->instance);
	}

	public function test_getTermTypeList_shouldReturnNull()
	{
		TestCaseExtension::callMethod(
			$this->instance,
			'setTermTypeList',
			array(null)
		);
		$values = $this->instance->getTermTypeList();
		$this->assertEquals(null, $values);
	}

	/*public function test_getWorkStatus_shouldReturnNull()
	{
		$values = DataCache::getInstance()->getWorkStatus();
		$this->assertEquals(null, $values);
	}*/

	public function test_getDefaultLanguageId_shouldReturnNull()
	{
		TestCaseExtension::callMethod(
			$this->instance,
			'setDefaultLanguageId',
			array(null)
		);
		$values = $this->instance->getDefaultLanguageId();
		$this->assertEquals(null, $values);
	}

	public function test_getParallelGroupValues_shouldReturnNull()
	{
		$this->instance->setParallelGroupValues(null);
		$values = $this->instance->getParallelGroupValues();
		$this->assertEquals(null, $values);
	}

	public function test_getIrrelevantForExport_shouldReturnValue()
	{
		$values = $this->instance->getIrrelevantForExport();
		$this->assertEquals(0, $values);
		$this->instance->incrementIrrelevantForExport();
		$values = $this->instance->getIrrelevantForExport();
		$this->assertEquals(1, $values);
	}

	public function test_getRelevantForExport_shouldReturnValue()
	{
		$values = $this->instance->getRelevantForExport();
		$this->assertEquals(0, $values);
		$this->instance->incrementRelevantForExport();
		$values = $this->instance->getRelevantForExport();
		$this->assertEquals(1, $values);
	}

	public function test_getTermTypeValues_shouldReturnNull()
	{
		$values = $this->instance->getTermTypeValues();
		$this->assertEquals(null, $values);
	}

	/*public function test_getElearningPlatformContainer_shouldReturnNull()
	{
		$values = $this->instance->getElearningPlatformContainer();
		$this->assertEquals(null, $values);
	}*/

	public function test_getCourseMappingTypeContainer_shouldReturnNull()
	{
		TestCaseExtension::callMethod(
			$this->instance,
			'setCourseMappingTypeContainer',
			array(null)
		);
		$values = $this->instance->getCourseMappingTypeContainer();
		$this->assertEquals(null, $values);
	}

	public function test_getPersonDetails_shouldReturnNull()
	{
		$values = $this->instance->getPersonDetails(76436563245);
		$this->assertEquals(null, $values);
	}

	public function test_getRouter_shouldReturnInstance()
	{
		$instance = $this->instance->getRouter();
		$this->assertInstanceOf('HisInOneProxy\Soap\SoapServiceRouter', $instance);
	}

	public function test_getCourseInterfaceService_shouldReturnInstance()
	{
		$instance = $this->instance->getCourseInterfaceService();
		$this->assertInstanceOf('HisInOneProxy\Soap\CourseInterfaceService', $instance);
	}

	public function test_getCourseService_shouldReturnInstance()
	{
		$instance = $this->instance->getCourseService();
		$this->assertInstanceOf('HisInOneProxy\Soap\CourseService', $instance);
	}

	public function test_getOrgUnitService_shouldReturnInstance()
	{
		$instance = $this->instance->getOrgUnitService();
		$this->assertInstanceOf('HisInOneProxy\Soap\OrgUnitService', $instance);
	}

	public function test_getCourseOfStudyService_shouldReturnInstance()
	{
		$instance = $this->instance->getCourseOfStudyService();
		$this->assertInstanceOf('HisInOneProxy\Soap\CourseOfStudyService', $instance);
	}

	public function test_getUnitService_shouldReturnInstance()
	{
		$instance = $this->instance->getUnitService();
		$this->assertInstanceOf('HisInOneProxy\Soap\UnitService', $instance);
	}

	public function test_getValueService_shouldReturnInstance()
	{
		$instance =$this->instance->getValueService();
		$this->assertInstanceOf('HisInOneProxy\Soap\ValueService', $instance);
	}

	public function test_getCourseCatalogService_shouldReturnInstance()
	{
		$instance = $this->instance->getCourseCatalogService();
		$this->assertInstanceOf('HisInOneProxy\Soap\CourseCatalogService', $instance);
	}

	public function test_getPersonService_shouldReturnInstance()
	{
		$instance = $this->instance->getPersonService();
		$this->assertInstanceOf('HisInOneProxy\Soap\PersonService', $instance);
	}

	public function test_getStudentService_shouldReturnInstance()
	{
		$instance = $this->instance->getStudentService();
		$this->assertInstanceOf('HisInOneProxy\Soap\StudentService', $instance);
	}

	public function test_getTermService_shouldReturnInstance()
	{
		$instance = $this->instance->getTermService();
		$this->assertInstanceOf('HisInOneProxy\Soap\TermService', $instance);
	}

	public function test_getAccountService_shouldReturnInstance()
	{
		$instance = $this->instance->getAccountService();
		$this->assertInstanceOf('HisInOneProxy\Soap\AccountService', $instance);
	}

	public function test_resolveEAddressTypeById_shouldNull()
	{
		$e_address = new \HisInOneProxy\DataModel\EAddressType();
		$e_address->setId(1);
		$e_address->setDefaultText('Text');
		$this->instance->setEAddressTypes(array( "1" => $e_address));
		$instance = $this->instance->resolveEAddressTypeById(1);
		$this->assertNotNull($instance);
	}

	public function test_appendPersonIdToCache_shouldReturnInstance()
	{
		$this->assertEquals(null, $this->instance->getPersonDetails(4));
		$this->instance->appendPersonIdToCache(4);
		$this->assertEquals(4, $this->instance->getPersonDetails(4));
	}

	public function test_appendToChildRelationMap_shouldReturnInstance()
	{
		$this->assertEquals(null, $this->instance->getParentForChild(2));
		$relation = new \HisInOneProxy\DataModel\ChildRelation();
		$relation->setParentId(1);
		$relation->setChildId(2);
		$this->instance->appendToChildRelationMap($relation);
		$this->assertEquals(1, $this->instance->getParentForChild(2));
		$this->assertEquals(1, count($this->instance->getChildRelationMap()));
	}
	
	public function test_invalidatePersonInCache_shouldInvalidatePerson()
	{
		$per = new \HisInOneProxy\DataModel\Person();
		$per->setId(23);
		$per->setFirstName('Jürgen');
		$per->setSurName('Otto');
		$per->setTitleId(2);
		$this->instance->addPersonDetails($per);
		$this->assertEquals('Jürgen', $this->instance->getPersonDetails(23)->getFirstName());
		$this->instance->invalidatePersonInCache(23);
		$this->assertEquals(23, $this->instance->getPersonDetails(23));
	}

	public function test_getUnitCache_shouldReturnUnitCache()
	{
		TestCaseExtension::callMethod(
			DataCache::getInstance(),
			'setUnitCache',
			array(array())
		);
		$unit = new \HisInOneProxy\DataModel\Unit();
		$unit->setId(2333);

		$this->instance->appendUnitCache($unit);
		$this->assertEquals(1, count($this->instance->getUnitCache()));

		$unit = new \HisInOneProxy\DataModel\Unit();
		$unit->setId(22333);
		$this->instance->appendUnitCache($unit);
		$this->assertEquals(2, count($this->instance->getUnitCache()));
	}
	
	public function test_readPersonDetailsToCache_shouldReturnPersonCache()
	{
		TestCaseExtension::callMethod(
			DataCache::getInstance(),
			'setPersonCache',
			array(array())
		);

		$person = new \HisInOneProxy\DataModel\Person();
		$person->setId(4444);
		$this->instance->addPersonDetails($person);
		$obj = $this->instance->readPersonDetailsToCache();
		$this->assertEquals(1, count($obj));
	}

	public function test_setCourseService_shouldShouldSetCourseService()
	{
		TestCaseExtension::callMethod(
			$this->instance,
			'setCourseService',
			array(null)
		);
		$this->assertEquals(null, $this->instance->getCourseService());
	}
}