<?php

namespace HisInOneProxy\Soap\SoapService;

use HisInOneProxy\Soap;

/**
 * Class PersonAddressClient
 * @package HisInOneProxy\Soap\SoapService
 */
class PersonAddressClient implements SoapClientService
{
    /**
     * @param Soap\SoapServiceRouter $router
     */
    public function appendRouterConfig($router)
    {
        $router->setSoapClientPersonAddressService(new Soap\WSSoapClient($router->getUrl() . $this->getServiceWsdl(), array('path' => $this->getServiceDir())));
    }

    /**
     * @return string
     */
    public function getServiceWsdl()
    {
        return 'PersonAddressService.wsdl';
    }

    /**
     * @return string
     */
    public function getServiceDir()
    {
        return 'PersonAddressService';
    }
}