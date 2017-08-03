<?php

namespace HisInOneProxy\Soap;

use HisInOneProxy\DataModel\Endpoint;
use HisInOneProxy\Log\Log;
use HisInOneProxy\Soap\Interactions\DataCache;

class SystemEventAbonnenmentService extends SoapService
{

	protected $objects = array(
		'person' => 'Person',
		'student' => 'Student',
		'examrelation' => 'Examrelation'
	);

	/**
	 * @var string
	 */
	protected $subscriber_name = 'HisInOneProxy';

	/**
	 * SystemEventAbonnenmentService constructor.
	 * @param Log $log
	 * @param SoapServiceRouter $soap_service_router
	 */
	public function __construct($log, $soap_service_router)
	{
		parent::__construct($log, $soap_service_router);
	}

	/**
	 * @param string $object_type
	 * @param Endpoint $endpoint
	 * @return mixed|null
	 */
	public function register($object_type, $endpoint)
	{
		$key = strtolower($object_type);
		if(array_key_exists($key , $this->objects))
		{
			$params = array(array(	'objecttype' => $object_type,
									'subscriberName' => $this->subscriber_name,
									'endpoint' => array(
										'endpointUrl'		=> $endpoint->getUrlWithPort(),
										'webServiceMethod'	=> $endpoint->getWebServiceMethod(),
										'username'			=> $endpoint->getUserName(),
										'password'			=> $endpoint->getPassword()
										)
									));
			try{
				$response = $this->soap_service_router->getSoapSystemEventAbonnenmentClient()->__soapCall('register60', $params);
				return $response;
			}
			catch(\SoapFault $exception)
			{
				$this->log->error($exception->getMessage());
			}
		}
		else
		{
			DataCache::getInstance()->getLog()->error(printf('Trying to register unknown object type (%s', $object_type));
		}
		return null;
	}

	/**
	 * @param string $object_type
	 * @return mixed|null
	 */
	public function quitRegistration($object_type)
	{
		$key = strtolower($object_type);
		if(array_key_exists($key , $this->objects))
		{
			$params = array(array(	'objecttype' => $object_type,
									'subscriberName' => $this->subscriber_name,
							));
			try{
				$response = $this->soap_service_router->getSoapSystemEventAbonnenmentClient()->__soapCall('quitRegistration', $params);
				return $response;
			}
			catch(\SoapFault $exception)
			{
				$this->log->error($exception->getMessage());
			}
		}
		else
		{
			DataCache::getInstance()->getLog()->error(printf('Trying to quit registration for unknown object type (%s', $object_type));
		}
		return null;
	}

}