<?php

namespace HisInOneProxy\Soap\SoapService;

use HisInOneProxy\Soap;

/**
 * Class ValueClient
 * @package HisInOneProxy\Soap\SoapService
 */
class ValueClient implements SoapClientService
{
    /**
     * @param Soap\SoapServiceRouter $router
     */
    public function appendRouterConfig($router)
    {
        $router->setSoapClientValueService(new Soap\WSSoapClient($router->getUrl() . $this->getServiceWsdl(), array('path' => $this->getServiceDir(), 'remove_secure_header' => true)));
    }

    /**
     * @return string
     */
    public function getServiceWsdl()
    {
        return 'ValueService.wsdl';
    }

	/**
	 * @return string
	 */
	public function getServiceDir()
	{
		return 'ValueService';
	}
}