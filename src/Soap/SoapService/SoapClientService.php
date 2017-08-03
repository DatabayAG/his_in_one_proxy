<?php

namespace HisInOneProxy\Soap\SoapService;

use HisInOneProxy\Soap;

interface SoapClientService
{
	/**
	 * @return string
	 */
	public function getServiceWsdl();

	/**
	 * @param Soap\SoapServiceRouter $router
	 */
	public function appendRouterConfig($router);

	/**
	 * @return string
	 */
	public function getServiceDir();
}