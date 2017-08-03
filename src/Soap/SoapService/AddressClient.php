<?php

namespace HisInOneProxy\Soap\SoapService;

use HisInOneProxy\Soap;

class AddressClient implements SoapClientService
{
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

	/**
	 * @param Soap\SoapServiceRouter $router
	 */
	public function appendRouterConfig($router)
	{
		$router->setSoapClientAddressService(new Soap\WSSoapClient($router->getUrl() . $this->getServiceWsdl(), array('path' => $this->getServiceDir())));
	}
}