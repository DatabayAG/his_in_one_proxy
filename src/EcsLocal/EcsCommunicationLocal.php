<?php

namespace HisInOneProxy\EcsLocal;

use HisInOneProxy\REST\EcsResources;
use HisInOneProxy\REST\GuzzleWrapper;

class EcsCommunicationLocal implements EcsCommunicationInterface
{

    protected GuzzleWrapper $client;
    protected EcsResources $resources;

    function __construct($receiver)
    {
        $this->client    = new GuzzleWrapper($receiver);
        $this->resources = new EcsResources();
    }
    public function publishCourseToEcs($json): bool
    {
        return true;
    }

    public function publishMembersToEcs($json): bool
    {
        // TODO: Implement publishMembersToEcs() method.
    }

    public function publishCourseCatalogToEcs($json): bool
    {
        // TODO: Implement publishCourseCatalogToEcs() method.
    }

    public function getCourseIds($path, $course_urls)
    {
        // TODO: Implement getCourseIds() method.
    }

    public function getCoursesUrls()
    {
        // TODO: Implement getCoursesUrls() method.
    }
}
