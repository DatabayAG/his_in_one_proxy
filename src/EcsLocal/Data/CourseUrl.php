<?php

namespace HisInOneProxy\EcsLocal\Data;

class CourseUrl
{
    protected string $title = '';
    protected string $url = '';

    /**
     * @param string $title
     * @param string $url
     */
    public function __construct(string $title, string $url)
    {
        $this->title = $title;
        $this->url = $url;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getUrl(): string
    {
        return $this->url;
    }

}
