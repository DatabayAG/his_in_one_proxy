<?php

namespace HisInOneProxy\Soap;

use HisInOneProxy\Parser;

class ValueService extends SoapService
{
	/**
	 * CourseCatalogService constructor.
	 * @param                   $log
	 * @param SoapServiceRouter $soap_service_router
	 */
	public function __construct($log, $soap_service_router)
	{
		parent::__construct($log, $soap_service_router);
	}

	/**
	 * @param $lang
	 * @return \HisInOneProxy\DataModel\Container\TermTypeList|null
	 */
	public function getAllTermTypes($lang)
	{
		$params = array(array('lang' => $lang));
		try
		{
			$response	= $this->soap_service_router->getSoapClientValueService()->__soapCall('getAllTermTypes', $params);
			$parser		= new Parser\ParseTermTypeList($this->log);
			if(isset($response->listOfTermTypes))
			{
				$term_types = $parser->parse($response->listOfTermTypes);
				return $term_types;
			}
			else
			{
				$this->log->error('No list of term types object found in response!');
			}
		}
		catch(\SoapFault $exception)
		{
			$this->log->error($exception->getMessage());
		}
		return null;
	}

	/**
	 * @param $lang
	 * @return \HisInOneProxy\DataModel\Container\ParallelGroupValuesContainer|null
	 */
	public function getAllParallelGroups($lang)
	{
		$params = array(array('lang' => $lang));
		try
		{
			$response = $this->soap_service_router->getSoapClientValueService()->__soapCall('getAllParallelgroups', $params);
			$parser   = new Parser\ParseParallelGroupValues($this->log);
			if(isset($response->listOfParallelgroups))
			{
				$group_values = $parser->parse($response->listOfParallelgroups);
				return $group_values;
			}
			else
			{
				$this->log->error('No list of term types object found in response!');
			}
		}
		catch(\SoapFault $exception)
		{
			$this->log->error($exception->getMessage());
		}
		return null;
	}

	/**
	 * @param $lang
	 * @return \HisInOneProxy\DataModel\Container\ElearningPlatformContainer|null
	 */
	public function getAllElearningPlatforms($lang)
	{
		$params = array(array('lang' => $lang));
		try
		{
			$response = $this->soap_service_router->getSoapClientValueService()->__soapCall('getAllElearningPlatforms', $params);
			$parser   = new Parser\ParseElearningPlatform($this->log);
			if(isset($response->listOfElearningPlatforms))
			{
				$plattforms = $parser->parse($response->listOfElearningPlatforms);
				return $plattforms;
			}
			else
			{
				$this->log->error('No elearning plattform object found in response!');
			}
		}
		catch(\SoapFault $exception)
		{
			$this->log->error($exception->getMessage());
		}
		return null;
	}

	/**
	 * @param $lang
	 * @return \HisInOneProxy\DataModel\Container\CourseMappingTypeContainer|null
	 */
	public function getAllCourseMappingTypes($lang)
	{
		$params = array(array('lang' => $lang));
		try
		{
			$response = $this->soap_service_router->getSoapClientValueService()->__soapCall('getAllCourseMappingTypes', $params);
			$parser   = new Parser\ParseCourseMappingType($this->log);
			if(isset($response->listOfCourseMappingTypes))
			{
				$platforms = $parser->parse($response->listOfCourseMappingTypes);
				return $platforms;
			}
			else
			{
				$this->log->error('No course mapping type object found in response!');
			}
		}
		catch(\SoapFault $exception)
		{
			$this->log->error($exception->getMessage());
		}
		return null;
	}

	/**
	 * @return null
	 */
	public function getDefaultLanguageId()
	{
		$params = array(array('lang' => null));
		try
		{
			$response = $this->soap_service_router->getSoapClientValueService()->__soapCall('getAllLanguages', $params);
			if(isset($response->listOfLanguages))
			{
				$lang_id = $response->listOfLanguages->languagevalue[0]->defaultlanguage;
				return $lang_id;
			}
			else
			{
				$this->log->error('No list of term types object found in response!');
			}
		}
		catch(\SoapFault $exception)
		{
			$this->log->error($exception->getMessage());
		}
		return null;
	}

	/**
	 * @param $lang
	 * @return \HisInOneProxy\DataModel\Container\WorkStatusContainer|null
	 */
	public function getAllWorkStatus($lang)
	{
		$params = array(array('lang' => $lang));
		try
		{
			$response = $this->soap_service_router->getSoapClientValueService()->__soapCall('getAllWorkstatus', $params);
			
			$parser = new Parser\ParseWorkStatus($this->log);
			if(isset($response->listOfWorkstatus))
			{
				$work_status = $parser->parse($response->listOfWorkstatus);
				return $work_status;
			}
			else
			{
				$this->log->error('No list of work status object found in response!');
			}
		}
		catch(\SoapFault $exception)
		{
			$this->log->error($exception->getMessage());
		}
		return null;
	}
}