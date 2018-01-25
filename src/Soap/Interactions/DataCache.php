<?php

namespace HisInOneProxy\Soap\Interactions;

use HisInOneProxy\DataModel\ChildRelation;
use HisInOneProxy\DataModel\CompleteAccount;
use HisInOneProxy\DataModel\Container\CourseMappingTypeContainer;
use HisInOneProxy\DataModel\Container\ElearningPlatformContainer;
use HisInOneProxy\DataModel\Container\ParallelGroupValuesContainer;
use HisInOneProxy\DataModel\Container\TermTypeList;
use HisInOneProxy\DataModel\Container\WorkStatusContainer;
use HisInOneProxy\DataModel\EAddressType;
use HisInOneProxy\DataModel\Person;
use HisInOneProxy\DataModel\Unit;
use HisInOneProxy\Log\Log;
use HisInOneProxy\Soap\AccountService;
use HisInOneProxy\Soap\AddressService;
use HisInOneProxy\Soap\CourseCatalogService;
use HisInOneProxy\Soap\CourseInterfaceService;
use HisInOneProxy\Soap\CourseOfStudyService;
use HisInOneProxy\Soap\CourseService;
use HisInOneProxy\Soap\OrgUnitService;
use HisInOneProxy\Soap\PersonService;
use HisInOneProxy\Soap\SoapServiceRouter;
use HisInOneProxy\Soap\StudentService;
use HisInOneProxy\Soap\TermService;
use HisInOneProxy\Soap\UnitService;
use HisInOneProxy\Soap\ValueService;

/**
 * Class DataCache
 * @package HisInOneProxy\Soap\Interactions
 */
class DataCache
{


	const STUDENT = 1;
	const COURSE_ADMINISTRATOR = 0;
	const TUTOR = 2;

	/**
	 * @var ParallelGroupValuesContainer
	 */
	protected static $parallel_group_values;

	/**
	 * @var ElearningPlatformContainer
	 */
	protected static $elearning_platforms_values;

	/**
	 * @var CourseMappingTypeContainer
	 */
	protected static $course_mapping_types;

	/**
	 * @var WorkStatusContainer
	 */
	protected static $work_status;
	
	/**
	 * @var TermTypeList
	 */
	protected static $term_type_values;

	/**
	 * @var SoapServiceRouter
	 */
	protected static $router;

	/**
	 * @var int
	 */
	protected static $relevant_for_export = 0;

	/**
	 * @var int
	 */
	protected static $irrelevant_for_export = 0;

	/**
	 * @var CourseInterfaceService
	 */
	protected static $course_interface_service;

	/**
	 * @var OrgUnitService
	 */
	protected static $org_unit_service;

	/**
	 * @var CourseOfStudyService
	 */
	protected static $course_of_study_service;

	/**
	 * @var CourseCatalogService
	 */
	protected static $course_catalog_service;

	/**
	 * @var StudentService
	 */
	protected static $student_service;

	/**
	 * @var AddressService
	 */
	protected static $address_service;

	/**
	 * @var PersonService
	 */
	protected static $person_service;

	/**
	 * @var UnitService
	 */
	protected static $unit_service;
	
	/**
	 * @var ValueService
	 */
	protected static $value_service;

	/**
	 * @var TermService
	 */
	protected static $term_service;

	/**
	 * @var CourseService
	 */
	protected static $course_service;

	/**
	 * @var AccountService
	 */
	protected static $account_service;

	/**
	 * @var
	 */
	protected static $default_lang_id;

	/**
	 * @var Log
	 */
	protected static $log;

	/**
	 * @var []
	 */
	protected static $person_cache = array();

	/**
	 * @var []
	 */
	protected static $student_cache = array();
	/**+
	 * @var self
	 */
	protected static $instance = null;
	/**
	 * @var array
	 */
	protected $unit_cache = array();
	/**
	 * @var array
	 */
	protected $child_relation_map = array();

