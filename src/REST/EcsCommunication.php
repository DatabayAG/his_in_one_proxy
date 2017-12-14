<?php

namespace HisInOneProxy\REST;

use HisInOneProxy\Config\GlobalSettings;
use HisInOneProxy\Soap\Interactions\DataCache;

/**
 * Class EcsCommunication
 * @package HisInOneProxy\REST
 */
class EcsCommunication
{
	/**
	 * @var GuzzleWrapper
	 */
	protected $client;

	/**
	 * @var EcsResources
	 */
	protected $resources;

	/**
	 * EcsCommunication constructor.
	 * @param $receiver
	 */
	function __construct($receiver)
	{
		$this->client = new GuzzleWrapper(GlobalSettings::getInstance()->getReceiverMemberships());
		$this->resources = new EcsResources();
	}

	/**
	 * @param $json
	 * @return bool
	 */
	public function publishCourseToEcs($json)
	{
		try{
			$response = $this->client->makeRequest('POST', GlobalSettings::getInstance()->getEcsServerUrl() . $this->resources->getCoursePath(), ['json' => $json, 'auth' => [GlobalSettings::getInstance()->getEcsAuthId(), GlobalSettings::getInstance()->getEcsPassword()] ]);
			$resource_id = $this->client->getLocationHeader($response);

			if($this->client->getStatusCode($response) == HttpStatusCode::CREATED)
			{
				return true;
			}
		}catch(\Exception $e){
			DataCache::getInstance()->getLog()->warning(sprintf('Something went wrong %s.', $e->getMessage()));
		}
		return false;
	}

	/**
	 * @param $json
	 * @return bool
	 */
	public function publishMembersToEcs($json)
	{
		try{
			$response = $this->client->makeRequest('POST', GlobalSettings::getInstance()->getEcsServerUrl() . $this->resources->getMembersUrlPath(), ['json' => $json, 'auth' => [GlobalSettings::getInstance()->getEcsAuthId(), GlobalSettings::getInstance()->getEcsPassword()] ]);
			if($this->client->getStatusCode($response) == HttpStatusCode::CREATED)
			{
				return true;
			}
		}catch(\Exception $e){
			DataCache::getInstance()->getLog()->warning(sprintf('Something went wrong %s.', $e->getMessage()));
		}
		return false;
	}

	/**
	 * @param $json
	 * @return bool
	 */
	public function publishCourseCatalogToEcs($json)
	{
		try{
			$response = $this->client->makeRequest('POST', GlobalSettings::getInstance()->getEcsServerUrl() . $this->resources->getCourseCatalogUrlPath(), ['json' => $json, 'auth' => [GlobalSettings::getInstance()->getEcsAuthId(), GlobalSettings::getInstance()->getEcsPassword()] ]);
			if($this->client->getStatusCode($response) == HttpStatusCode::CREATED)
			{
				return true;
			}
		}catch(\Exception $e){
			DataCache::getInstance()->getLog()->warning(sprintf('Something went wrong %s.', $e->getMessage()));
		}
		return false;
	}

	/**
	 * @param $path
	 * @param $course_urls
	 */
	public function getCourseIds($path, $course_urls)
	{
		$response = $this->client->makeRequest('GET', GlobalSettings::getInstance()->getEcsServerUrl() . $this->resources->getCoursePath() . $path, [ 'auth' => [GlobalSettings::getInstance()->getEcsAuthId(), GlobalSettings::getInstance()->getEcsPassword()] ]);
		$content = $this->client->getContent($response);
		$json = json_decode($content);
		$id = null;
		if(is_object($json))
		{
			if(array_key_exists('lectureID', $json))
			{
				$id = $json->lectureID;
			}
			else if(array_key_exists('courseID', $json))
			{
				$id = $json->courseID;
			}
			else if(array_key_exists('id', $json))
			{
				$id = $json->id;
			}
			else
			{
				DataCache::getInstance()->getLog()->warning(sprintf('Did not find an export id for id %s.', $path));
			}
			var_dump($id);
			var_dump($course_urls);
		}
		else
		{
			DataCache::getInstance()->getLog()->warning(sprintf('Did not get back valid json for id %s.', $path));
		}
	}

	public function getCoursesUrls()
	{
		$response = $this->client->makeRequest('GET', GlobalSettings::getInstance()->getEcsServerUrl() . $this->resources->getCourseUrlPath(), ['auth' => [GlobalSettings::getInstance()->getEcsAuthId(), GlobalSettings::getInstance()->getEcsPassword()] ]);
		if($this->client->getStatusCode($response) == HttpStatusCode::OK)
		{
			$content = $this->client->getContent($response);
			$array = preg_split('/\n/', $content);
			if(count($array) > 0)
			{
				foreach($array as $path)
				{
					if($path != "")
					{
						$response = $this->client->makeRequest('GET', GlobalSettings::getInstance()->getEcsServerUrl() . $this->resources->getPlainPath() . $path, ['auth' => [GlobalSettings::getInstance()->getEcsAuthId(), GlobalSettings::getInstance()->getEcsPassword()] ]);
						$content = json_decode($this->client->getContent($response));
						if(isset($content->ecs_course_url) && $content->ecs_course_url != '')
						{
							$path = $content->ecs_course_url;
							if(isset($content->lms_course_urls) && is_array($content->lms_course_urls))
							{
								var_dump($content);
								foreach($content->lms_course_urls as $lms_course_url)
								{
									var_dump($lms_course_url->url);
								}
							}
							#$this->getCourseIds(basename($path),$content->lms_course_urls );
						}
					}
				}

			}
		}
	}

}