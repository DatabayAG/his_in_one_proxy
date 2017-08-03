<?php

namespace HisInOneProxy\Parser;

use HisInOneProxy\Log\Log;

class SimpleXmlParser
{

	/**
	 * @var Log
	 */
	protected $log;

	/**
	 * SimpleXmlParser constructor.
	 * @param Log $log
	 */
	public function __construct($log)
	{
		$this->log = $log;
	}

	/**
	 * @param $xml
	 * @param $attribute
	 * @return bool
	 */
	public function isAttributeValid($xml, $attribute)
	{
		return $this->doesAttributeExist($xml, $attribute)
			&& $this->isAttributeNotNull($xml, $attribute)
			&& $this->isAttributeNotEmpty($xml, $attribute);
	}

	/**
	 * @param $xml
	 * @param $attribute
	 * @return bool
	 */
	public function doesAttributeExist($xml, $attribute)
	{
		return isset($xml->{$attribute});
	}

	/**
	 * @param $xml
	 * @param $attribute
	 * @return bool
	 */
	public function isAttributeNotNull($xml, $attribute)
	{
		return $xml->{$attribute} != null;
	}

	/**
	 * @param $xml
	 * @param $attribute
	 * @return bool
	 */
	public function isAttributeNotEmpty($xml, $attribute)
	{
		return $xml->{$attribute} != '';
	}

	/**
	 * @param $xml
	 * @param $attribute
	 * @return bool
	 */
	public function doesMoreThanOneElementExists($xml, $attribute)
	{
		return $this->isAttributeValidAsContainer($xml, $attribute)
			&& count($xml->{$attribute}) > 1;
	}

	/**
	 * @param $xml
	 * @param $attribute
	 * @return bool
	 */
	public function isAttributeValidAsContainer($xml, $attribute)
	{
		return $this->doesAttributeExist($xml, $attribute)
			&& $this->isAttributeNotNull($xml, $attribute);
	}

	/**
	 * @param $xml
	 * @param $attribute
	 * @return bool
	 */
	public function doesExactlyOneElementExists($xml, $attribute)
	{
		return $this->isAttributeValidAsContainer($xml, $attribute)
			&& count($xml->{$attribute}) == 1;
	}
}
