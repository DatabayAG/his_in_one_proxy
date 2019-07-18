<?php

namespace HisInOneProxy\Parser;

use HisInOneProxy\DataModel;

/**
 * Class ParseWorkStatus
 * @package HisInOneProxy\Parser
 */
class ParseWorkStatus extends SimpleXmlParser
{
    /**
     * @param $xml
     * @return DataModel\Container\WorkStatusContainer
     */
    public function parse($xml)
    {
        $container = new DataModel\Container\WorkStatusContainer();
        if (isset($xml->workstatusvalue)) {
            foreach ($xml->workstatusvalue as $value) {
                $work_status = new DataModel\WorkStatus();
                if ($this->isAttributeValid($value, 'id')) {
                    $work_status->setId($value->id);
                    $this->log->info(sprintf('Found work status with id %s.', $work_status->getId()));

                    if ($this->isAttributeValid($value, 'uniquename')) {
                        $work_status->setUniqueName($value->uniquename);
                    }
                    if ($this->isAttributeValid($value, 'shorttext')) {
                        $work_status->setShortText($value->shorttext);
                    }
                    if ($this->isAttributeValid($value, 'defaulttext')) {
                        $work_status->setDefaultText($value->defaulttext);
                    }
                    if ($this->isAttributeValid($value, 'longtext')) {
                        $work_status->setLongText($value->longtext);
                    }
                    if ($this->isAttributeValid($value, 'uniquename')) {
                        $work_status->setSortOrder($value->sortorder);
                    }
                    if ($this->isAttributeValid($value, 'defaultlanguage')) {
                        $work_status->setLanguageId($value->defaultlanguage);
                    }
                    if ($this->isAttributeValid($value, 'objGuid')) {
                        $work_status->setObjGuid($value->objGuid);
                    }
                    $container->appendWorkStatus($work_status);
                } else {
                    $this->log->warning('No id given for work status, skipping!');
                }
            }
        }

        return $container;
    }
}