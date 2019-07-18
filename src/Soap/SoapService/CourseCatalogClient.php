<?php

namespace HisInOneProxy\Soap\SoapService;

use HisInOneProxy\Soap;

/**
 * Class CourseCatalogClient
 * @package HisInOneProxy\Soap\SoapService
 */
class CourseCatalogClient implements SoapClientService
{
    /**
     * @param Soap\SoapServiceRouter $router
     */
    public function appendRouterConfig($router)
    {
        $router->setSoapClientCourseCatalog(new Soap\WSSoapClient($router->getUrl() . $this->getServiceWsdl(), array('path' => $this->getServiceDir())));
    }

    /**
     * @return string
     */
    public function getServiceWsdl()
    {
        return 'CourseCatalogService.wsdl';
    }

    /**
     * @return string
     */
    public function getServiceDir()
    {
        return 'CourseCatalogService';
    }
}