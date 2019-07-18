<?php

namespace HisInOneProxy\DataModel;

use HisInOneProxy\System\Utils;

/**
 * Class Endpoint
 * @package HisInOneProxy\DataModel
 */
class Endpoint
{

    /**
     * @var string
     */
    protected $end_point_url;

    /**
     * @var string
     */
    protected $port;

    /**
     * @var string
     */
    protected $web_service_method;

    /**
     * @var string
     */
    protected $user_name;

    /**
     * @var string
     */
    protected $password;

    /**
     * @return string
     */
    public function getWebServiceMethod()
    {
        return $this->web_service_method;
    }

    /**
     * @param string $web_service_method
     */
    public function setWebServiceMethod($web_service_method)
    {
        $this->web_service_method = $web_service_method;
    }

    /**
     * @return string
     */
    public function getUserName()
    {
        return $this->user_name;
    }

    /**
     * @param string $user_name
     */
    public function setUserName($user_name)
    {
        $this->user_name = $user_name;
    }

    /**
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->password = $password;
    }

    /**
     * @return string
     */
    public function getUrlWithPort()
    {
        return Utils::ensureTrailingSlash($this->getEndPointUrl() . ':' . $this->getPort());
    }

    /**
     * @return string
     */
    public function getEndPointUrl()
    {
        return $this->end_point_url;
    }

    /**
     * @param string $end_point_url
     */
    public function setEndPointUrl($end_point_url)
    {
        $this->end_point_url = $end_point_url;
    }

    /**
     * @return string
     */
    public function getPort()
    {
        return $this->port;
    }

    /**
     * @param string $port
     */
    public function setPort($port)
    {
        $this->port = $port;
    }
}