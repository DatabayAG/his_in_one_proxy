<?php

include_once './libs/composer/vendor/autoload.php';

require_once 'test/TestCaseExtension.php';

use HisInOneProxy\Soap;

/**
 * Class ValueServiceTest
 */
class ValueServiceTest extends TestCaseExtension
{
	/**
	 * @var Soap\SoapServiceRouter
	 */
	protected $soap_client_router;

	protected function setUp()
	{
		parent::setUp();
		$this->soap_client_router = new Soap\SoapServiceRouter($this->log);
		$this->soap_client_router->setSoapClientValueService($this->getMockFromWsdl(\HisInOneProxy\Config\GlobalSettings::getInstance()->getHisServerUrl().'ValueService.wsdl'));
	}

	protected function initEmptySoapClientService()
	{
		$this->soap_client_router->getSoapClientValueService()->expects($this->any())
								 ->method('__soapCall')
								 ->willReturn(simplexml_load_string('<resp></resp>'));
	}

	public function test_getAllTermTypes_shouldReturnValue()
	{
		$this->soap_client_router->getSoapClientValueService()->expects($this->any())
			->method('__soapCall')
			->willReturn(simplexml_load_string('<resp><listOfTermTypes>'.file_get_contents('test/fixtures/term_type.xml').'</listOfTermTypes></resp>'));
		$soap_client = new Soap\ValueService($this->log, $this->soap_client_router);
		$value = $soap_client->getAllTermTypes(12);
		$this->assertEquals(array(), $value);
	}

	public function test_getAllEAddressTypes_shouldReturnValue()
	{
		$this->soap_client_router->getSoapClientValueService()->expects($this->any())
			->method('__soapCall')
			->willReturn(simplexml_load_string('<resp>'.file_get_contents('test/fixtures/e_address_type.xml').'</resp>'));
		$soap_client = new Soap\ValueService($this->log, $this->soap_client_router);
		$value = $soap_client->getAllEAddressTypes(12);
		$this->assertEquals('23412', $value['23412']->getId());
	}

	public function test_getAllEAddressTags_shouldReturnValue()
	{
		$this->soap_client_router->getSoapClientValueService()->expects($this->any())
								 ->method('__soapCall')
								 ->willReturn(simplexml_load_string('<resp>'.file_get_contents('test/fixtures/e_address_tag.xml').'</resp>'));
		$soap_client = new Soap\ValueService($this->log, $this->soap_client_router);
		$value = $soap_client->getAllEAddressTags(12);
		$this->assertEquals('23412', $value['23412']->getId());
	}

	public function test_getAllParallelGroups_shouldReturnValue()
	{
		$this->soap_client_router->getSoapClientValueService()->expects($this->any())
								 ->method('__soapCall')
								 ->willReturn(simplexml_load_string('<resp>'.file_get_contents('test/fixtures/parallel_groups.xml').'</resp>'));
		$soap_client = new Soap\ValueService($this->log, $this->soap_client_router);
		$value = $soap_client->getAllParallelGroups(12);
		$this->assertEquals('MyName', $value->getGroupValueById('23412')->getUniqueName());
	}

	public function test_getAllElearningPlattforms_shouldReturnValue()
	{
		$this->soap_client_router->getSoapClientValueService()->expects($this->any())
								 ->method('__soapCall')
								 ->willReturn(simplexml_load_string('<resp><listOfElearningPlatforms>'.file_get_contents('test/fixtures/elearning_platform.xml').'</listOfElearningPlatforms></resp>'));
		$soap_client = new Soap\ValueService($this->log, $this->soap_client_router);
		$value = $soap_client->getAllElearningPlatforms(12);
		$this->assertEquals('My little platform', $value->translateIdToDefaultText('55'));
	}

	public function test_getAllCourseMappingTypes_shouldReturnValue()
	{
		$this->soap_client_router->getSoapClientValueService()->expects($this->any())
								 ->method('__soapCall')
								 ->willReturn(simplexml_load_string('<resp><listOfCourseMappingTypes>'.file_get_contents('test/fixtures/course_mapping_type.xml').'</listOfCourseMappingTypes></resp>'));
		$soap_client = new Soap\ValueService($this->log, $this->soap_client_router);
		$value = $soap_client->getAllCourseMappingTypes(12);
		$this->assertEquals('TotallyUnique2', $value->translateIdToDefaultText('342'));
	}

