<?php

namespace HisInOneProxy\Soap\SoapService;

use HisInOneProxy\Soap;

class OrgUnitClient implements SoapClientService
{
	/**
	 * @return string
	 */
	public function getServiceWsdl()
	{
		return 'OrgUnitService.wsdl';
	}

	/**
	 * @return string
	 */
	public function getServiceDir()
	{
		return 'OrgUnitService';
	}

	/**
	 * @param Soap\SoapServiceRouter $router
	 */
	public function appendRouterConfig($router)
	{
		$router->setSoapClientOrgUnitService(new Soap\WSSoapClient($router->getUrl() . $this->getServiceWsdl(), array('path' => $this->getServiceDir())));
	}
}