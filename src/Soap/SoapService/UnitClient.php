<?php

namespace HisInOneProxy\Soap\SoapService;

use HisInOneProxy\Soap;

/**
 * Class UnitClient
 * @package HisInOneProxy\Soap\SoapService
 */
class UnitClient implements SoapClientService
{
    /**
     * @param Soap\SoapServiceRouter $router
     */
    public function appendRouterConfig($router)
    {
        $router->setSoapClientUnitService(new Soap\WSSoapClient($router->getUrl() . $this->getServiceWsdl(), array('path' => $this->getServiceDir())));
    }

    /**
     * @return string
     */
    public function getServiceWsdl()
    {
        return 'UnitService.wsdl';
    }

    /**
     * @return string
     */
    public function getServiceDir()
    {
        return 'UnitService';
    }
}