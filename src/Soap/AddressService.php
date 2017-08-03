<?php

namespace HisInOneProxy\Soap;

use HisInOneProxy\DataModel\Address;
use HisInOneProxy\Log\Log;
use HisInOneProxy\Parser;

class AddressService extends SoapService
{

	/**
	 * AddressService constructor.
	 * @param Log $log
	 * @param SoapServiceRouter $soap_service_router
	 */
	public function __construct($log, $soap_service_router)
	{
		parent::__construct($log, $soap_service_router);
	}

	/**
	 * @param $org_unit_id
	 * @return Address[] | null
	 */
	public function readPostAddresses($org_unit_id)
	{
		// 'Person', 'Orgunit', 'Room', 'Building'
		$params = array(array('id' => $org_unit_id, 'objekttype' => 'Orgunit'));
		try{
			$response = $this->soap_service_router->getSoapClientAddressService()->__soapCall('readPostAddresses', $params);
			$parser = new Parser\ParseAddress($this->log);
			$address = $parser->parse($response);

			return $address;
		}
		catch(\SoapFault $exception)
		{
			$this->log->error($exception->getMessage());
		}
		return null;
	}

}