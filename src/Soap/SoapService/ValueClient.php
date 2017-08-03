<?php

namespace HisInOneProxy\Soap\SoapService;

use HisInOneProxy\Soap;

class ValueClient implements SoapClientService
{
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

	/**
	 * @param Soap\SoapServiceRouter $router
	 */
	public function appendRouterConfig($router)
	{
		$router->setSoapClientValueService(new Soap\WSSoapClient($router->getUrl() . $this->getServiceWsdl(), array('path' => $this->getServiceDir(), 'remove_secure_header' => true)));
	}
}