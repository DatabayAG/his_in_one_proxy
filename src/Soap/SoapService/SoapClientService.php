<?php

namespace HisInOneProxy\Soap\SoapService;

use HisInOneProxy\Soap;

/**
 * Interface SoapClientService
 * @package HisInOneProxy\Soap\SoapService
 */
interface SoapClientService
{
    /**
     * @return string
     */
    public function getServiceWsdl();

    /**
     * @param Soap\SoapServiceRouter $router
     */
    public function appendRouterConfig($router);

    /**
     * @return string
     */
    public function getServiceDir();
}