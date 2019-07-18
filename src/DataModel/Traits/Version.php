<?php

namespace HisInOneProxy\DataModel\Traits;

/**
 * Trait Version
 * @package HisInOneProxy\DataModel\Traits
 */
trait Version
{
    /**
     * @var string
     */
    protected $version_comment;

    /**
     * @var string
     */
    protected $version_tag;

    /**
     * @return string
     */
    public function getVersionTag()
    {
        return $this->version_tag;
    }

    /**
     * @param string $version_tag
     */
    public function setVersionTag($version_tag)
    {
        $this->version_tag = $version_tag;
    }

    /**
     * @return string
     */
    public function getVersionComment()
    {
        return $this->version_comment;
    }

    /**
     * @param string $version_comment
     */
    public function setVersionComment($version_comment)
    {
        $this->version_comment = $version_comment;
    }
}
