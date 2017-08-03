<?php

namespace HisInOneProxy\Soap\SoapService;

use HisInOneProxy\Soap;

class FacilityClient implements SoapClientService
{
	/**
	 * @return string
	 */
	public function getServiceWsdl()
	{
		return 'FacilityService.wsdl';
	}

	/**
	 * @return string
	 */
	public function getServiceDir()
	{
		return 'FacilityService';
	}

	/**
	 * @param Soap\SoapServiceRouter $router
	 */
	public function appendRouterConfig($router)
	{
		$router->setSoapClientFacilityService(new Soap\WSSoapClient($router->getUrl() . $this->getServiceWsdl(), array('path' => $this->getServiceDir())));
	}
}