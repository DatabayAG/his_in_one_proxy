<?php

namespace HisInOneProxy\Soap\SoapService;

use HisInOneProxy\Soap;

class CourseCatalogClient implements SoapClientService
{
	/**
	 * @return string
	 */
	public function getServiceWsdl()
	{
		return 'CourseCatalogService.wsdl';
	}

	/**
	 * @return string
	 */
	public function getServiceDir()
	{
		return 'CourseCatalogService';
	}

	/**
	 * @param Soap\SoapServiceRouter $router
	 */
	public function appendRouterConfig($router)
	{
		$router->setSoapClientCourseCatalog(new Soap\WSSoapClient($router->getUrl() . $this->getServiceWsdl(), array('path' => $this->getServiceDir())));
	}
}