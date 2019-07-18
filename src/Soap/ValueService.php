<?php

namespace HisInOneProxy\Soap;

use HisInOneProxy\DataModel\Container\CourseMappingTypeContainer;
use HisInOneProxy\DataModel\Container\ElearningPlatformContainer;
use HisInOneProxy\DataModel\Container\ParallelGroupValuesContainer;
use HisInOneProxy\DataModel\Container\TermTypeList;
use HisInOneProxy\DataModel\Container\WorkStatusContainer;
use HisInOneProxy\DataModel\DefaultObject;
use HisInOneProxy\DataModel\EAddressTag;
use HisInOneProxy\DataModel\EAddressType;
use HisInOneProxy\DataModel\FieldOfStudy;
use HisInOneProxy\DataModel\Gender;
use HisInOneProxy\DataModel\Language;
use HisInOneProxy\DataModel\Purpose;
use HisInOneProxy\Parser;
use SoapFault;

/**
 * Class ValueService
 * @package HisInOneProxy\Soap
 */
class ValueService extends SoapService
{
    /**
     * CourseCatalogService constructor.
     * @param                   $log
     * @param SoapServiceRouter $soap_service_router
     */
    public function __construct($log, $soap_service_router)
    {
        parent::__construct($log, $soap_service_router);
    }

    /**
     * @param $lang
     * @return CourseMappingTypeContainer|null
     */
    public function getAllCourseMappingTypes($lang)
    {
        $params = array(array('lang' => $lang));
        try {
            $response = $this->soap_service_router->getSoapClientValueService()->__soapCall('getAllCourseMappingTypes', $params);
            $parser   = new Parser\ParseCourseMappingType($this->log);
            if (isset($response->listOfCourseMappingTypes)) {
                $platforms = $parser->parse($response->listOfCourseMappingTypes);
                return $platforms;
            } else {
                $this->log->error('No course mapping type object found in response!');
            }
        } catch (SoapFault $exception) {
            $this->log->error($exception->getMessage());
        }
        return null;
    }

    /**
     * @return null
     */
    public function getDefaultLanguageId()
    {
        $params = array(array('lang' => null));
        try {
            $response = $this->soap_service_router->getSoapClientValueService()->__soapCall('getAllLanguages', $params);
            if (isset($response->listOfLanguages)) {
                $lang_id = $response->listOfLanguages->languagevalue[0]->defaultlanguage;
                return $lang_id;
            } else {
                $this->log->error('No default languages value found in response!');
            }
        } catch (SoapFault $exception) {
            $this->log->error($exception->getMessage());
        }
        return null;
    }

    /**
     * @param $lang
     * @return EAddressType[]|null
     */
    public function getAllEAddressTypes($lang)
    {
        $params = array(array('lang' => $lang));
        try {
            $response = $this->soap_service_router->getSoapClientValueService()->__soapCall('getAllEAddresstypes', $params);
            $parser   = new Parser\ParseEAddressType($this->log);
            if (isset($response->listOfEAddresstypes)) {
                $ea_address_types = $parser->parse($response);
                return $ea_address_types;
            } else {
                $this->log->error('No list of EAddresstype types object found in response!');
            }
        } catch (SoapFault $exception) {
            $this->log->error($exception->getMessage());
        }
        return null;
    }

    /**
     * @param $lang
     * @return EAddressTag[]|null
     */
    public function getAllEAddressTags($lang)
    {
        $params = array(array('lang' => $lang));
        try {
            $response = $this->soap_service_router->getSoapClientValueService()->__soapCall('getAllEAddressTags', $params);
            $parser   = new Parser\ParseEAddressTag($this->log);
            if (isset($response->listOfEAddresstags)) {
                $ea_address_types = $parser->parse($response);
                return $ea_address_types;
            } else {
                $this->log->error('No list of EAddressTag object found in response!');
            }
        } catch (SoapFault $exception) {
            $this->log->error($exception->getMessage());
        }
        return null;
    }

    /**
     * @param $lang
     * @return ElearningPlatformContainer|null
     */
    public function getAllElearningPlatforms($lang)
    {
        $params = array(array('lang' => $lang));
        try {
            $response = $this->soap_service_router->getSoapClientValueService()->__soapCall('getAllElearningPlatforms', $params);
            $parser   = new Parser\ParseElearningPlatform($this->log);
            if (isset($response->listOfElearningPlatforms)) {
                $plattforms = $parser->parse($response->listOfElearningPlatforms);
                return $plattforms;
            } else {
                $this->log->error('No elearning plattform object found in response!');
            }
        } catch (SoapFault $exception) {
            $this->log->error($exception->getMessage());
        }
        return null;
    }

