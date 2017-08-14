<?php

namespace HisInOneProxy\Parser;

use HisInOneProxy\DataModel;

/**
 * Class ParseElearningPlatform
 * @package HisInOneProxy\Parser
 */
class ParseElearningPlatform extends SimpleXmlParser
{
	/**
	 * @param $xml
	 * @return DataModel\Container\ElearningPlatformContainer
	 */
	public function parse($xml)
	{
		$container = new DataModel\Container\ElearningPlatformContainer();
		if($this->isAttributeValid($xml, 'elearningplatform'))
		{
			foreach($xml->elearningplatform as $value)
			{
				$platform = new DataModel\ElearningPlatform();
				if(isset($value->id) && $value->id != null && $value->id != '')
				{
					$platform->setId($value->id);
					$this->log->info(sprintf('Found elearning plattfomr mapping with id %s.', $platform->getId()));

					if($this->isAttributeValid($value, 'uniquename'))
					{
						$platform->setUniqueName($value->uniquename);
					}
					if($this->isAttributeValid($value, 'shorttext'))
					{
						$platform->setShortText($value->shorttext);
					}
					if($this->isAttributeValid($value, 'defaulttext'))
					{
						$platform->setDefaultText($value->defaulttext);
					}
					if($this->isAttributeValid($value, 'longtext'))
					{
						$platform->setLongText($value->longtext);
					}
					if($this->isAttributeValid($value, 'sortorder'))
					{
						$platform->setSortOrder($value->sortorder);
					}
					if($this->isAttributeValid($value, 'defaultlanguage'))
					{
						$platform->setLanguageId($value->defaultlanguage);
					}
					if($this->isAttributeValid($value, 'objGuid'))
					{
						$platform->setObjGuid($value->objGuid);
					}
					if($this->isAttributeValid($value, 'connectioninfo'))
					{
						$platform->setConnectionInfo($value->connectioninfo);
					}
					if($this->isAttributeValid($value, 'hiskeyId'))
					{
						$platform->setHisKeyId($value->hiskeyId);
					}
					$container->appendElearningPlatform($platform);
				}
				else
				{
					$this->log->warning('No id given for elearning course mapping, skipping!');
				}
			}
		}

		return $container;
	}
}