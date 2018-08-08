<?php

namespace HisInOneProxy\REST;

use GuzzleHttp\Client;
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
	 * GuzzleWrapper constructor.
	 * @param $receivers
	 */
	function __construct($receivers)
	{
		$this->receivers = $receivers;
	}

	/**
	 * @var \GuzzleHttp\Client
	 */
	protected $client;

	/**
	 * @var string
	 */
	protected $receivers;

	/**
	 * @return \GuzzleHttp\Client
	 */
	public function getClient()
	{
		if($this->client == null)
		{
			$this->client    = new Client([
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
	 * @param        $method
	 * @param string $uri
	 * @param array  $options
	 * @return mixed|ResponseInterface
	 * @throws \GuzzleHttp\Exception\GuzzleException
	 */
	public function makeRequest($method, $uri = '', $options = array())
	{
		try{
			return $this->getClient()->request($method, $uri, $options);
		}catch(\Exception $e){
			DataCache::getInstance()->getLog()->critical($e->getMessage());
		}
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
		if($response != null)
		{
			$header = $response->getHeaders();
			if(array_key_exists('Location', $header))
			{
				$location = $header['Location'];
				$resource_id = (int) basename(array_pop($location));
				if($resource_id != 0)
				{
					return $resource_id;
				}
			}
		}

		return null;
	}

	/**
	 * @param ResponseInterface $response
	 * @return mixed
	 * @throws \Exception
	 */
	public function getStatusCode($response)
	{
		if($response != null)
		{
			return $response->getStatusCode();
		}
		else
		{
			DataCache::getInstance()->getLog()->critical('Got no response object!');
		}
	}
}