	/**
	 * @var array
	 */
	protected $accounts = array();

	/**
	 * @var array
	 */
	protected static $e_address_type_list = array();

	/**
	 * @var array
	 */
	protected static $purposes_list = array();

	/**
	 * @return self
	 */
	public static function getInstance()
	{
		if(self::$instance instanceof self)
		{
			return self::$instance;
		}

		self::$instance = self::init();

		return self::$instance;
	}

	/**
	 * @return DataCache
	 */
	protected static function init()
	{
		self::$log = new Log();
		self::initializeRouterAndServices();

		self::readDefaultLanguage();
		self::readParallelGroupValues();
		self::readTermTypeValues();
		self::readElearningPlatforms();
		self::readCourseMappingTypes();
		self::readWorkStatus();
		self::readEAddressTypes();
		self::readAllPurposes();
		return new DataCache();
	}

	/**
	 * 
	 */
	protected static function initializeRouterAndServices()
	{
		self::$router                   = new SoapServiceRouter(self::$log);

		self::$course_catalog_service   = new CourseCatalogService(self::$log, self::$router);
		self::$course_interface_service = new CourseInterfaceService(self::$log, self::$router);
		self::$course_of_study_service  = new CourseOfStudyService(self::$log, self::$router);
		self::$course_service           = new CourseService(self::$log, self::$router);
		self::$org_unit_service         = new OrgUnitService(self::$log, self::$router);
		self::$person_service           = new PersonService(self::$log, self::$router);
		self::$student_service          = new StudentService(self::$log, self::$router);
		self::$term_service             = new TermService(self::$log, self::$router);
		self::$unit_service             = new UnitService(self::$log, self::$router);
		self::$value_service            = new ValueService(self::$log, self::$router);
		self::$account_service          = new AccountService(self::$log, self::$router);
		self::$address_service          = new AddressService(self::$log, self::$router);
	}

	protected static function readDefaultLanguage()
	{
		self::$default_lang_id = self::$value_service->getDefaultLanguageId();
	}
	
	protected static function readParallelGroupValues()
	{
		self::$parallel_group_values = self::$value_service->getAllParallelGroups(self::$default_lang_id);
	}

	protected static function readTermTypeValues()
	{
		self::$term_type_values = self::$value_service->getAllTermTypes(self::$default_lang_id);
	}

	protected static function readElearningPlatforms()
	{
		self::$elearning_platforms_values = self::$value_service->getAllElearningPlatforms(self::$default_lang_id);
	}

	protected static function readCourseMappingTypes()
	{
		self::$course_mapping_types = self::$value_service->getAllCourseMappingTypes(self::$default_lang_id);
	}
	
	protected static function readWorkStatus()
	{
		self::$work_status = self::$value_service->getAllWorkStatus(self::$default_lang_id);
	}

	protected static function readEAddressTypes()
	{
		self::$e_address_type_list = self::$value_service->getAllEAddressTypes(self::$default_lang_id);
	}

	protected static function readAllPurposes()
	{
		self::$purposes_list = self::$value_service->getAllPurposes(self::$default_lang_id);
	}

	/**
	 * @return CourseService
	 */
	public static function getCourseService()
	{
		return self::$course_service;
	}

	/**
	 * @param CourseService $course_service
	 */
	protected static function setCourseService($course_service)
	{
		self::$course_service = $course_service;
	}

	/**
	 * @return TermService
	 */
	public static function getTermService()
	{
		return self::$term_service;
	}

	/**
	 * @param Log $log
	 */
	public function setLog($log)
	{
		self::$log = $log;
	}

	/**
	 * @return TermTypeList
	 */
	public function getTermTypeList()
	{
		return self::$term_type_values;
	}

	/**
	 * @param $term_type_list
	 */
	protected function setTermTypeList($term_type_list)
	{
		self::$term_type_values = $term_type_list;
	}

