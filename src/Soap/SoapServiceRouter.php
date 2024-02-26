<?php

namespace HisInOneProxy\Soap;

use HisInOneProxy\Config\GlobalSettings;
use HisInOneProxy\Log\Log;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;
use ReflectionClass;
use SplFileInfo;

/**
 * Class SoapServiceRouter
 * @package HisInOneProxy\Soap
 */
class SoapServiceRouter
{

    const SERVICES_TO_INITIALIZE = 14;

    /**
     * @var int
     */
    protected $service_number;

    /**
     * @var Log
     */
    protected $log;

    /**
     * @var WSSoapClient
     */
    protected $soap_client_course_catalog;

    /**
     * @var WSSoapClient
     */
    protected $soap_client_planelement_service;

    /**
     * @var WSSoapClient
     */
    protected $soap_client_unit_service;

    /**
     * @var WSSoapClient
     */
    protected $soap_client_curriculum_designer_service;

    /**
     * @var WSSoapClient
     */
    protected $soap_client_org_unit_service;

    /**
     * @var WSSoapClient
     */
    protected $soap_client_course_interface_service;

    /**
     * @var WSSoapClient
     */
    protected $soap_client_person_service;

    /**
     * @var WSSoapClient
     */
    protected $soap_client_student_service;

    /**
     * @var WSSoapClient
     */
    protected $soap_client_facility_service;

    /**
     * @var WSSoapClient
     */
    protected $soap_client_course_of_study_service;

    /**
     * @var WSSoapClient
     */
    protected $soap_client_value_service;

    /**
     * @var WSSoapClient
     */
    protected $soap_client_person_address_service;
	/**
	 * @var WSSoapClient
	 */
	protected $soap_client_keyvalue_service;
	
    /**
     * @var WSSoapClient
     */
    protected $soap_client_term_service;

    /**
     * @var WSSoapClient
     */
    protected $soap_client_system_event_abonnenment_service;

    /**
     * @var WSSoapClient
     */
    protected $soap_client_account_service;

    /**
     * SoapServiceRouter constructor.
     * @param $log
     */
    public function __construct($log)
    {
        $this->log = $log;
        $this->setServiceNumber(self::SERVICES_TO_INITIALIZE);
        $this->initialiseClientServices();
    }

    public function initialiseClientServices()
    {
        $service_counter = 0;
        $start_time      = microtime(true);
        $this->log->info('Starting initializing Services...');
        $rii = new RecursiveIteratorIterator(new RecursiveDirectoryIterator(dirname(__FILE__) . '/SoapService'));
        /** @var SplFileInfo $file */
        foreach ($rii as $file) {
            if ($file->isDir()) {
                continue;
            }
            if ($file->getExtension() === 'php') {
                $class      = str_replace(array('class.', '.php'), '', $file->getBasename());
                $reflection = new ReflectionClass('HisInOneProxy\Soap\SoapService\\' . $class);
                if (!$reflection->isAbstract() && $reflection->implementsInterface('HisInOneProxy\Soap\SoapService\SoapClientService')) {
                    /** @var $instance SoapService\SoapClientService */
                    $instance = $reflection->newInstance();
                    $instance->appendRouterConfig($this);
                    $service_counter++;
                }
            }
        }

        if ($service_counter !== $this->getServiceNumber()) {
            $this->log->emergency(sprintf('Not all Soap Services where initialised! Only %s from %s where initialised!', $service_counter, $this->getServiceNumber()));
        } else {
            $end_time = microtime(true);
            $this->log->info(sprintf('...initializing all Services done. Took %s seconds.', round($end_time - $start_time, 4)));
        }
    }

    /**
     * @return int
     */
    public function getServiceNumber()
    {
        return $this->service_number;
    }

    /**
     * @param int $service_number
     */
    public function setServiceNumber($service_number)
    {
        $this->service_number = $service_number;
    }

    /**
     * @return WSSoapClient|null
     */
    public function getSoapSystemEventAbonnenmentClient()
    {
        if ($this->soap_client_system_event_abonnenment_service !== null) {
            return $this->soap_client_system_event_abonnenment_service;
        } else {
            $this->log->emergency('System Event service not initialised!');
        }
        return null;
    }

    /**
     * @param WSSoapClient $soap_client_system_event_abonnenment_service
     */
    public function setSoapSystemEventAbonnenmentClient($soap_client_system_event_abonnenment_service)
    {
        $this->soap_client_system_event_abonnenment_service = $soap_client_system_event_abonnenment_service;
    }

    /**
     * @return WSSoapClient|null
     */
    public function getSoapClientCourseCatalog()
    {
        if ($this->soap_client_course_catalog !== null) {
            return $this->soap_client_course_catalog;
        } else {
            $this->log->emergency('Course catalog service not initialised!');
        }
        return null;
    }

    /**
     * @param WSSoapClient $soap_client_course_catalog
     */
    public function setSoapClientCourseCatalog($soap_client_course_catalog)
    {
        $this->soap_client_course_catalog = $soap_client_course_catalog;
    }

    /**
     * @return WSSoapClient|null
     */
    public function getSoapClientPlanelementService()
    {
        if ($this->soap_client_planelement_service !== null) {
            return $this->soap_client_planelement_service;
        } else {
            $this->log->emergency('Course service not initialised!');
        }
        return null;
    }

    /**
     * @param $soap_client_planelement_service
     * @return void
     */
    public function setSoapClientPlanelementService($soap_client_planelement_service)
    {
        $this->soap_client_planelement_service = $soap_client_planelement_service;
    }

    /**
     * @return WSSoapClient|null
     */
    public function getSoapClientCurriculumDesingerService()
    {
        if ($this->soap_client_curriculum_designer_service !== null) {
            return $this->soap_client_curriculum_designer_service;
        } else {
            $this->log->emergency('Unit service not initialised!');
        }
        return null;
    }