    /**
     * @param $lang
     * @return DefaultObject[]|null
     */
    public function getAllExternalSystems($lang)
    {
        return $this->getDefaultObjectType($lang, 'getAllExternalsystems', 'listOfExternalsystems', 'externalsystemvalue');
    }

    /**
     * @param $lang
     * @param $soap_function
     * @param $list_attribute
     * @param $attribute
     * @return DefaultObject[]|null
     */
    protected function getDefaultObjectType($lang, $soap_function, $list_attribute, $attribute)
    {
        $params = array(array('lang' => $lang));
        try {
            $response = $this->soap_service_router->getSoapClientValueService()->__soapCall($soap_function, $params);
            $parser   = new Parser\ParseDefaultObject($this->log);

            if (isset($response->{$list_attribute})) {
                $parser->setListValue($list_attribute);
                $parser->setTagValue($attribute);
                $default_object_list = $parser->parse($response);
                return $default_object_list;
            } else {
                $this->log->error('No list of default object found in response!');
            }
        } catch (SoapFault $exception) {
            $this->log->error($exception->getMessage());
        }
        return null;
    }

    /**
     * @param $lang
     * @return FieldOfStudy[]|null
     */
    public function getAllFieldOfStudies($lang)
    {
        $params = array(array('lang' => $lang));
        try {
            $response = $this->soap_service_router->getSoapClientValueService()->__soapCall('getAllFieldOfStudies', $params);
            $parser   = new Parser\ParseFieldOfStudy($this->log);
            if (isset($response->listOfFieldOfStudies)) {
                $field_of_study_list = $parser->parse($response);
                return $field_of_study_list;
            } else {
                $this->log->error('No list of field of studies found in response!');
            }
        } catch (SoapFault $exception) {
            $this->log->error($exception->getMessage());
        }
        return null;
    }

    /**
     * @param $lang
     * @return Gender[]|null
     */
    public function getAllGenders($lang)
    {
        $params = array(array('lang' => $lang));
        try {
            $response = $this->soap_service_router->getSoapClientValueService()->__soapCall('getAllGenders', $params);
            $parser   = new Parser\ParseGenders($this->log);
            if (isset($response->listOfGenders)) {
                $gender_list = $parser->parse($response);
                return $gender_list;
            } else {
                $this->log->error('No list of genders found in response!');
            }
        } catch (SoapFault $exception) {
            $this->log->error($exception->getMessage());
        }
        return null;
    }

    /**
     * @param $lang
     * @return Language[]|null
     */
    public function getAllLanguages($lang)
    {
        $params = array(array('lang' => $lang));
        try {
            $response = $this->soap_service_router->getSoapClientValueService()->__soapCall('getAllLanguages', $params);
            $parser   = new Parser\ParseLanguages($this->log);
            if (isset($response->listOfLanguages)) {
                $language_list = $parser->parse($response);
                return $language_list;
            } else {
                $this->log->error('No list of languages found in response!');
            }
        } catch (SoapFault $exception) {
            $this->log->error($exception->getMessage());
        }
        return null;
    }

    /**
     * @param $lang
     * @return DefaultObject[]|null
     */
    public function getAllMajorFieldOfStudies($lang)
    {
        return $this->getDefaultObjectType($lang, 'getAllMajorFieldOfStudies', 'listOfMajorFieldOfStudies', 'majorfieldofstudy');
    }

    /**
     * @param $lang
     * @return DefaultObject[]|null
     */
    public function getAllOrgUnitAttributes($lang)
    {
        return $this->getDefaultObjectType($lang, 'getAllOrgunitAttributes', 'listOfOrgunitAttributes', 'orgunitattributevalue');
    }

    /**
     * @param $lang
     * @return DefaultObject[]|null
     */
    public function getAllOrgUnitTypes($lang)
    {
        return $this->getDefaultObjectType($lang, 'getAllOrgunittypes', 'listOfOrgunittypes', 'orgunittypevalue');
    }

