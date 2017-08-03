<?php

namespace HisInOneProxy\Soap\SoapService;

use HisInOneProxy\Soap;

class UnitClient implements SoapClientService
{
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

	/**
	 * @param Soap\SoapServiceRouter $router
	 */
	public function appendRouterConfig($router)
	{
		$router->setSoapClientUnitService(new Soap\WSSoapClient($router->getUrl() . $this->getServiceWsdl(), array('path' => $this->getServiceDir())));
	}
}