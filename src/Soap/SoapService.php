<?php
namespace HisInOneProxy\Soap;

use HisInOneProxy\Log\Log;

class SoapService
{
	/**
	 * @var Log
	 */
	protected $log;

	/**
	 * @var SoapServiceRouter
	 */
	protected $soap_service_router;
	
	/**
	 * SoapService constructor.
	 * @param $log
	 * @param $soap_service_router
	 */
	public function __construct($log, $soap_service_router)
	{
		$this->log = $log;
		$this->soap_service_router = $soap_service_router;
	}
}