	/**
	 * @return WorkStatusContainer
	 */
	public function getWorkStatus()
	{
		return self::$work_status;
	}

	/**
	 * @param $work_status_container
	 */
	public function setWorkStatus($work_status_container)
	{
		self::$work_status = $work_status_container;
	}

	/**
	 * @return int
	 */
	public function getDefaultLanguageId()
	{
		return self::$default_lang_id;
	}

	/**
	 * @param $default_lang_id
	 */
	protected function setDefaultLanguageId($default_lang_id)
	{
		self::$default_lang_id = $default_lang_id;
	}

	/**
	 * @return ParallelGroupValuesContainer
	 */
	public function getParallelGroupValues()
	{
		return self::$parallel_group_values;
	}

	/**
	 * @param ParallelGroupValuesContainer $container
	 */
	public function setParallelGroupValues($container)
	{
		self::$parallel_group_values = $container;
	}

	/**
	 * @return int
	 */
	public function getIrrelevantForExport()
	{
		return self::$irrelevant_for_export;
	}

	public function incrementIrrelevantForExport()
	{
		self::$irrelevant_for_export++;
	}

	/**
	 * @return int
	 */
	public function getRelevantForExport()
	{
		return self::$relevant_for_export;
	}

	public function incrementRelevantForExport()
	{
		self::$relevant_for_export++;
	}

	/**
	 * @return TermTypeList
	 */
	public function getTermTypeValues()
	{
		return self::$term_type_values;
	}

	/**
	 * @return ElearningPlatformContainer
	 */
	public function getElearningPlatformContainer()
	{
		return self::$elearning_platforms_values;
	}

	/**
	 * @param ElearningPlatformContainer $container
	 */
	public function setElearningPlatformContainer($container)
	{
		self::$elearning_platforms_values = $container;
	}

	/**
	 * @return CourseMappingTypeContainer
	 */
	public function getCourseMappingTypeContainer()
	{
		return self::$course_mapping_types;
	}

	/**
	 * @param $course_mapping_types
	 */
	protected function setCourseMappingTypeContainer($course_mapping_types)
	{
		self::$course_mapping_types = $course_mapping_types;
	}

	/**
	 * @return SoapServiceRouter
	 */
	public function getRouter()
	{
		return self::$router;
	}

	/**
	 * @return CourseInterfaceService
	 */
	public function getCourseInterfaceService()
	{
		return self::$course_interface_service;
	}

	/**
	 * @return OrgUnitService
	 */
	public function getOrgUnitService()
	{
		return self::$org_unit_service;
	}

	/**
	 * @return CourseOfStudyService
	 */
	public function getCourseOfStudyService()
	{
		return self::$course_of_study_service;
	}

	/**
	 * @return UnitService
	 */
	public function getUnitService()
	{
		return self::$unit_service;
	}
	
	/**
	 * @return ValueService
	 */
	public function getValueService()
	{
		return self::$value_service;
	}

	/**
	 * @return CourseCatalogService
	 */
	public function getCourseCatalogService()
	{
		return self::$course_catalog_service;
	}
	
	/**
	 * @return AccountService
	 */
	public function getAccountService()
	{
		return self::$account_service;
	}

	/**
	 * @return Log
	 */
	public function getLog()
	{
		return self::$log;
	}

	/**
	 * @param $id
	 */
	public function appendPersonIdToCache($id)
	{
		$id = (int) $id;
		self::$person_cache[$id] = $id;
	}

	/**
	 * @param $id
	 * @return Person  | null
	 */
	public function getPersonDetails($id)
	{
		if(array_key_exists($id, self::$person_cache))
		{
			return self::$person_cache[$id];
		}
		return null;
	}

	/**
	 * @param $id
	 * @return string  | null
	 */
	public function resolveEAddressTypeById($id)
	{
		if(array_key_exists($id, self::$e_address_type_list))
		{
			return self::$e_address_type_list[$id]->getDefaultText();
		}
		return null;
	}

