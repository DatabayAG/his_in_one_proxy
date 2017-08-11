<?php

namespace HisInOneProxy\Soap\SoapService;

use HisInOneProxy\Soap;

class AccountClient implements SoapClientService
{
	/**
	 * @return string
	 */
	public function getServiceWsdl()
	{
		return 'AccountService.wsdl';
	}

	/**
	 * @return string
	 */
	public function getServiceDir()
	{
		return 'AccountService';
	}

	/**
	 * @param Soap\SoapServiceRouter $router
	 */
	public function appendRouterConfig($router)
	{
		$router->setSoapClientAccountService(new Soap\WSSoapClient($router->getUrl() . $this->getServiceWsdl(), array('path' => $this->getServiceDir())));
	}
}