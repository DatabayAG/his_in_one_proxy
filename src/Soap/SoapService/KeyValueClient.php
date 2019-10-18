<?php

namespace HisInOneProxy\Soap\SoapService;

use HisInOneProxy\Soap;

/**
 * Class ValueClient
 * @package HisInOneProxy\Soap\SoapService
 */
class KeyValueClient implements SoapClientService
{
	/**
	 * @return string
	 */
	public function getServiceWsdl()
	{
		return 'KeyvalueService.wsdl';
	}

	/**
	 * @return string
	 */
	public function getServiceDir()
	{
		return 'KeyvalueService';
	}

	/**
	 * @param Soap\SoapServiceRouter $router
	 */
	public function appendRouterConfig($router)
	{
		$router->setSoapClientKeyValueService(new Soap\WSSoapClient($router->getUrl() . $this->getServiceWsdl(), array('path' => $this->getServiceDir(), 'remove_secure_header' => false)));
	}
}