	/**
	 * @param $id
	 * @return string  | null
	 */
	public function resolvePurposeTypeById($id)
	{
		if(array_key_exists($id, self::$purposes_list))
		{
			return self::$purposes_list[$id]->getDefaultText();
		}
		return null;
	}

	/**
	 * @param EAddressType[] $e_address_types
	 */
	public function setEAddressTypes($e_address_types)
	{
		self::$e_address_type_list = $e_address_types;
	}

	/**
	 * @param Person $person
	 */
	public function addPersonDetails($person)
	{
		if( ! array_key_exists($person->getId(), self::$person_cache))
		{
			self::$person_cache[trim($person->getId())] = $person;
		}
	}

	/**
	 * @return array
	 */
	public function readPersonDetailsToCache()
	{
		foreach(self::$person_cache as $person_id)
		{
			if( ! is_a($person_id, 'HisInOneProxy\DataModel\Person'))
			{
				self::$person_cache[trim($person_id)] = self::getPersonService()->readPerson($person_id);
			}
		}
		return self::$person_cache;
	}

	/**
	 * @param Person $person
	 */
	public function addPersonDetailsToCache($person)
	{
		if($person instanceof Person)
		{
			self::$person_cache[trim($person->getId())] = $person;
		}
	}

	public function readAccountsForPersons()
	{
		foreach(self::$person_cache as $person)
		{
			if($person instanceof Person)
			{
				$this->accounts[trim($person->getId())] = self::getAccountService()->searchAccountForPerson61($person->getId());
			}
		}
	}

	/**
	 * @param $person
	 * @param $accounts
	 */
	public function addAccountsForPerson($person, $accounts)
	{
		if($person instanceof Person)
		{
			$this->accounts[trim($person->getId())] = $accounts;
		}
	}

	/**
	 * @param $id
	 * @return array
	 */
	public function getAccountsForPersonId($id)
	{
		if(array_key_exists($id, $this->accounts))
		{
			return $this->accounts[$id];
		}
	}

	/**
	 * @param $id
	 */
	public function invalidatePersonInCache($id)
	{
		if(array_key_exists($id, self::$person_cache))
		{
			self::$person_cache[trim($id)] = $id;
		}
	}

	/**
	 * @param $cache
	 */
	protected function setPersonCache($cache)
	{
		self::$person_cache = $cache;
	}

	/**
	 * @return PersonService
	 */
	public function getPersonService()
	{
		return self::$person_service;
	}

	/**
	 * @return StudentService
	 */
	public function getStudentService()
	{
		return self::$student_service;
	}

	/**
	 * @return AddressService
	 */
	public static function getAddressService()
	{
		return self::$address_service;
	}

	/**
	 * @return array
	 */
	public function getUnitCache()
	{
		return $this->unit_cache;
	}

	/**
	 * @param $cache
	 */
	protected function setUnitCache($cache)
	{
		$this->unit_cache = $cache;
	}

	/**
	 * @param Unit $unit
	 */
	public function appendUnitCache($unit)
	{
		if($unit->getId() != null)
		{
			$this->unit_cache[ (string) $unit->getId()] = $unit;
		}
	}

	/**
	 * @return array
	 */
	public function getChildRelationMap()
	{
		return $this->child_relation_map;
	}

	/**
	 * @param ChildRelation $child_relation
	 */
	public function appendToChildRelationMap($child_relation)
	{
		if($child_relation->getChildId() != null)
		{
			$this->child_relation_map[ (string) $child_relation->getChildId()] = $child_relation->getParentId();
		}
	}

	/**
	 * @param $child_id
	 * @return mixed|null
	 */
	public function getParentForChild($child_id)
	{
		if(array_key_exists($child_id, $this->child_relation_map))
		{
			return $this->child_relation_map[$child_id];
		}
		return null;
	}
}