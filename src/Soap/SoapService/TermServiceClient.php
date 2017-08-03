<?php

namespace HisInOneProxy\Soap\SoapService;

use HisInOneProxy\Soap;

class TermServiceClient implements SoapClientService
{
	/**
	 * @return string
	 */
	public function getServiceWsdl()
	{
		return 'TermService.wsdl';
	}

	/**
	 * @return string
	 */
	public function getServiceDir()
	{
		return 'TermService';
	}

	/**
	 * @param Soap\SoapServiceRouter $router
	 */
	public function appendRouterConfig($router)
	{
		$router->setSoapClientTermService(new Soap\WSSoapClient($router->getUrl() . $this->getServiceWsdl(), array('path' => $this->getServiceDir(),  'remove_secure_header' => true)));
	}
}