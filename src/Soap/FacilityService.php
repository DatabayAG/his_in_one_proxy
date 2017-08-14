<?php

namespace HisInOneProxy\Soap;

use HisInOneProxy\Log\Log;
use HisInOneProxy\Parser;

/**
 * Class FacilityService
 * @package HisInOneProxy\Soap
 */
class FacilityService extends SoapService
{

	/**
	 * CourseCatalogService constructor.
	 * @param Log $log
	 * @param SoapServiceRouter $soap_service_router
	 */
	public function __construct($log, $soap_service_router)
	{
		parent::__construct($log, $soap_service_router);
	}

	/**
	 * @param $room_id
	 * @return \HisInOneProxy\DataModel\Room | null
	 */
	public function readRoom($room_id)
	{
		$params = array(array('id' => $room_id));
		try{
			$response = $this->soap_service_router->getSoapClientFacilityService()->__soapCall('readRoom', $params);
			$parser = new Parser\ParseRoom($this->log);
			if(isset($response->room))
			{
				$room = $parser->parse($response->room);
				return $room;
			}
			else
			{
				$this->log->error('No room object found in response!');
			}
		}
		catch(\SoapFault $exception)
		{
			$this->log->error($exception->getMessage());
		}
		return null;
	}

}