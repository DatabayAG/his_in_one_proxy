<?php

namespace HisInOneProxy\EcsLocal;

interface EcsCommunicationInterface
{
    public function publishCourseToEcs($json): bool;
    public function publishMembersToEcs($json): bool;
    public function publishCourseCatalogToEcs($json): bool;
    public function getCourseIds($path, $course_urls);
    public function getCoursesUrls();
}
