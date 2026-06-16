<?php

namespace HisInOneProxy\System;

use Exception;
use HisInOneProxy\Config\GlobalSettings;
use HisInOneProxy\DataModel\Person;
use HisInOneProxy\Log\Log;
use HisInOneProxy\Queue\QueueDatabase;
use HisInOneProxy\Queue\QueueProcess;
use HisInOneProxy\Soap\CourseCatalogService;
use HisInOneProxy\Soap\CourseInterfaceService;
use HisInOneProxy\Soap\Interactions\Conductor;
use HisInOneProxy\Soap\Interactions\DataCache;
use HisInOneProxy\Soap\Interactions\DataPrinter;
use HisInOneProxy\Soap\Interactions\HisHttpServer;
use HisInOneProxy\Soap\Interactions\HisLinksCron;
use HisInOneProxy\Soap\SoapService;
use HisInOneProxy\Soap\SoapServiceRouter;
use HisInOneProxy\System\Console\FunctionObject;
use HisInOneProxy\System\Console\Functions;
use JsonException;
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
    const PLAIN_TEXT = 'plain';
    const JSON = 'json';

    const STATUS_FOUND = 200;
    const STATUS_NOT_FOUND = 404;
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
    protected array $collection = [];

    /**
     * @var DataPrinter
     */
    protected $printer;
    protected string $output_mode = self::PLAIN_TEXT;
    protected array $head = [];

    /**
     * ConsoleHandler constructor.
     * @param null $term
     * @param null $year
     * @throws Exception
     */
    public function __construct($term = null, $year = null, $output_type = self::PLAIN_TEXT)
    {
        $this->startTimer();
        $log           = new Log('debug');
        $streamHandler = new StreamHandler('php://stdout', 'debug');
        $output        = "%message%\n";
        $formatter     = new LineFormatter($output);
        $this->output_mode = $output_type;
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
        $timer = round($end_time - $this->start_time, 4);
        $call_counter = GlobalSettings::getInstance()->getCallsCounter();
        if($this->output_mode === self::PLAIN_TEXT) {
            DataCache::getInstance()->getLog()->info(sprintf($what . ' took %s seconds for %s soap calls.',
                    $timer,
                    $call_counter
                )
            );
        } else if($this->output_mode === self::JSON) {
            $this->head = [
                'status' => '',
                'message' => '',
                'duration_seconds' => $timer,
                'soap_calls' => $call_counter,
            ];
        }
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
    protected function getLectureById(array $id)
    {
        if(isset($id[0])) {
            $unit_id = $id[0];
            $this->startTimer();
            self::$conductor->getLectureByUnitIdForTerm($unit_id);
            $this->endTimer();
        }
    }

    protected function getLectureByIdForced(array $id)
    {
        if(isset($id[0])) {
            $unit_id = $id[0];
            $this->startTimer();
            self::$conductor->getLectureByUnitIdForTermAndForcePush($unit_id);
            $this->endTimer();
        }
    }

    protected function getInstitutions()
    {
        $this->startTimer();
        self::$conductor->getInstitutionsAndOrgUnits();
        $this->endTimer();
    }

    protected function getAllCourseMappingTypes()
    {
        $this->startTimer();
        $lng = $this->getDefaultLanguageId(false);
        $obj = DataCache::getInstance()->getKeyValueService()->getAllValid("ElearningCourseMappingType", $lng);
        $this->printObject($obj);
        $this->endTimer();
    }
    protected function getCourseCatalog()
    {
        $this->startTimer();
        self::$conductor->getCourseCatalog();
        $this->endTimer();
    }

    protected function truncateServiceQueue()
    {
        $this->startTimer();
        $db = new QueueDatabase();
        $db->truncateServiceQueue();
        $this->endTimer();
    }

	protected function getAllBlockeds()
	{
		$this->startTimer();
        $lng = $this->getDefaultLanguageId();
		DataCache::getInstance()->getKeyValueService()->getAllValid("blocked", $lng);
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
        if ($this->output_mode === self::PLAIN_TEXT) {
            if ($id != '') {
                $msg = sprintf('Found %s as root id of term for term id (%s) and year (%s).', $id, $this->term_id, $this->year);
                DataCache::getInstance()->getLog()->info($msg);
            } else {
                $msg = sprintf('Found nothing as root id of term for term id (%s) and year (%s).', $this->term_id, $this->year);
                DataCache::getInstance()->getLog()->info($msg);
            }
        } else {
            if ($id != '') {
                $msg = sprintf('Found %s as root id of term for term id (%s) and year (%s).', $id, $this->term_id, $this->year);
                $this->head['message'] = $msg;
            } else {
                $msg = sprintf('Found nothing as root id of term for term id (%s) and year (%s).', $this->term_id, $this->year);
                $this->head['message'] = $msg;
            }
            $this->printObject($id);
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
        $this->printObject($leaf);
        $this->endTimer();
    }

	protected function getAllParallelGroups()
	{
		$this->startTimer();
        $lng = $this->getDefaultLanguageId(false);
		$obj = DataCache::getInstance()->getKeyValueService()->getAllValid('ParallelgroupValue', $lng);
		$this->printObject($obj);
		$this->endTimer();
	}

	protected function getAllGenders()
	{
		$this->startTimer();
        $lng = $this->getDefaultLanguageId(false);
		$obj = DataCache::getInstance()->getKeyValueService()->getAllValid('GenderValue', $lng);
		$this->printObject($obj);
		$this->endTimer();
	}

	protected function getAllElementtypes()
	{
		$this->startTimer();
        $lng = $this->getDefaultLanguageId(false);
		$obj = DataCache::getInstance()->getKeyValueService()->getAllValid('ElementtypeValue', $lng);
		$this->printObject($obj);
		$this->endTimer();
	}

	protected function getAllEventtypes()
	{
		$this->startTimer();
        $lng = $this->getDefaultLanguageId(false);
		$obj = DataCache::getInstance()->getKeyValueService()->getAllValid('EventtypeValue', $lng);
		$this->printObject($obj);
		$this->endTimer();
	}

	protected function getAllLanguages()
	{
		$this->startTimer();
        $lng = $this->getDefaultLanguageId(false);
		$obj = DataCache::getInstance()->getKeyValueService()->getAllValid('LanguageValue', $lng);
		$this->printObject($obj);
		$this->endTimer();
	}

	protected function getAllEAddressTypes()
	{
		$this->startTimer();
        $lng = $this->getDefaultLanguageId(false);
		$obj = DataCache::getInstance()->getKeyValueService()->getAllValid('EAddresstypeValue', $lng);
		$this->printObject($obj);
		$this->endTimer();
	}

	protected function getAllFieldOfStudies()
	{
	    // ????
		$this->startTimer();
        $lng = $this->getDefaultLanguageId(false);
		$obj = DataCache::getInstance()->getKeyValueService()->getAllValid('FormOfStudiesValue', $lng);
		$this->printObject($obj);
		$this->endTimer();
	}

	protected function getAllEAddressTags()
	{
		$this->startTimer();
        $lng = $this->getDefaultLanguageId(false);
		$obj = DataCache::getInstance()->getKeyValueService()->getAllValid('AddresstagValue', $lng);
		$this->printObject($obj);
		$this->endTimer();
	}

	protected function getAllExternalSystems()
	{
		$this->startTimer();
        $lng = $this->getDefaultLanguageId(false);
		$obj = DataCache::getInstance()->getKeyValueService()->getAllValid('ExternalsystemValue', $lng);
		$this->printObject($obj);
		$this->endTimer();
	}

	protected function getAllMajorFieldOfStudies()
	{
		$this->startTimer();
        $lng = $this->getDefaultLanguageId(false);
		$obj = DataCache::getInstance()->getKeyValueService()->getAllValid('MajorFieldOfStudy', $lng);
		$this->printObject($obj);
		$this->endTimer();
	}

	protected function getAllOrgunitAttributes()
	{
		$this->startTimer();
        $lng = $this->getDefaultLanguageId(false);
		$obj = DataCache::getInstance()->getKeyValueService()->getAllValid('OrgunitAttributeValue', $lng);
		$this->printObject($obj);
		$this->endTimer();
	}

	protected function getAllOrgUnitTypes()
	{
		$this->startTimer();
        $lng = $this->getDefaultLanguageId(false);
		$obj = DataCache::getInstance()->getKeyValueService()->getAllValid('OrgunittypeValue', $lng);
		$this->printObject($obj);
		$this->endTimer();
	}

	protected function getAllPersonGroupCategories()
	{
		$this->startTimer();
        $lng = $this->getDefaultLanguageId(false);
		$obj = DataCache::getInstance()->getKeyValueService()->getAllValid('PersonGroupCategoryValue', $lng);
		$this->printObject($obj);
		$this->endTimer();
	}

	protected function getAllWorkStatus()
	{
		$this->startTimer();
        $lng = $this->getDefaultLanguageId(false);
		$obj = DataCache::getInstance()->getKeyValueService()->getAllValid('WorkstatusValue', $lng);
		$this->printObject($obj);
		$this->endTimer();
	}

	protected function getAllElearningPlatforms()
	{
		$this->startTimer();
        $lng = $this->getDefaultLanguageId(false);
		$obj = DataCache::getInstance()->getKeyValueService()->getAllValid('ElearningPlatform', $lng);
		$this->printObject($obj);
		$this->endTimer();
	}

	/**
	 * @throws \Exception
	 */
	protected function getCurrentTerm()
	{
		$this->startTimer();
        $lng = $this->getDefaultLanguageId(false);
		$obj = DataCache::getInstance()->getTermService()->getCurrentTerm($lng);
		$this->printObject($obj);
		$this->endTimer();
	}

    /**
     * @return string|null
     * @throws Exception
     */
	protected function getDefaultLanguageId($output = true)
	{
		$this->startTimer();
		$lng = DataCache::getInstance()->getKeyValueService()->getDefaultLanguageId();
        if($output) {
            if($this->output_mode === self::PLAIN_TEXT) {
                var_dump($lng);
            } else if($this->output_mode === self::JSON) {
                $this->printObject($lng);
            }
        }
		$this->endTimer();
        return $lng;
	}

    /**
     * @param $param
     * @throws Exception
     */
    protected function readStudentWithCoursesOfStudyByPersonId($param)
    {
        $this->startTimer();
        $obj = DataCache::getInstance()->getStudentService()->readStudentWithCoursesOfStudyByPersonId($param);
        $this->printObject($obj);
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
        $this->printObject($obj);
        $this->endTimer();
    }

	/**
	 * @throws \Exception
	 */
	protected function getAllTermTypes()
	{
		$this->startTimer();
        $lng = $this->getDefaultLanguageId(false);
		$obj = DataCache::getInstance()->getKeyValueService()->getAllValid('TermTypeValue', $lng);
		$this->printObject($obj);
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
        $obj = DataCache::getInstance()->getPersonAddressService()->readEAddresses($param);
        if ($this->output_mode === self::PLAIN_TEXT) {
            $this->printer->printPersonEAddress($obj, 1);
        } else {
            $this->printObject($obj);
        }
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
        if ($this->output_mode === self::PLAIN_TEXT) {
            $this->printer->printMultiplePersons($persons, 1);
        } else {
            $this->printObject($persons);
        }
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
        if(is_array($param) && sizeof($param) === 1) {
            $param = $param[0];
        }
        $obj = DataCache::getInstance()->getPersonService()->readPerson($param);
        if ($obj != null && $obj instanceof Person) {
            DataCache::getInstance()->appendPersonIdToCache($param);
            DataCache::getInstance()->readPersonDetailsToCache();
            DataCache::getInstance()->readAccountsForPersons();
            if ($this->output_mode === self::PLAIN_TEXT) {
                $this->printer->printPerson($obj, 1);
            } else {
                $this->printObject($obj);
            }
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
        $this->printObject($obj);
        $this->endTimer();
    }

    /**
     * @param $param
     * @throws Exception
     */
    protected function addLinkForCourse($param)
    {
        if(is_array($param) && sizeof($param) >= 3) {
            $unit_id = $param[0];
            $desc = $param[1];
            $link = $param[2];
            $term_type = GlobalSettings::getInstance()->getActualTermId();
            $term_year = GlobalSettings::getInstance()->getActualTermYear();

            $this->startTimer();
            $db = new QueueDatabase();
            $db->insertLink($unit_id, $term_type, $term_year, $desc,  $link, '', null);
            $this->endTimer();
        } else {
            echo "Please enter all needed params for " . __FUNCTION__ ."\n";
        }
    }    /**
     * @param $param
     * @throws Exception
     */
    protected function runHISLinkCron()
    {

            $this->startTimer();
            $cron = new HisLinksCron();
            $this->endTimer();
    }

    /**
     * @param $id
     * @throws Exception
     */
    public function readAccount($param)
    {
        $this->startTimer();
        if(isset($param[0])) {
            $param = $param[0];
        }
        $obj = DataCache::getInstance()->getAccountService()->searchAccountForPerson61($param);
        $this->printObject($obj);
        $this->endTimer();
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
        echo "Usage: php cmd.php function [term] [year] [param] [output_mode]\n";
        echo "Example for JSON output: php cmd.php function [term|null] [year|null] json\n\n";

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

    /**
     * @throws JsonException
     */
    private function printObject($obj): void
    {
        if($this->output_mode === self::PLAIN_TEXT) {
            if (is_object($obj) && method_exists($obj, 'removeEmptyJsonHeader')) {
                $obj->removeEmptyJsonHeader();
            }
            if (is_array($obj)) {
                foreach ($obj as $item) {
                    if (is_object($item) && method_exists($item, 'removeEmptyJsonHeader')) {
                        $item->removeEmptyJsonHeader();
                    }
                }
            }
            print_r($obj);
        } else if($this->output_mode === self::JSON) {
            if(is_object($obj) && method_exists($obj, 'addHeadData')) {
                $this->head['status'] = self::STATUS_FOUND;
                $obj->addHeadData($this->head);
            } else if(is_array($obj)) {
                if(count($obj) > 0) {
                    $this->head['status'] = self::STATUS_FOUND;
                } else {
                    $this->head['status'] = self::STATUS_NOT_FOUND;
                }
                $obj['json_header'] = $this->head;
            } else if(! is_null($obj)) {
                $this->head['status'] = self::STATUS_FOUND;
                $this->printHead();
                $this->getJsonEncodedString($obj);
                return;
            } else {
                $this->head['status'] = self::STATUS_NOT_FOUND;
                $this->printHead();
                $this->getJsonEncodedString($obj);
                return;
            }

            $this->getJsonEncodedString($obj);
        }
    }

    /**
     * @throws JsonException
     */
    private function printHead(): void
    {
            $this->getJsonEncodedString($this->head);
    }

    /**
     * @param $obj
     * @return void
     * @throws JsonException
     */
    protected function getJsonEncodedString($obj): void
    {
        echo json_encode($obj, JSON_THROW_ON_ERROR | JSON_PRETTY_PRINT) . PHP_EOL;
    }
}
