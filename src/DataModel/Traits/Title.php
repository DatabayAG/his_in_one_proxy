<?php

namespace HisInOneProxy\DataModel\Traits;

/**
 * Trait Title
 * @package HisInOneProxy\DataModel\Traits
 */
trait Title
{

    /**
     * @var string
     */
    protected $title;

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param string $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

}