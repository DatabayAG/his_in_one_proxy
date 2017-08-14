<?php

namespace HisInOneProxy\Soap\SoapService;

use HisInOneProxy\Soap;

/**
 * Class StudentClient
 * @package HisInOneProxy\Soap\SoapService
 */
class StudentClient implements SoapClientService
{
	/**
	 * @return string
	 */
	public function getServiceWsdl()
	{
		return 'StudentService.wsdl';
	}

	/**
	 * @return string
	 */
	public function getServiceDir()
	{
		return 'StudentService';
	}

	/**
	 * @param Soap\SoapServiceRouter $router
	 */
	public function appendRouterConfig($router)
	{
		$router->setSoapClientStudentService(new Soap\WSSoapClient($router->getUrl() . $this->getServiceWsdl(), array('path' => $this->getServiceDir())));
	}
}