<?php

namespace HisInOneProxy\REST;

use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use HisInOneProxy\Config\GlobalSettings;
use HisInOneProxy\Soap\Interactions\DataCache;
use Psr\Http\Message\ResponseInterface;

/**
 * Class GuzzleWrapper
 * @package HisInOneProxy\REST
 */
class GuzzleWrapper
{
    /**
     * @var Client
     */
    protected $client;
    /**
     * @var string
     */
    protected $receivers;

    /**
     * GuzzleWrapper constructor.
     * @param $receivers
     */
    function __construct($receivers)
    {
        $this->receivers = $receivers;
    }

    /**
     * @param        $method
     * @param string $uri
     * @param array  $options
     * @return mixed|ResponseInterface
     * @throws GuzzleException
     */
    public function makeRequest($method, $uri = '', $options = array())
    {
        try {
            return $this->getClient()->request($method, $uri, $options);
        } catch (Exception $e) {
            DataCache::getInstance()->getLog()->critical($e->getMessage());
        }
    }

    /**
     * @return Client
     */
    public function getClient()
    {
        if ($this->client == null) {
            $this->client = new Client([
                'headers' => [
                    'X-EcsReceiverMemberships' => $this->receivers,
                    //'X-EcsReceiverCommunities' => 2,
                    'X-EcsAuthId'              => GlobalSettings::getInstance()->getEcsAuthId(),
                    'X-EcsPassword'            => GlobalSettings::getInstance()->getEcsPassword(),
                    'Content-Type'             => 'application/json'
                ]

            ]);
        }
        return $this->client;
    }

    /**
     * @param ResponseInterface $response
     * @return string
     */
    public function getContent($response)
    {
        return $response->getBody()->getContents();
    }

    /**
     * @param ResponseInterface $response
     * @return string | null
     */
    public function getLocationHeader($response)
    {
        if ($response != null) {
            $header = $response->getHeaders();
            if (array_key_exists('Location', $header)) {
                $location    = $header['Location'];
                $resource_id = (int) basename(array_pop($location));
                if ($resource_id != 0) {
                    return $resource_id;
                }
            }
        }

        return null;
    }

    /**
     * @param ResponseInterface $response
     * @return mixed
     * @throws Exception
     */
    public function getStatusCode($response)
    {
        if ($response != null) {
            return $response->getStatusCode();
        } else {
            DataCache::getInstance()->getLog()->critical('Got no response object!');
        }
    }
}
