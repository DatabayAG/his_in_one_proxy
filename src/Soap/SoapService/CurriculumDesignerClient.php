<?php

namespace HisInOneProxy\Soap\SoapService;

use HisInOneProxy\Soap;

/**
 * Class CurriculumDesignerService
 * @package HisInOneProxy\Soap\SoapService
 */
class CurriculumDesignerClient implements SoapClientService
{
    /**
     * @param Soap\SoapServiceRouter $router
     */
    public function appendRouterConfig($router)
    {
        $router->setSoapClientCurriculumDesignerService(new Soap\WSSoapClient($router->getUrl() . $this->getServiceWsdl(), array('path' => $this->getServiceDir())));
    }

    /**
     * @return string
     */
    public function getServiceWsdl()
    {
        return 'CurriculumDesignerService.wsdl';
    }

    /**
     * @return string
     */
    public function getServiceDir()
    {
        return 'CurriculumDesignerService';
    }
}