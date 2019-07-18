<?php

namespace HisInOneProxy\Soap\SoapService;

use HisInOneProxy\Config\GlobalSettings;

/**
 * Class ConfigClient
 * @package HisInOneProxy\Soap\SoapService
 */
class ConfigClient
{
    /**
     * @return resource
     */
    public function getSSlConfig()
    {
        if (GlobalSettings::getInstance()->getValidateSsl() == "true") {
            return $this->getSSlActivateValidationConfig();
        } else {
            return $this->getSSlDisableValidationConfig();
        }
    }

    /**
     * @return resource
     */
    protected function getSSlActivateValidationConfig()
    {
        return stream_context_create(array(
            'ssl' => array(
                'verify_peer'       => true,
                'verify_peer_name'  => true,
                'allow_self_signed' => false
            )
        ));
    }

    /**
     * @return resource
     */
    protected function getSSlDisableValidationConfig()
    {
        return stream_context_create(array(
            'ssl' => array(
                'verify_peer'       => false,
                'verify_peer_name'  => false,
                'allow_self_signed' => true
            )
        ));
    }
}