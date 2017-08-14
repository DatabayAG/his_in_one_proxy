<?php
namespace HisInOneProxy\System;

use HisInOneProxy\Config\GlobalSettings;
use HisInOneProxy\Log\Log;
use HisInOneProxy\Queue\QueueProcess;
use HisInOneProxy\Soap\Interactions\Conductor;
use HisInOneProxy\Soap\Interactions\DataCache;
use HisInOneProxy\Soap\SoapService;
use HisInOneProxy\System\Console\FunctionObject;
use HisInOneProxy\System\Console\Functions;
use Monolog\Formatter\LineFormatter;
use Monolog\Handler\StreamHandler;

require_once 'libs/composer/vendor/autoload.php';

/**
 * Class ConsoleHandler
 * @package HisInOneProxy\System
 */
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
	 * @var FunctionObject[]
	 */
	protected $collection;

	/**
	 * ConsoleHandler constructor.
	 * @param null $term
	 * @param null $year
	 */
	public function __construct($term = null, $year = null)
	{
		$this->startTimer();
		$log           = new Log('debug');
		$streamHandler = new StreamHandler('php://stdout', 'debug');
		$output        = "%message%\n";
		$formatter     = new LineFormatter($output);
		$streamHandler->setFormatter($formatter);
		$log->getLogger()->pushHandler($streamHandler);
		
		if(GlobalSettings::getInstance()->getHisServerUrl() == '/')
		{
			Utils::LogToShellAndExit('No his server url found.');
		}

		self::$conductor = new Conductor($term, $year, $log);
		$this->year      = $year;
		$this->term_id   = $term;

		$this->collection = Functions::getFunctions();
		$this->endTimer('Initialisation');
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

	/**
	 * @param $param
	 */
	protected function readAccount($param)
	{
		$this->startTimer();
		DataCache::getInstance()->getAccountService()->readAccount($param);
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
	
	protected function getCurrentTerm()
	{
		$this->startTimer();
		$lng = DataCache::getInstance()->getValueService()->getDefaultLanguageId();
		$obj = DataCache::getInstance()->getTermService()->getCurrentTerm($lng);
		var_dump($obj);
		$this->endTimer();
	}

	protected function getDefaultLanguageId()
	{
		$this->startTimer();
		$lng = DataCache::getInstance()->getValueService()->getDefaultLanguageId();
		var_dump($lng);
		$this->endTimer();
	}

	/**
	 * @param $param
	 */
	protected function readStudentWithCoursesOfStudyByPersonId($param)
	{
		$this->startTimer();
		$obj = DataCache::getInstance()->getStudentService()->readStudentWithCoursesOfStudyByPersonId($param);
		print_r($obj);
		$this->endTimer();
	}

	/**
	 * @param $param
	 */
	protected function getCourseOfStudyById($param)
	{
		$this->startTimer();
		$obj = DataCache::getInstance()->getCourseOfStudyService()->getCourseOfStudyById($param);
		print_r($obj);
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

	/**
	 * @param $param
	 */
	protected function readPerson($param)
	{
		$this->startTimer();
		$obj = DataCache::getInstance()->getPersonService()->readPerson($param);
		var_dump($obj);
		$this->endTimer();
	}

	protected function unknownCommand()
	{
		DataCache::getInstance()->getLog()->error(sprintf("Unknown command %s.", $_SERVER['argv'][1]));
		echo "\n";
		$this->printHelp();
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

	/**
	 * @param $file
	 * @param $url
	 */
	protected function wsdlDownloader($file, $url)
	{
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_HEADER, false);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_REFERER, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$result = curl_exec($ch);
		curl_close($ch);

		if($result)
		{
			file_put_contents($file, $result);
			DataCache::getInstance()->getLog()->warning(sprintf('Successfully downloaded %s from %s', $file, $url));
		}
		else if( ! $result)
		{
			DataCache::getInstance()->getLog()->warning(sprintf('Failed to download %s from %s', $file, $url));
		}
	}

	public function wsdlHelper()
	{
		$wsdl_files = $this->gatherServicesForWsdl();

		foreach($wsdl_files as $wsdl)
		{
			$file = 'test/wsdl/'.$wsdl;
			if(file_exists($file))
			{
				unlink($file);
			}
			$this->wsdlDownloader($file,  Utils::ensureTrailingSlash(GlobalSettings::getInstance()->getHisServerUrl()) . $file );
		}

		$this->runUnitTests();
	}

	/**
	 * @return array
	 */
	protected function gatherServicesForWsdl()
	{
		$rii = new \RecursiveIteratorIterator(new \RecursiveDirectoryIterator('src/Soap/SoapService/'));
		$services = array();
		foreach($rii as $file)
		{
			if($file->isFile() && $file->getExtension() === 'php')
			{
				$class = str_replace(array('class.', '.php'), '', $file->getBasename());
				$reflection = new \ReflectionClass('HisInOneProxy\Soap\SoapService\\'.$class);
				if(!$reflection->isAbstract() && !$reflection->isInterface() && $reflection->implementsInterface('HisInOneProxy\Soap\SoapService\SoapClientService'))
				{
					/** @var $c SoapService\SoapClientService */
					$map = 'HisInOneProxy\Soap\SoapService\\'.$class;
					$c = new $map;
					$services[] = $c->getServiceWsdl();
				}
			}
		}
		return $services;
	}

	protected function runUnitTests()
	{
		$phpunit = new \PHPUnit\TextUI\TestRunner;
		try
		{
			$test_suite	= $phpunit->getTest('test/GlobalTestSuite.php');
			$config		= $this->getPhpUnitConfig();
			$phpunit->dorun($test_suite, $config);
		}
		catch(\PHPUnit\Framework\Exception $e)
		{
			print $e->getMessage() . "\n";
			die ("Unit tests failed.");
		}
	}

	/**
	 * @return array
	 */
	protected function getPhpUnitConfig()
	{
		if(GlobalSettings::getInstance()->isPhpunitWithCoverage())
		{
			return $this->getPhpUnitConfigWithCoverage();
		}
		else
		{
			return $this->getPhpUnitConfigWithoutCoverage();
		}
	}

	/**
	 * @return array
	 */
	protected function getPhpUnitConfigWithoutCoverage()
	{
		return array('configuration' => 'test/phpunit.xml');
	}

	/**
	 * @return array
	 */
	protected function getPhpUnitConfigWithCoverage()
	{
		return array('configuration' => 'test/phpunit.xml',
					 'coverageText' => true,
					 'coverageTextShowUncoveredFiles' => true,
					 'coverageTextShowOnlySummary' => true);
	}

	protected function startTimer()
	{
		$this->start_time = microtime(true);
	}

	/**
	 * @param string $what
	 */
	protected function endTimer($what = 'Queries')
	{
		$end_time = microtime(true);
		DataCache::getInstance()->getLog()->info(sprintf($what . ' took %s seconds for %s soap calls.', 
			round($end_time - $this->start_time, 4), 
			GlobalSettings::getInstance()->getCallsCounter()
			)
		);
	}

	public function printHelp()
	{
		echo "Usage: ConsoleHandler.php function [term] [year] [param]\n";

		foreach($this->collection as $func)
		{
			if(GlobalSettings::getInstance()->isDebug() && $func->isDebug())
			{
				$this->printHelpLine($func, true);
			}
			else
			{
				$this->printHelpLine($func);
			}
		}
		Utils::terminate(0);
	}

	/**
	 * @param \HisInOneProxy\System\Console\FunctionObject $func
	 * @param $debug
	 */
	protected function printHelpLine($func, $debug = false)
	{
		$string = '';
		if($debug)
		{
			$string = '(Debug)';
		}
		echo "\t\t " . $func->getId() . " => $string " . $func->getComment() . "\n";
	}
}