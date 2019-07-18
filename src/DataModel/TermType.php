<?php

namespace HisInOneProxy\DataModel;

use HisInOneProxy\Config\GlobalSettings;
use HisInOneProxy\DataModel\Traits;

/**
 * Class TermType
 * @package HisInOneProxy\DataModel
 */
class TermType
{

    const TEXT = 'term';

    use Traits\LanguageId, Traits\SortingOrder, Traits\ObjGuid, Traits\TermNumber, Traits\UniqueNameAndText;

    /**
     * @var int
     */
    protected $term_category;

    /**
     * @return string
     */
    public function getText()
    {
        if (array_key_exists(self::TEXT, GlobalSettings::getInstance()->getTextConfig())) {
            if (method_exists($this, GlobalSettings::getInstance()->getTextConfig()[self::TEXT])) {
                return $this->{GlobalSettings::getInstance()->getTextConfig()[self::TEXT]}();
            }
        }
        return $this->getDefaultText();
    }

    /**
     * @return int
     */
    public function getTermCategory()
    {
        return $this->term_category;
    }

    /**
     * @param int $term_category
     */
    public function setTermCategory($term_category)
    {
        $this->term_category = $term_category;
    }
}