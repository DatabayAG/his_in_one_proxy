<?php

namespace HisInOneProxy\DataModel\Traits;

/**
 * Trait Text
 * @package HisInOneProxy\DataModel\Traits
 */
trait Text
{
    /**
     * @var string
     */
    protected $short_text;

    /**
     * @var string
     */
    protected $long_text;

    /**
     * @var string
     */
    protected $default_text;

    /**
     * @return string
     */
    public function getShortText()
    {
        return $this->short_text;
    }

    /**
     * @param string $short_text
     */
    public function setShortText($short_text)
    {
        $this->short_text = $short_text;
    }

    /**
     * @return string
     */
    public function getLongText()
    {
        return $this->long_text;
    }

    /**
     * @param string $long_text
     */
    public function setLongText($long_text)
    {
        $this->long_text = $long_text;
    }

    /**
     * @return string
     */
    public function getDefaultText()
    {
        return $this->default_text;
    }

    /**
     * @param string $default_text
     */
    public function setDefaultText($default_text)
    {
        $this->default_text = $default_text;
    }
}