    /**
     * @param $lang
     * @return ParallelGroupValuesContainer|null
     */
    public function getAllParallelGroups($lang)
    {
        $params = array(array('lang' => $lang));
        try {
            $response = $this->soap_service_router->getSoapClientValueService()->__soapCall('getAllParallelgroups', $params);
            $parser   = new Parser\ParseParallelGroupValues($this->log);
            if (isset($response->listOfParallelgroups)) {
                $group_values = $parser->parse($response->listOfParallelgroups);
                return $group_values;
            } else {
                $this->log->error('No list of ParallelGroup object found in response!');
            }
        } catch (SoapFault $exception) {
            $this->log->error($exception->getMessage());
        }
        return null;
    }

    /**
     * @param $lang
     * @return DefaultObject[]|null
     */
    public function getAllPersonGroupCategories($lang)
    {
        return $this->getDefaultObjectType($lang, 'getAllPersonGroupCategories', 'listOfPersonGroupCategories', 'persongroupcategoryvalue');
    }

    /**
     * @param $lang
     * @return Purpose[]|null
     */
    public function getAllPurposes($lang)
    {
        $params = array(array('lang' => $lang));
        try {
            $response = $this->soap_service_router->getSoapClientValueService()->__soapCall('getAllPurposes', $params);

            $parser = new Parser\ParsePurposeList($this->log);
            if (isset($response->listOfPurposes)) {
                $purpose_list = $parser->parse($response);
                return $purpose_list;
            } else {
                $this->log->error('No list of purposes found in response!');
            }
        } catch (SoapFault $exception) {
            $this->log->error($exception->getMessage());
        }
        return null;
    }

    /**
     * @param $lang
     * @return TermTypeList|null| array
     */
    public function getAllTermTypes($lang)
    {
        $params = array(array('lang' => $lang));
        try {
            $response = $this->soap_service_router->getSoapClientValueService()->__soapCall('getAllTermTypes', $params);
            $parser   = new Parser\ParseTermTypeList($this->log);
            if (isset($response->listOfTermTypes)) {
                $term_types = $parser->parse($response->listOfTermTypes);
                return $term_types;
            } else {
                $this->log->error('No list of term types object found in response!');
            }
        } catch (SoapFault $exception) {
            $this->log->error($exception->getMessage());
        }
        return null;
    }

    /**
     * @param $lang
     * @return TermTypeList|null
     */
    public function getAllElementtypes($lang)
    {
        $params = array(array('lang' => $lang));
        try {
            $response = $this->soap_service_router->getSoapClientValueService()->__soapCall('getAllElementtypes', $params);
            return $response;
        } catch (SoapFault $exception) {
            $this->log->error($exception->getMessage());
        }
        return null;
    }

    /**
     * @param $lang
     * @return EAddressType[]|null
     */
    public function getAllEventtypes($lang)
    {
        $params = array(array('lang' => $lang));
        try {
            $response = $this->soap_service_router->getSoapClientValueService()->__soapCall('getAllEventtypes', $params);
            $parser   = new Parser\ParseEventType($this->log);
            if (isset($response->listOfEventtypes)) {
                $event_types = $parser->parse($response);
                return $event_types;
            } else {
                $this->log->error('No list of work status object found in response!');
            }
        } catch (SoapFault $exception) {
            $this->log->error($exception->getMessage());
        }
        return null;
    }

    /**
     * @param $lang
     * @return WorkStatusContainer|null
     */
    public function getAllWorkStatus($lang)
    {
        $params = array(array('lang' => $lang));
        try {
            $response = $this->soap_service_router->getSoapClientValueService()->__soapCall('getAllWorkstatus', $params);

            $parser = new Parser\ParseWorkStatus($this->log);
            if (isset($response->listOfWorkstatus)) {
                $work_status = $parser->parse($response->listOfWorkstatus);
                return $work_status;
            } else {
                $this->log->error('No list of work status object found in response!');
            }
        } catch (SoapFault $exception) {
            $this->log->error($exception->getMessage());
        }
        return null;
    }

    /**
     * @param $lang
     * @return WorkStatusContainer|null
     */
    public function getAllBlockeds($lang)
    {
        $params = array(array('lang' => $lang));
        try {
            $response = $this->soap_service_router->getSoapClientValueService()->__soapCall('getAllBlockeds', $params);

            if (isset($response->listOfBlockeds)) {
                print_r($response);
            } else {
                $this->log->error('No list of blocked ids found in response!');
            }
        } catch (SoapFault $exception) {
            $this->log->error($exception->getMessage());
        }
        return null;
    }
}