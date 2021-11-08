<?php

namespace HisInOneProxy\System;

use Exception;
use HisInOneProxy\Config\GlobalSettings;
use HisInOneProxy\DataModel\Person;
use HisInOneProxy\Log\Log;
use HisInOneProxy\Queue\QueueProcess;
use HisInOneProxy\Soap\Interactions\Conductor;
use HisInOneProxy\Soap\Interactions\DataCache;
use HisInOneProxy\Soap\Interactions\DataPrinter;
use HisInOneProxy\Soap\Interactions\HisHttpServer;
use HisInOneProxy\Soap\SoapService;
use HisInOneProxy\System\Console\FunctionObject;
use HisInOneProxy\System\Console\Functions;
use Monolog\Formatter\LineFormatter;
use Monolog\Handler\StreamHandler;
use PHPUnit\TextUI\TestRunner;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;
use ReflectionClass;
use ReflectionException;

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
     * @var DataPrinter
     */
    protected $printer;

    /**
     * ConsoleHandler constructor.
     * @param null $term
     * @param null $year
     * @throws Exception
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

        if (GlobalSettings::getInstance()->getHisServerUrl() == '/') {
            Utils::LogToShellAndExit('No his server url found.');
        }

        self::$conductor = new Conductor($term, $year, $log);
        $this->year      = $year;
        $this->term_id   = $term;

        $this->printer    = new DataPrinter();
        $this->collection = Functions::getFunctions();
        $this->endTimer('Initialisation');
    }

    protected function startTimer()
    {
        $this->start_time = microtime(true);
    }

    /**
     * @param string $what
     * @throws Exception
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

    /**
     * @throws Exception
     */
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
     * @throws Exception
     */
    protected function getLectureById($id)
    {
        $this->startTimer();
        self::$conductor->getLectureByUnitIdForTerm($id);
        $this->endTimer();
    }

	/**
	 * 
	 */
	protected function getAllCourseMappingTypes()
	{
		$this->startTimer();
        /*
        $lng = $this->getDefaultLanguageId();
		$obj = DataCache::getInstance()->getValueService()->getAllCourseMappingTypes($lng);
		print_r($obj);
        */
        print "ValueService does not exists anymore. Have to check where to get the values from now.";
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

	protected function getAllBlockeds()
	{
		$this->startTimer();
        $lng = $this->getDefaultLanguageId();
		DataCache::getInstance()->getValueService()->getAllBlockeds($lng);
		$this->endTimer();
	}

    protected function startHisListener()
    {
        $this->startTimer();
        $server = new HisHttpServer();
        $server->run();
        #$server = new HisHttpServerProcess();
        #$server->startHisServer();
        $this->endTimer();
    }

    protected function getRootIdOfTerm()
    {
        $this->startTimer();
        if ($this->year == '') {
            $this->year = self::$conductor->getYear();
        }
        if ($this->term_id == '') {
            $this->term_id = self::$conductor->getTerm();
        }
        $id = DataCache::getInstance()->getCourseCatalogService()->getRootIdOfTerm($this->year, $this->term_id);
        if ($id != '') {
            DataCache::getInstance()->getLog()->info(sprintf('Found %s as root id of term for term id (%s) and year (%s).', $id, $this->term_id, $this->year));
        } else {
            DataCache::getInstance()->getLog()->info(sprintf('Found nothing as root id of term for term id (%s) and year (%s).', $this->term_id, $this->year));
        }
        $this->endTimer();
    }

    /**
     * @param $param
     * @throws Exception
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
		$lng = $this->getDefaultLanguageId();
		$obj = DataCache::getInstance()->getKeyValueService()->getAllValid('ParallelgroupValue', $lng);
		print_r($obj);
		$this->endTimer();
	}

	protected function getAllGenders()
	{
		$this->startTimer();
        $lng = $this->getDefaultLanguageId();
		$obj = DataCache::getInstance()->getKeyValueService()->getAllValid('GenderValue', $lng);
		print_r($obj);
		$this->endTimer();
	}

	protected function getAllElementtypes()
	{
		$this->startTimer();
        $lng = $this->getDefaultLanguageId();
		$obj = DataCache::getInstance()->getKeyValueService()->getAllValid('ElementtypeValue', $lng);
		print_r($obj);
		$this->endTimer();
	}

	protected function getAllEventtypes()
	{
		$this->startTimer();
        $lng = $this->getDefaultLanguageId();
		$obj = DataCache::getInstance()->getKeyValueService()->getAllValid('EventtypeValue', $lng);
		print_r($obj);
		$this->endTimer();
	}

	protected function getAllLanguages()
	{
		$this->startTimer();
        $lng = $this->getDefaultLanguageId();
		$obj = DataCache::getInstance()->getKeyValueService()->getAllValid('LanguageValue', $lng);
		print_r($obj);
		$this->endTimer();
	}

	protected function getAllEAddressTypes()
	{
		$this->startTimer();
        $lng = $this->getDefaultLanguageId();
		$obj = DataCache::getInstance()->getKeyValueService()->getAllValid('EAddresstypeValue', $lng);
		print_r($obj);
		$this->endTimer();
	}

	protected function getAllFieldOfStudies()
	{
	    // ????
		$this->startTimer();
        $lng = $this->getDefaultLanguageId();
		$obj = DataCache::getInstance()->getKeyValueService()->getAllValid('FormOfStudiesValue', $lng);
		print_r($obj);
		$this->endTimer();
	}

	protected function getAllEAddressTags()
	{
		$this->startTimer();
        $lng = $this->getDefaultLanguageId();
		$obj = DataCache::getInstance()->getKeyValueService()->getAllValid('AddresstagValue', $lng);
		print_r($obj);
		$this->endTimer();
	}

	protected function getAllExternalSystems()
	{
		$this->startTimer();
        $lng = $this->getDefaultLanguageId();
		$obj = DataCache::getInstance()->getKeyValueService()->getAllValid('ExternalsystemValue', $lng);
		print_r($obj);
		$this->endTimer();
	}

	protected function getAllMajorFieldOfStudies()
	{
		$this->startTimer();
        $lng = $this->getDefaultLanguageId();
		$obj = DataCache::getInstance()->getKeyValueService()->getAllValid('MajorFieldOfStudy', $lng);
		print_r($obj);
		$this->endTimer();
	}

	protected function getAllOrgunitAttributes()
	{
		$this->startTimer();
        $lng = $this->getDefaultLanguageId();
		$obj = DataCache::getInstance()->getKeyValueService()->getAllValid('OrgunitAttributeValue', $lng);
		print_r($obj);
		$this->endTimer();
	}

	protected function getAllOrgUnitTypes()
	{
		$this->startTimer();
        $lng = $this->getDefaultLanguageId();
		$obj = DataCache::getInstance()->getKeyValueService()->getAllValid('OrgunittypeValue', $lng);
		print_r($obj);
		$this->endTimer();
	}

	protected function getAllPersonGroupCategories()
	{
		$this->startTimer();
        $lng = $this->getDefaultLanguageId();
		$obj = DataCache::getInstance()->getKeyValueService()->getAllValid('PersonGroupCategoryValue', $lng);
		print_r($obj);
		$this->endTimer();
	}

	protected function getAllWorkStatus()
	{
		$this->startTimer();
        $lng = $this->getDefaultLanguageId();
		$obj = DataCache::getInstance()->getKeyValueService()->getAllValid('WorkstatusValue', $lng);
		print_r($obj);
		$this->endTimer();
	}

	protected function getAllElearningPlatforms()
	{
		$this->startTimer();
        $lng = $this->getDefaultLanguageId();
		$obj = DataCache::getInstance()->getKeyValueService()->getAllValid('ElearningPlatform', $lng);
		print_r($obj);
		$this->endTimer();
	}

	/**
	 * @throws \Exception
	 */
	protected function getCurrentTerm()
	{
		$this->startTimer();
        $lng = $this->getDefaultLanguageId();
		$obj = DataCache::getInstance()->getTermService()->getCurrentTerm($lng);
		print_r($obj);
		$this->endTimer();
	}

	/**
	 * @throws \Exception
	 */
	protected function getDefaultLanguageId()
	{
		$this->startTimer();
		$lng = DataCache::getInstance()->getKeyValueService()->getDefaultLanguageId();
		var_dump($lng);
		$this->endTimer();
	}

    /**
     * @param $param
     * @throws Exception
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
     * @throws Exception
     */
    protected function getCourseOfStudyById($param)
    {
        $this->startTimer();
        $obj = DataCache::getInstance()->getCourseOfStudyService()->getCourseOfStudyById($param);
        print_r($obj);
        $this->endTimer();
    }

	/**
	 * @throws \Exception
	 */
	protected function getAllTermTypes()
	{
		$this->startTimer();
        $lng = $this->getDefaultLanguageId();
		$obj = DataCache::getInstance()->getKeyValueService()->getAllValid('TermTypeValue', $lng);
		print_r($obj);
		$this->endTimer();
	}

    /**
     * @param $param
     * @throws Exception
     */
    protected function readEAddressesForPerson($param)
    {
        // 1109
        $this->startTimer();
        $obj = DataCache::getInstance()->getAddressService()->readEAddressesForPerson($param);
        $this->printer->printPersonEAddress($obj, 1);
        $this->endTimer();
    }

    /**
     * @throws Exception
     */
    protected function readPersonRange()
    {
        $this->startTimer();
        $persons = array();
        for ($i = 0; $i < 2600; $i++) {
            $param = $i;
            $obj   = DataCache::getInstance()->getPersonService()->readPerson($param);
            if ($obj != null && $obj instanceof Person) {
                DataCache::getInstance()->appendPersonIdToCache($param);
                $persons[] = $obj;
                echo "$i\n";
            }
        }
        DataCache::getInstance()->readPersonDetailsToCache();
        echo "Details done.\n";
        DataCache::getInstance()->readAccountsForPersons();
        echo "Accounts done.\n";
        $this->printer->printMultiplePersons($persons, 1);
        $this->endTimer();
    }

    /**
     * @param $param
     * @throws Exception
     */
    protected function readPerson($param)
    {
        #$this->readPersonRange();
        $this->startTimer();
        $obj = DataCache::getInstance()->getPersonService()->readPerson($param);
        if ($obj != null && $obj instanceof Person) {
            DataCache::getInstance()->appendPersonIdToCache($param);
            DataCache::getInstance()->readPersonDetailsToCache();
            DataCache::getInstance()->readAccountsForPersons();
            $this->printer->printPerson($obj, 1);
        }
        $this->endTimer();
    }

    /**
     * @param $param
     * @throws Exception
     */
    protected function searchAccountForPerson61($param)
    {
        $this->startTimer();
        $obj = DataCache::getInstance()->getAccountService()->searchAccountForPerson61($param);
        print_r($obj);
        $this->endTimer();
    }

    /**
     * @param $id
     * @throws Exception
     */
    public function readAccount($id)
    {
        var_dump(DataCache::getInstance()->getAccountService()->searchAccountForPerson61($id));
    }

    /**
     * @param $func
     * @param $param
     * @throws Exception
     */
    public function functionMap($func, $param)
    {
        if (array_key_exists($func, $this->collection) &&
            method_exists($this, $this->collection[$func]->getFunction())
        ) {
            if (($this->collection[$func]->isDebug() && GlobalSettings::getInstance()->isDebug()) ||
                ($this->collection[$func]->isDebug() === false)) {
                $this->{$this->collection[$func]->getFunction()}($param);
            } else {
                $this->unknownCommand();
            }
        } else {
            $this->unknownCommand();
        }
    }

    /**
     * @throws Exception
     */
    protected function unknownCommand()
    {
        DataCache::getInstance()->getLog()->error(sprintf("Unknown command %s.", $_SERVER['argv'][1]));
        echo "\n";
        $this->printHelp();
    }

    public function printHelp()
    {
        echo "Usage: php cmd.php function [term] [year] [param]\n";

        foreach ($this->collection as $func) {
            $this->printHelpLine($func);
        }
        Utils::terminate(0);
    }

    /**
     * @param FunctionObject $func
     */
    protected function printHelpLine($func)
    {
        if ($func->isDebug() == true && GlobalSettings::getInstance()->isDebug()) {
            echo "\t\t " . $func->getId() . " => (Debug) " . $func->getComment() . "\n";
        } else {
            if ($func->isDebug() == false) {
                echo "\t\t " . $func->getId() . " => " . $func->getComment() . "\n";
            }
        }
    }

    /**
     * @throws ReflectionException
     */
    public function wsdlHelper()
    {
        $wsdl_files = $this->gatherServicesForWsdl();

        foreach ($wsdl_files as $wsdl) {
            $file = 'test/wsdl/' . $wsdl;
            if (file_exists($file)) {
                unlink($file);
            }
            $this->wsdlDownloader($file, Utils::ensureTrailingSlash(GlobalSettings::getInstance()->getHisServerUrl()) . $file);
        }

        $this->runUnitTests();
    }

    /**
     * @return array
     * @throws ReflectionException
     */
    protected function gatherServicesForWsdl()
    {
        $rii      = new RecursiveIteratorIterator(new RecursiveDirectoryIterator('src/Soap/SoapService/'));
        $services = array();
        foreach ($rii as $file) {
            if ($file->isFile() && $file->getExtension() === 'php') {
                $class      = str_replace(array('class.', '.php'), '', $file->getBasename());
                $reflection = new ReflectionClass('HisInOneProxy\Soap\SoapService\\' . $class);
                if (!$reflection->isAbstract() && !$reflection->isInterface() && $reflection->implementsInterface('HisInOneProxy\Soap\SoapService\SoapClientService')) {
                    /** @var $c SoapService\SoapClientService */
                    $map        = 'HisInOneProxy\Soap\SoapService\\' . $class;
                    $c          = new $map;
                    $services[] = $c->getServiceWsdl();
                }
            }
        }
        return $services;
    }

    /**
     * @param $file
     * @param $url
     * @throws Exception
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

        if ($result) {
            file_put_contents($file, $result);
            DataCache::getInstance()->getLog()->warning(sprintf('Successfully downloaded %s from %s', $file, $url));
        } else {
            if (!$result) {
                DataCache::getInstance()->getLog()->warning(sprintf('Failed to download %s from %s', $file, $url));
            }
        }
    }

    protected function runUnitTests()
    {
        $phpunit = new TestRunner;
        try {
            $test_suite = $phpunit->getTest('test/GlobalTestSuite.php');
            $config     = $this->getPhpUnitConfig();
            $phpunit->dorun($test_suite, $config);
        } catch (Exception $e) {
            print $e->getMessage() . "\n";
            die ("Unit tests failed.");
        }
    }

    /**
     * @return array
     */
    protected function getPhpUnitConfig()
    {
        if (GlobalSettings::getInstance()->isPhpunitWithCoverage()) {
            return $this->getPhpUnitConfigWithCoverage();
        } else {
            return $this->getPhpUnitConfigWithoutCoverage();
        }
    }

    /**
     * @return array
     */
    protected function getPhpUnitConfigWithCoverage()
    {
        return array(
            'configuration'                  => 'test/phpunit.xml',
            'coverageText'                   => true,
            'coverageTextShowUncoveredFiles' => true,
            'coverageTextShowOnlySummary'    => true
        );
    }

    /**
     * @return array
     */
    protected function getPhpUnitConfigWithoutCoverage()
    {
        return array('configuration' => 'test/phpunit.xml');
    }
}