    /**
     * @param $soap_client_curriculum_designer_service
     * @return void
     */
    public function setSoapClientCurriculumDesignerService($soap_client_curriculum_designer_service)
    {
        $this->soap_client_curriculum_designer_service = $soap_client_curriculum_designer_service;
    }

    /**
     * @return WSSoapClient|null
     */
    public function getSoapClientOrgUnitService()
    {
        if ($this->soap_client_org_unit_service !== null) {
            return $this->soap_client_org_unit_service;
        } else {
            $this->log->emergency('Org unit service not initialised!');
        }
        return null;
    }

    /**
     * @param WSSoapClient $soap_client_org_unit_service
     */
    public function setSoapClientOrgUnitService($soap_client_org_unit_service)
    {
        $this->soap_client_org_unit_service = $soap_client_org_unit_service;
    }

    /**
     * @return WSSoapClient|null
     */
    public function getSoapClientCourseInterfaceService()
    {
        if ($this->soap_client_course_interface_service !== null) {
            return $this->soap_client_course_interface_service;
        } else {
            $this->log->emergency('Course interface service not initialised!');
        }
        return null;
    }

    /**
     * @param WSSoapClient $soap_client_course_interface_service
     */
    public function setSoapClientCourseInterfaceService($soap_client_course_interface_service)
    {
        $this->soap_client_course_interface_service = $soap_client_course_interface_service;
    }

    /**
     * @return WSSoapClient|null
     */
    public function getSoapClientPersonService()
    {
        if ($this->soap_client_person_service !== null) {
            return $this->soap_client_person_service;
        } else {
            $this->log->emergency('Person service not initialised!');
        }
        return null;
    }

    /**
     * @param WSSoapClient $soap_client_person_service
     */
    public function setSoapClientPersonService($soap_client_person_service)
    {
        $this->soap_client_person_service = $soap_client_person_service;
    }

    /**
     * @return WSSoapClient|null
     */
    public function getSoapClientStudentService()
    {
        if ($this->soap_client_student_service !== null) {
            return $this->soap_client_student_service;
        } else {
            $this->log->emergency('Student service not initialised!');
        }
        return null;
    }

    /**
     * @param WSSoapClient $soap_client_student_service
     */
    public function setSoapClientStudentService($soap_client_student_service)
    {
        $this->soap_client_student_service = $soap_client_student_service;
    }

    /**
     * @return WSSoapClient|null
     */
    public function getSoapClientFacilityService()
    {
        if ($this->soap_client_facility_service !== null) {
            return $this->soap_client_facility_service;
        } else {
            $this->log->emergency('Facility service not initialised!');
        }
        return null;
    }

    /**
     * @param WSSoapClient $soap_client_facility_service
     */
    public function setSoapClientFacilityService($soap_client_facility_service)
    {
        $this->soap_client_facility_service = $soap_client_facility_service;
    }

    /**
     * @return WSSoapClient|null
     */
    public function getSoapClientCourseOfStudyService()
    {
        if ($this->soap_client_course_of_study_service !== null) {
            return $this->soap_client_course_of_study_service;
        } else {
            $this->log->emergency('Course of study service not initialised!');
        }
        return null;
    }

    /**
     * @param WSSoapClient $soap_client_course_of_study_service
     */
    public function setSoapClientCourseOfStudyService($soap_client_course_of_study_service)
    {
        $this->soap_client_course_of_study_service = $soap_client_course_of_study_service;
    }

    /**
     * @return string
     */
    public function getUrl()
    {
        return GlobalSettings::getInstance()->getHisServerUrl();
    }

	/**
	 * @return WSSoapClient|null
	 */
	public function getSoapClientKeyValueService()
	{
		if($this->soap_client_keyvalue_service !== null)
		{
			return $this->soap_client_keyvalue_service;
		}
		else
		{
			$this->log->emergency('KeyValue service not initialised!');
		}
		return null;
	}

    /**
     * @param WSSoapClient $soap_client_value_service
     */
    public function setSoapClientKeyValueService($soap_client_value_service)
    {
        $this->soap_client_keyvalue_service = $soap_client_value_service;
    }

	/**
	 * @return WSSoapClient|null
	 */
	public function getSoapClientPersonAddressService()
	{
		if($this->soap_client_person_address_service !== null)
		{
			return $this->soap_client_person_address_service;
		}
		else
		{
			$this->log->emergency('Address service not initialised!');
		}
		return null;
	}

    /**
     * @param WSSoapClient $soap_client_person_address_service
     */
    public function setSoapClientPersonAddressService($soap_client_person_address_service)
    {
        $this->soap_client_person_address_service = $soap_client_person_address_service;
    }

    /**
     * @return WSSoapClient|null
     */
    public function getSoapClientTermService()
    {
        if ($this->soap_client_term_service !== null) {
            return $this->soap_client_term_service;
        } else {
            $this->log->emergency('Term service not initialised!');
        }
        return null;
    }

    /**
     * @param WSSoapClient $soap_client_term_service
     */
    public function setSoapClientTermService($soap_client_term_service)
    {
        $this->soap_client_term_service = $soap_client_term_service;
    }

    /**
     * @return WSSoapClient|null
     */
    public function getSoapClientAccountService()
    {
        if ($this->soap_client_account_service !== null) {
            return $this->soap_client_account_service;
        } else {
            $this->log->emergency('Account service not initialised!');
        }
        return null;
    }

    /**
     * @param WSSoapClient $soap_client_account_service
     */
    public function setSoapClientAccountService($soap_client_account_service)
    {
        $this->soap_client_account_service = $soap_client_account_service;
    }
    
    
}