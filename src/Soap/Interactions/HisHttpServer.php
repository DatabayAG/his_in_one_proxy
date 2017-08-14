<?php

namespace HisInOneProxy\Soap\Interactions;

require_once './libs/composer/vendor/autoload.php';

use GuzzleHttp\Psr7\Response;
use HisInOneProxy\Config;
use HisInOneProxy\Queue;
use Psr\Http\Message\ServerRequestInterface;
use React\EventLoop\Factory;
use React\Http\Server;
use React\Promise\Promise;

/**
 * Class HisHttpServer
 * @package HisInOneProxy\Soap\Interactions
 */
class HisHttpServer
{
	/**
	 * @var false|int|string
	 */
	protected $start_time = 0;

	/**
	 * @var int
	 */
	protected $events = 0;

	/**
	 * @var \React\EventLoop\ExtEventLoop|\React\EventLoop\LibEventLoop|\React\EventLoop\LibEvLoop|\React\EventLoop\StreamSelectLoop
	 */
	protected $loop;

	/**
	 * @var Queue\SimpleQueue
	 */
	protected $queue;

	/**
	 * EcsHttpServer constructor.
	 */
	public function __construct()
	{
		$this->loop = Factory::create();

		$this->init();

		$this->start_time = date("Y-m-d H:i:s");
		$this->queue = new Queue\SimpleQueue();
	}

	protected function init()
	{
		#$this->addAliveTimer();
		#$this->addHisMessageTimer();

		$server = new Server(function (ServerRequestInterface $request) {
			return new Promise(function ($resolve, $reject) use ($request) {
				$contentLength = 0;

				$body = "The method of the request is: " . $request->getMethod(). "\n";
				$body .= "The requested path is: " . $request->getUri()->getPath() . "\n";
				$body .= "The UserAgent is: " . $request->getHeaderLine('User-Agent') . "\n";
				echo $body;
				if($request->getUri()->getPath() == '/sys/events/fifo')
				{
					
				}

				$request->getBody()->on('data', function ($data) use (&$contentLength, &$request)
				{
					echo $data;
					$contentLength += strlen($data);
					$body = "The method of the request is: " . $request->getMethod();
					$body .= "\nThe requested path is: " . $request->getUri()->getPath();
					echo "$body\n";
					$this->queue->push(Queue\QueueConstants::INSTITUTION_ORG_SERVICE, $data);
					$this->events++;
				});

				$request->getBody()->on('end', function () use ($resolve, &$contentLength, &$request)
				{
					$response = new Response(
						200,
						array('Content-Type' => 'text/plain')
					);
					$resolve($response);
				});

				$request->getBody()->on('error', function (\Exception $exception) use ($resolve, &$contentLength) 
				{
					$response = new Response(
						400,
						array('Content-Type' => 'text/plain'),
						"An error occured while reading at length: " . $contentLength
					);
					$resolve($response);
				});
			});
		});
		$socket = new \React\Socket\Server(Config\GlobalSettings::getInstance()->getEndPoint()->getUrlWithPort() , $this->loop);
		$server->listen($socket);
	}

	protected function addAliveTimer()
	{
		$this->loop->addPeriodicTimer(5, function ()
		{
			$memory    = memory_get_usage(true) / 1024;
			$formatted = number_format($memory, 3) . 'K';
			DataCache::getInstance()->getLog()->debug( "Current memory usage: {$formatted}\n");
			DataCache::getInstance()->getLog()->debug(sprintf("Got %s events, since start time %s\n", $this->events, $this->start_time));
		});
	}

	public function run()
	{
		$this->loop->run();
	}
}
if(!defined('PHPUNIT'))
{
	$server = new HisHttpServer();
	$server->run();
}
