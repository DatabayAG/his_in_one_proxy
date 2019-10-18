<?php

namespace HisInOneProxy\Soap;

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
     * @return |null
     */
    public function getAllValid($valueClass, $lang)
    {
        $params = array(array('valueClass' => $valueClass, 'lang' => null));
        try
        {
            $response = $this->soap_service_router->getSoapClientKeyValueService()->__soapCall('getAllValid', $params);

            if (isset($response->values)) {
                return $response->values;
            } else {
                $this->log->error('No value found in response!');
            }
        }
        catch(\SoapFault $exception)
        {
            $this->log->error($exception->getMessage());
        }
        return null;
    }

   
}