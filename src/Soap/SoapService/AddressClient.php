<?php

namespace HisInOneProxy\Soap\SoapService;

use HisInOneProxy\Soap;

/**
 * Class AddressClient
 * @package HisInOneProxy\Soap\SoapService
 */
class AddressClient implements SoapClientService
{
    /**
     * @param Soap\SoapServiceRouter $router
     */
    public function appendRouterConfig($router)
    {
        $router->setSoapClientAddressService(new Soap\WSSoapClient($router->getUrl() . $this->getServiceWsdl(), array('path' => $this->getServiceDir())));
    }

    /**
     * @return string
     */
    public function getServiceWsdl()
    {
        return 'AddressService.wsdl';
    }

    /**
     * @return string
     */
    public function getServiceDir()
    {
        return 'AddressService';
    }
}