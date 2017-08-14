<?php

namespace HisInOneProxy\Soap\SoapService;

use HisInOneProxy\Soap;

/**
 * Class CourseClient
 * @package HisInOneProxy\Soap\SoapService
 */
class CourseClient extends ConfigClient implements SoapClientService
{
	/**
	 * @return string
	 */
	public function getServiceWsdl()
	{
		return 'CourseService.wsdl';
	}

	/**
	 * @return string
	 */
	public function getServiceDir()
	{
		return 'CourseService';
	}

	/**
	 * @param Soap\SoapServiceRouter $router
	 */
	public function appendRouterConfig($router)
	{
		$router->setSoapClientCourseService(new Soap\WSSoapClient($router->getUrl() . $this->getServiceWsdl(), array('path' => $this->getServiceDir())));
	}
}