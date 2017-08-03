<?php

namespace HisInOneProxy\Soap\SoapService;

use HisInOneProxy\Soap;

class CourseOfStudyClient implements SoapClientService
{
	/**
	 * @return string
	 */
	public function getServiceWsdl()
	{
		return 'CourseOfStudyService.wsdl';
	}

	/**
	 * @return string
	 */
	public function getServiceDir()
	{
		return 'CourseOfStudyService';
	}

	/**
	 * @param Soap\SoapServiceRouter $router
	 */
	public function appendRouterConfig($router)
	{
		$router->setSoapClientCourseOfStudyService(new Soap\WSSoapClient($router->getUrl() . $this->getServiceWsdl(), array('path' => $this->getServiceDir(), 'remove_secure_header' => true)));
	}
}