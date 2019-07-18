<?php

namespace HisInOneProxy\Soap\SoapService;

use HisInOneProxy\Soap;

/**
 * Class FacilityClient
 * @package HisInOneProxy\Soap\SoapService
 */
class FacilityClient implements SoapClientService
{
    /**
     * @param Soap\SoapServiceRouter $router
     */
    public function appendRouterConfig($router)
    {
        $router->setSoapClientFacilityService(new Soap\WSSoapClient($router->getUrl() . $this->getServiceWsdl(), array('path' => $this->getServiceDir())));
    }

    /**
     * @return string
     */
    public function getServiceWsdl()
    {
        return 'FacilityService.wsdl';
    }

    /**
     * @return string
     */
    public function getServiceDir()
    {
        return 'FacilityService';
    }
}