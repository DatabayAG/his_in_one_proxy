<?php

namespace HisInOneProxy\Soap\SoapService;

use HisInOneProxy\Soap;

/**
 * Class SystemEventAbonnenmentClient
 * @package HisInOneProxy\Soap\SoapService
 */
class SystemEventAbonnenmentClient implements SoapClientService
{
	/**
	 * @return string
	 */
	public function getServiceWsdl()
	{
		return 'SystemEventAbonnenmentService.wsdl';
	}

	/**
	 * @return string
	 */
	public function getServiceDir()
	{
		return 'SystemEventAbonnenmentService';
	}

	/**
	 * @param Soap\SoapServiceRouter $router
	 */
	public function appendRouterConfig($router)
	{
		$router->setSoapSystemEventAbonnenmentClient(new Soap\WSSoapClient($router->getUrl() . $this->getServiceWsdl(), array('path' => $this->getServiceDir())));
	}
}