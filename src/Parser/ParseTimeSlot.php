<?php

namespace HisInOneProxy\Parser;

use HisInOneProxy\DataModel;

/**
 * Class ParseTimeSlot
 * @package HisInOneProxy\Parser
 */
class ParseTimeSlot extends SimpleXmlParser
{

    /**
     * @param $xml
     * @return DataModel\TimeSlot|null
     */
    public function parse($xml)
    {
        $time_slot = new DataModel\TimeSlot();

        if ($this->isAttributeValid($xml, 'id')) {
            $time_slot->setId($xml->id);
            $this->log->info(sprintf('Found TimeSlot with id %s.', $time_slot->getId()));
            if ($this->isAttributeValid($xml, 'objGuid')) {
                $time_slot->setObjGuid($xml->objGuid);
            }
            if ($this->isAttributeValid($xml, 'lockVersion')) {
                $time_slot->setLockVersion($xml->lockVersion);
            }
            if ($this->isAttributeValid($xml, 'starttime')) {
                $time_slot->setStartTime($xml->starttime);
            }
            if ($this->isAttributeValid($xml, 'endtime')) {
                $time_slot->setEndTime($xml->endtime);
            }
            if ($this->isAttributeValid($xml, 'weekdayId')) {
                $time_slot->setWeekDay($xml->weekdayId);
            }
            return $time_slot;
        } else {
            $this->log->warning('No id given for TimeSlot, skipping!');
        }
        return null;
    }
}
