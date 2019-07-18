<?php

namespace HisInOneProxy\DataModel;

use HisInOneProxy\DataModel\Traits;

/**
 * Class Language
 * @package HisInOneProxy\DataModel
 */
class Language
{

    use Traits\DefaultLanguage, Traits\ObjGuid, Traits\SortingOrder, Traits\Text, Traits\UniqueName;

    /**
     * @var string
     */
    protected $iso_639_1;

    /**
     * @var string
     */
    protected $iso_639_2;

    /**
     * @return string
     */
    public function getIso6391()
    {
        return $this->iso_639_1;
    }

    /**
     * @param string $iso_639_1
     */
    public function setIso6391($iso_639_1)
    {
        $this->iso_639_1 = $iso_639_1;
    }

    /**
     * @return string
     */
    public function getIso6392()
    {
        return $this->iso_639_2;
    }

    /**
     * @param string $iso_639_2
     */
    public function setIso6392($iso_639_2)
    {
        $this->iso_639_2 = $iso_639_2;
    }
}