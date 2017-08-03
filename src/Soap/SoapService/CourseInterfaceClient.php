<?php

namespace HisInOneProxy\Soap\SoapService;

use HisInOneProxy\Soap;

class CourseInterfaceClient implements SoapClientService
{
	/**
	 * @return string
	 */
	public function getServiceWsdl()
	{
		return 'CourseInterfaceService.wsdl';
	}

	/**
	 * @return string
	 */
	public function getServiceDir()
	{
		return 'CourseInterfaceService';
	}

	/**
	 * @param Soap\SoapServiceRouter $router
	 */
	public function appendRouterConfig($router)
	{
		$router->setSoapClientCourseInterfaceService(new Soap\WSSoapClient($router->getUrl() . $this->getServiceWsdl(), array('path' => $this->getServiceDir())));
	}
}