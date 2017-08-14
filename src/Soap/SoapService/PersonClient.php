<?php

namespace HisInOneProxy\Soap\SoapService;

use HisInOneProxy\Soap;

/**
 * Class PersonClient
 * @package HisInOneProxy\Soap\SoapService
 */
class PersonClient implements SoapClientService
{

	/**
	 * @return string
	 */
	public function getServiceWsdl()
	{
		return 'PersonService.wsdl';
	}

	/**
	 * @return string
	 */
	public function getServiceDir()
	{
		return 'PersonService';
	}

	/**
	 * @param Soap\SoapServiceRouter $router
	 */
	public function appendRouterConfig($router)
	{
		$router->setSoapClientPersonService(new Soap\WSSoapClient($router->getUrl() . $this->getServiceWsdl(), array('path' => $this->getServiceDir())));
	}
}