	public function test_getDefaultLanguageId_shouldReturnValue()
	{
		$this->soap_client_router->getSoapClientValueService()->expects($this->any())
								 ->method('__soapCall')
								 ->willReturn(simplexml_load_string('<resp><listOfLanguages><languagevalue><defaultlanguage>12</defaultlanguage></languagevalue></listOfLanguages></resp>'));
		$soap_client = new Soap\ValueService($this->log, $this->soap_client_router);
		$value = $soap_client->getDefaultLanguageId();
		$this->assertEquals('12', $value);
	}

	public function test_getAllWorkStatus_shouldReturnValue()
	{
		$this->soap_client_router->getSoapClientValueService()->expects($this->any())
								 ->method('__soapCall')
								 ->willReturn(simplexml_load_string('<resp><listOfWorkstatus>'.file_get_contents('test/fixtures/work_status_value.xml').'</listOfWorkstatus></resp>'));
		$soap_client = new Soap\ValueService($this->log, $this->soap_client_router);
		$value = $soap_client->getAllWorkStatus(12);
		$this->assertEquals('My little workstatus', $value->translateIdToDefaultText(23));
	}

	public function test_getAllPurposes_shouldReturnValue()
	{
		$this->soap_client_router->getSoapClientValueService()->expects($this->any())
								 ->method('__soapCall')
								 ->willReturn(simplexml_load_string('<resp>'.file_get_contents('test/fixtures/purpose.xml').'</resp>'));
		$soap_client = new Soap\ValueService($this->log, $this->soap_client_router);
		$value = $soap_client->getAllPurposes(12);
		$this->assertEquals('MyName', $value['23412']->getUniqueName());
	}

	public function test_getAllGenders_shouldReturnValue()
	{
		$this->soap_client_router->getSoapClientValueService()->expects($this->any())
								 ->method('__soapCall')
								 ->willReturn(simplexml_load_string('<resp>'.file_get_contents('test/fixtures/gender.xml').'</resp>'));
		$soap_client = new Soap\ValueService($this->log, $this->soap_client_router);
		$value = $soap_client->getAllGenders(12);
		$this->assertEquals('MyName', $value['23412']->getUniqueName());
	}

	public function test_getAllLanguages_shouldReturnValue()
	{
		$this->soap_client_router->getSoapClientValueService()->expects($this->any())
								 ->method('__soapCall')
								 ->willReturn(simplexml_load_string('<resp>'.file_get_contents('test/fixtures/language.xml').'</resp>'));
		$soap_client = new Soap\ValueService($this->log, $this->soap_client_router);
		$value = $soap_client->getAllLanguages(12);
		$this->assertEquals('MyName', $value['23412']->getUniqueName());
	}

	public function test_getAllFieldOfStudies_shouldReturnValue()
	{
		$this->soap_client_router->getSoapClientValueService()->expects($this->any())
								 ->method('__soapCall')
								 ->willReturn(simplexml_load_string('<resp>'.file_get_contents('test/fixtures/field_of_study.xml').'</resp>'));
		$soap_client = new Soap\ValueService($this->log, $this->soap_client_router);
		$value = $soap_client->getAllFieldOfStudies(12);
		$this->assertEquals('MyName', $value['23412']->getUniqueName());
	}

	public function test_getDefaultObjectType_shouldReturnValue()
	{
		$this->soap_client_router->getSoapClientValueService()->expects($this->any())
								 ->method('__soapCall')
								 ->willReturn(simplexml_load_string('<resp>'.file_get_contents('test/fixtures/field_of_study.xml').'</resp>'));
		$soap_client = new Soap\ValueService($this->log, $this->soap_client_router);
		$value = $this->callMethod($soap_client, 'getDefaultObjectType', array(12, 'getAllFieldOfStudies', 'listOfFieldOfStudies', 'fieldofstudyvalue'));
		$this->assertEquals('MyName', $value['23412']->getUniqueName());
	}

