<?php
namespace HisInOneProxy\System;

use HisInOneProxy\Config\GlobalSettings;
use HisInOneProxy\Log\Log;
use HisInOneProxy\Queue\QueueProcess;
use HisInOneProxy\Soap\Interactions\Conductor;
use HisInOneProxy\Soap\Interactions\DataCache;
use HisInOneProxy\System\Console\Functions;
use Monolog\Formatter\LineFormatter;
use Monolog\Handler\StreamHandler;

class ConsoleHandler
{
	/**
	 * @var Conductor
	 */
	protected static $conductor;

	/**
	 * @var int
	 */
	protected $start_time;

	/**
	 * @var int
	 */
	protected $year;

	/**
	 * @var int
	 */
	protected $term_id;

	/**
	 * @var array
	 */
	protected $collection;

	/**
	 * ConsoleHandler constructor.
	 * @param null $term
	 * @param null $year
	 */
	public function __construct($term = null, $year = null)
	{
		$log           = new Log('debug');
		$streamHandler = new StreamHandler('php://stdout', 'debug');
		$output        = "%message%\n";
		$formatter     = new LineFormatter($output);
		$streamHandler->setFormatter($formatter);
		$log->getLogger()->pushHandler($streamHandler);

		self::$conductor = new Conductor($term, $year, $log);
		$this->year      = $year;
		$this->term_id   = $term;

		$this->collection = Functions::getFunctions();
	}

	protected function getLectures()
	{
		$this->startTimer();
		self::$conductor->getAllLecturesForThisTerm();
		$this->endTimer();
	}

	protected function startQueue()
	{
		$this->startTimer();
		$queue = new QueueProcess();
		$queue->startQueueProcess();
		$this->endTimer();
	}

	/**
	 * @param $id
	 */
	protected function getLectureById($id)
	{
		$this->startTimer();
		self::$conductor->getLectureByUnitIdForTerm($id);
		$this->endTimer();
	}

	protected function getInstitutions()
	{
		$this->startTimer();
		self::$conductor->getInstitutionsAndOrgUnits();
		$this->endTimer();
	}

	protected function getCourseCatalog()
	{
		$this->startTimer();
		self::$conductor->getCourseCatalog();
		$this->endTimer();
	}

	protected function getRootIdOfTerm()
	{
		$this->startTimer();
		if($this->year == '')
		{
			$this->year = self::$conductor->getYear();
		}
		if($this->term_id == '')
		{
			$this->term_id = self::$conductor->getTerm();
		}
		$id = DataCache::getInstance()->getCourseCatalogService()->getRootIdOfTerm($this->year, $this->term_id);
		if($id != '')
		{
			DataCache::getInstance()->getLog()->info(sprintf('Found %s as root id of term for term id (%s) and year (%s).', $id, $this->term_id, $this->year));
		}
		else
		{
			DataCache::getInstance()->getLog()->info(sprintf('Found nothing as root id of term for term id (%s) and year (%s).', $this->term_id, $this->year));
		}
		$this->endTimer();
	}

	/**
	 * @param $param
	 */
	protected function getCourseCatalogLeaf($param)
	{
		$this->startTimer();
		$leaf = DataCache::getInstance()->getCourseCatalogService()->getCourseCatalogLeaf($param);
		print_r($leaf);
		$this->endTimer();
	}

	protected function getAllParallelGroups()
	{
		$this->startTimer();
		$lng = DataCache::getInstance()->getValueService()->getDefaultLanguageId();
		$obj = DataCache::getInstance()->getValueService()->getAllParallelGroups($lng);
		var_dump($obj);
		$this->endTimer();
	}

	protected function getAllWorkStatus()
	{
		$this->startTimer();
		$lng = DataCache::getInstance()->getValueService()->getDefaultLanguageId();
		$obj = DataCache::getInstance()->getValueService()->getAllWorkStatus($lng);
		var_dump($obj);
		$this->endTimer();
	}

	protected function getAllElearningPlatforms()
	{
		$this->startTimer();
		$lng = DataCache::getInstance()->getValueService()->getDefaultLanguageId();
		$obj = DataCache::getInstance()->getValueService()->getAllElearningPlatforms($lng);
		var_dump($obj);
		$this->endTimer();
	}

	protected function getAllTermTypes()
	{
		$this->startTimer();
		$lng = DataCache::getInstance()->getValueService()->getDefaultLanguageId();
		$obj = DataCache::getInstance()->getValueService()->getAllTermTypes($lng);
		var_dump($obj);
		$this->endTimer();
	}

	protected function unknownCommand()
	{
		DataCache::getInstance()->getLog()->error(sprintf("Unknown command %s.", $_SERVER['argv'][1]));
		echo "\n";
		$this->printHelp();
	}

	public function printHelp()
	{
		echo "Usage: ConsoleHandler.php function [term] [year] [param]\n";

		foreach($this->collection as $func)
		{
			$debug = '';
			if(GlobalSettings::getInstance()->isDebug() && $func->isDebug())
			{
				echo "\t\t " . $func->getId() . " => " . $func->getComment() . " (Debug)\n";
			}
			else
			{
				echo "\t\t " . $func->getId() . " => " . $func->getComment() . "$debug\n";
			}
		}
		exit(1);
	}

	protected function startTimer()
	{
		$this->start_time = microtime(TRUE);
	}

	protected function endTimer()
	{
		$end_time = microtime(TRUE);
		DataCache::getInstance()->getLog()->info(sprintf('Queries took %s seconds.', round($end_time - $this->start_time, 4)));
	}

	/**
	 * @param $func
	 * @param $param
	 */
	public function functionMap($func, $param)
	{
		if(array_key_exists($func, $this->collection) && 
			method_exists($this, $this->collection[$func]->getFunction())
		)
		{
			if(($this->collection[$func]->isDebug() && GlobalSettings::getInstance()->isDebug()) ||
				($this->collection[$func]->isDebug() === false))
			{
				$this->{$this->collection[$func]->getFunction()}($param);
			}
			else
			{
				$this->unknownCommand();
			}
		}
		else
		{
			$this->unknownCommand();
		}
	}
}