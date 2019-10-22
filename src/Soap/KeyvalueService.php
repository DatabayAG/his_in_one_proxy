<?php

namespace HisInOneProxy\Soap;

use HisInOneProxy\Parser\ParseDefaultObject;

/**
 * Class KeyvalueService
 * @package HisInOneProxy\Soap
 */
class KeyvalueService extends SoapService
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
     * @return null
     */
    public function getDefaultLanguageId()
    {
        $params = array(array('valueClass' => 'LanguageValue', 'lang' => null));
        try {
            $response = $this->soap_service_router->getSoapClientKeyValueService()->__soapCall('getAllValid', $params);
            if (isset($response->values)) {
                $lang_id = $response->values->value[0]->uniquename;
                return $lang_id;
            } else {
                $this->log->error('No default languages value found in response!');
            }
        } catch (\SoapFault $exception) {
            $this->log->error($exception->getMessage());
        }
        return null;
    }

    /**
     * @param $valueClass
     * @param $lang
     * @return |nullParseCourseMappingType
     */
    public function getAllValid($valueClass, $lang)
    {
        $params = array(array('valueClass' => $valueClass, 'lang' => null));
        try
        {
            $response = $this->soap_service_router->getSoapClientKeyValueService()->__soapCall('getAllValid', $params);

            $parser   = new ParseDefaultObject($this->log);

            if (isset($response->values)) {
                $parser->setListValue('values');
                $parser->setTagValue('value');
                $default_object_list = $parser->parse($response);
                return $default_object_list;

            } else {
                $this->log->error('No values found in response!');
            }
        }
        catch(\SoapFault $exception)
        {
            $this->log->error($exception->getMessage());
        }
        return null;
    }

   
}