<?php

namespace HisInOneProxy\Parser;

use HisInOneProxy\DataModel;

/**
 * Class ParseVisibleChildren
 * @package HisInOneProxy\Parser
 */
class ParseVisibleChildren extends SimpleXmlParser
{
    /**
     * @param $xml
     * @return DataModel\VisibleChild[]
     */
    public function parse($xml)
    {
        $container = array();

        if ($this->doesMoreThanOneElementExists($xml->allVisibleChildren, 'visibleChild')) {
            foreach ($xml->allVisibleChildren->visibleChild as $value) {
                $child = $this->buildObjectFromData($value);
                if ($child != null) {
                    $container[(string) $child->getUnitId()] = $child;
                }
            }
        } else {
            if ($this->doesExactlyOneElementExists($xml->allVisibleChildren, 'visibleChild')) {
                $child = $this->buildObjectFromData($xml->allVisibleChildren->visibleChild);
                if ($child != null) {
                    $container[(string) $child->getUnitId()] = $child;
                }
            }
        }

        return $container;
    }

    /**
     * @param $value
     * @return DataModel\VisibleChild | null
     */
    protected function buildObjectFromData($value)
    {
        if ($this->isAttributeValid($value, 'unitId')) {
            $child = new DataModel\VisibleChild();
            $child->setUnitId($value->unitId);
            $this->log->info(sprintf('Found VisibleChild with id %s.', $child->getUnitId()));
            if ($this->isAttributeValid($value, 'parentUnitId')) {
                $child->setParentUnitId($value->parentUnitId);
            }
            if ($this->isAttributeValid($value, 'relationTypeId')) {
                $child->setRelationTypeId($value->relationTypeId);
            }
            if ($this->isAttributeValid($value, 'sortorder')) {
                $child->setSortOrder($value->sortorder);
            }
            if ($this->isAttributeValid($value, 'childDefaulttext')) {
                $child->setChildDefaultText($value->childDefaulttext);
            }
            if ($this->isAttributeValid($value, 'childElementnr')) {
                $child->setChildElements($value->childElementnr);
            }
            return $child;
        } else {
            $this->log->warning('No id given for VisibleChild, skipping!');
        }
        return null;
    }
}