	public function test_getAllOrgUnitTypes_shouldReturnValue()
	{
		$this->soap_client_router->getSoapClientValueService()->expects($this->any())
								 ->method('__soapCall')
								 ->willReturn(simplexml_load_string('<resp>
									<listOfOrgunittypes>
									<orgunittypevalue><id>23</id><uniquename>Hello</uniquename></orgunittypevalue>
									</listOfOrgunittypes>
									</resp>'));
		$soap_client = new Soap\ValueService($this->log, $this->soap_client_router);
		$value = $soap_client->getAllOrgUnitTypes(12);
		$this->assertEquals('Hello', $value['23']->getUniqueName());
	}

	public function test_getAllPersonGroupCategories_shouldReturnValue()
	{
		$this->soap_client_router->getSoapClientValueService()->expects($this->any())
								 ->method('__soapCall')
								 ->willReturn(simplexml_load_string('<resp>
									<listOfPersonGroupCategories>
									<persongroupcategoryvalue><id>23</id><uniquename>Hello2</uniquename></persongroupcategoryvalue>
									</listOfPersonGroupCategories>
									</resp>'));
		$soap_client = new Soap\ValueService($this->log, $this->soap_client_router);
		$value = $soap_client->getAllPersonGroupCategories(12);
		$this->assertEquals('Hello2', $value['23']->getUniqueName());
	}

	public function test_getAllOrgunitAttributes_shouldReturnValue()
	{
		$this->soap_client_router->getSoapClientValueService()->expects($this->any())
								 ->method('__soapCall')
								 ->willReturn(simplexml_load_string('<resp>
									<listOfOrgunitAttributes>
									<orgunitattributevalue><id>24</id><uniquename>Hello332</uniquename></orgunitattributevalue>
									</listOfOrgunitAttributes>
									</resp>'));
		$soap_client = new Soap\ValueService($this->log, $this->soap_client_router);
		$value = $soap_client->getAllOrgUnitAttributes(12);
		$this->assertEquals('Hello332', $value['24']->getUniqueName());
	}

	public function test_getAllMajorFieldOfStudies_shouldReturnValue()
	{
		$this->soap_client_router->getSoapClientValueService()->expects($this->any())
								 ->method('__soapCall')
								 ->willReturn(simplexml_load_string('<resp>
									<listOfMajorFieldOfStudies>
									<majorfieldofstudy><id>26</id><uniquename>Hello33332</uniquename></majorfieldofstudy>
									</listOfMajorFieldOfStudies>
									</resp>'));
		$soap_client = new Soap\ValueService($this->log, $this->soap_client_router);
		$value = $soap_client->getAllMajorFieldOfStudies(12);
		$this->assertEquals('Hello33332', $value['26']->getUniqueName());
	}

	public function test_getAllExternalSystems_shouldReturnValue()
	{
		$this->soap_client_router->getSoapClientValueService()->expects($this->any())
								 ->method('__soapCall')
								 ->willReturn(simplexml_load_string('<resp>
									<listOfExternalsystems>
									<externalsystemvalue><id>27</id><uniquename>Hello33asdasd</uniquename></externalsystemvalue>
									</listOfExternalsystems>
									</resp>'));
		$soap_client = new Soap\ValueService($this->log, $this->soap_client_router);
		$value = $soap_client->getAllExternalSystems(12);
		$this->assertEquals('Hello33asdasd', $value['27']->getUniqueName());
	}

	public function test_AllMethods_shouldLogError()
	{
		$this->initEmptySoapClientService();
		$soap_client = new Soap\ValueService($this->log, $this->soap_client_router);

		$map = array(
			'getAllTermTypes' => 'Error: No list of term types object found in response!',
			'getAllEAddressTypes' => 'Error: No list of EAddresstype types object found in response!',
			'getAllEAddressTags' => 'Error: No list of EAddressTag object found in response!',
			'getAllParallelGroups' => 'Error: No list of ParallelGroup object found in response!',
			'getAllElearningPlatforms' => 'Error: No elearning plattform object found in response!',
			'getAllCourseMappingTypes' => 'Error: No course mapping type object found in response!',
			'getDefaultLanguageId' => 'Error: No default languages value found in response!',
			'getAllWorkStatus' => 'Error: No list of work status object found in response!',
			'getAllPurposes' => 'Error: No list of purposes found in response!',
			'getAllGenders' => 'Error: No list of genders found in response!',
			'getAllLanguages' => 'Error: No list of languages found in response!',
			'getAllFieldOfStudies' => 'Error: No list of field of studies found in response!',
			'getAllExternalSystems' => 'Error: No list of default object found in response!',
			'getAllMajorFieldOfStudies' => 'Error: No list of default object found in response!',
			'getAllOrgunitAttributes' => 'Error: No list of default object found in response!',
			'getAllPersonGroupCategories' => 'Error: No list of default object found in response!',
			'getAllOrgUnitTypes' => 'Error: No list of default object found in response!'
		);
		foreach($map as $func => $msg)
		{
			$soap_client->{$func}(12);
			$act_msg = array_pop($this->collectedMessages);
			$this->assertEquals($msg, $act_msg);
		}
	}

}