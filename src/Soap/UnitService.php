<?php

namespace HisInOneProxy\Soap;

use HisInOneProxy\Parser;

class UnitService extends SoapService
{
	
	protected $soap_unit;

	/**
	 * CourseCatalogService constructor.
	 * @param $log
	 * @param SoapServiceRouter $soap_service_router
	 */
	public function __construct($log, $soap_service_router)
	{
		parent::__construct($log, $soap_service_router);
		$this->soap_unit = $this->soap_service_router->getSoapClientUnitService();
	}

	/**
	 * @param $unitId
	 * @return \HisInOneProxy\DataModel\Unit | null
	 */
	public function readUnit($unitId)
	{
		$params = array(array('unitId' => $unitId));
		try{
			$response	= $this->soap_unit->__soapCall('readUnit81', $params);
			$parser		= new Parser\ParseUnit($this->log);
			if(isset($response->unit))
			{
				$unit = $parser->parse($response->unit);
				return $unit;
			}
			else
			{
				$this->log->error('No unit object found in response!');
			}
		}
		catch(\SoapFault $exception)
		{
			$this->log->error($exception->getMessage());
		}
		return null;
	}

	/**
	 * @param $unitId
	 * @return \HisInOneProxy\DataModel\Unit | null
	 */
	public function readUnitWithChildren($unitId)
	{
		$params = array(array('unitId' => $unitId));
		try{
			$response	= $this->soap_unit->__soapCall('readUnitWithChildren', $params);
			$parser		= new Parser\ParseUnit($this->log);
			if(isset($response->unit))
			{
				$unit = $parser->parse($response->unit);
				return $unit;
			}
			else
			{
				$this->log->error('No unit object found in response!');
			}
		}
		catch(\SoapFault $exception)
		{
			$this->log->error($exception->getMessage());
		}
		return null;
	}

	/**
	 * @param $unitId
	 * @return array | null
	 */
	public function findOrgUnitsByUnit($unitId)
	{
		$params = array(array('unitId' => $unitId));
		try{
			$response		= $this->soap_unit->__soapCall('findOrgunitsByUnit', $params);
			$org_unit_lids	= array();
			if(isset($response->unitOrgunitList))
			{
				$list = $response->unitOrgunitList;
				if(is_array($list->unitOrgunitInfo))
				{
					foreach($list->unitOrgunitInfo as $org_unit)
					{
						$org_unit_lids[] = $org_unit->orgunitLid;
					}
				}
				else
				{
					$org_unit_lids[] = $list->unitOrgunitInfo->orgunitLid;
				}

				return $org_unit_lids;
			}
			else
			{
				$this->log->error('No unit object found in response!');
			}
		}
		catch(\SoapFault $exception)
		{
			$this->log->error($exception->getMessage());
		}
		return null;
	}
}