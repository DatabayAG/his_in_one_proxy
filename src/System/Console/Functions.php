<?php

namespace HisInOneProxy\System\Console;

use HisInOneProxy\System\Utils;

/**
 * Class Functions
 * @package HisInOneProxy\System\Console
 */
class Functions
{
    /**
     * @var array
     */
    protected static $collection = array();

    /**
     * @return array
     */
    public static function getFunctions()
    {
        if (count(self::$collection) === 0) {
            self::addFunctions();
        }

        return self::$collection;
    }

    protected static function addFunctions()
    {
        if (count(self::$collection) == 0) {
            self::appendFunction('lc', 'getLectures', 'Gets all lectures and add them to queue.');
            self::appendFunction('li', 'getLectureById', 'Gets a Lecture by UnitId. Uses id as param.');
            self::appendFunction('fo', 'getLectureByIdForced', 'Gets a Lecture by UnitId and force push this course. Uses id as param.');
            self::appendFunction('in', 'getInstitutions', 'Gets all institutions.');
            self::appendFunction('cc', 'getCourseCatalog', 'Gets course catalog.');
            self::appendFunction('ge', 'getAllElearningPlatforms', 'Gets all elearning platforms. (XML|JSON)');
            self::appendFunction('gb', 'getAllBlockeds', 'Gets all blocked id states.');
            self::appendFunction('ts', 'wsdlHelper', 'Gets wsdls needed for unittests and runs tests.');
            self::appendFunction('sq', 'startQueue', 'Starts queue which is used to communicate with the ecs server.');
            self::appendFunction('se', 'startHisListener', 'Starts his listener which listens to the system events from his server.');
            self::appendFunction('cm', 'getAllCourseMappingTypes', 'Gets all course mapping types. (XML|JSON)');
            self::appendFunction('tr', 'truncateServiceQueue', 'Warning: Truncates the service queue table, please be careful using this command!');
            self::appendFunction('ro', 'getRootIdOfTerm', 'Get root id of term. (XML|JSON)', true);
            self::appendFunction('le', 'getCourseCatalogLeaf', 'Gets course catalog leaf by id. (XML|JSON)', true);
            self::appendFunction('gg', 'getAllGenders', 'Gets all gender types. (XML|JSON)', true);
            self::appendFunction('gp', 'getAllParallelGroups', 'Gets all parallel group types. (XML|JSON)', true);
            self::appendFunction('gw', 'getAllWorkStatus', 'Gets all work status types. (XML|JSON)', true);
            self::appendFunction('gt', 'getAllTermTypes', 'Gets all term types. (XML|JSON)', true);
            self::appendFunction('gl', 'getAllLanguages', 'Gets all language types. (XML|JSON)', true);
            self::appendFunction('ga', 'getAllEAddressTags', 'Gets all eaddress tags. (XML|JSON)', true);
            self::appendFunction('gy', 'getAllEAddressTypes', 'Gets all eaddress types. (XML|JSON)', true);
            self::appendFunction('gf', 'getAllFieldOfStudies', 'Gets all field of study types. (XML|JSON)', true);
            self::appendFunction('gm', 'getAllMajorFieldOfStudies', 'Gets all mayor field of studies types. (XML|JSON)', true);
            self::appendFunction('go', 'getAllOrgunitAttributes', 'Gets all org unit attributes types. (XML|JSON)', true);
            self::appendFunction('gs', 'getAllOrgUnitTypes', 'Gets all org unit types. (XML|JSON)', true);
            self::appendFunction('gc', 'getAllPersonGroupCategories', 'Gets all person group types. (XML|JSON)', true);
            self::appendFunction('dl', 'getDefaultLanguageId', 'Gets default language id. (XML|JSON)', true);
            self::appendFunction('ct', 'getCurrentTerm', 'Gets current term. (XML|JSON)', true);
            self::appendFunction('rs', 'readStudentWithCoursesOfStudyByPersonId', 'Read student with course of study by person id. (XML|JSON)', true);
            self::appendFunction('ci', 'getCourseOfStudyById', 'Get course of study by id. (XML|JSON)', true);
            self::appendFunction('rp', 'readPerson', 'Reads person by id. (XML|JSON)', true);
            self::appendFunction('ra', 'readAccount', 'Reads account by id. (XML|JSON)', true);
            self::appendFunction('sa', 'searchAccountForPerson61', 'Reads accounts by person id. (XML|JSON)', true);
            self::appendFunction('ea', 'readEAddressesForPerson', 'Reads electronic addresses by person id. (XML|JSON)', true);
            self::appendFunction('et', 'getAllElementtypes', 'Reads element types. (XML|JSON)', true);
            self::appendFunction('cs', 'getAllEventtypes', 'Reads all event types. (XML|JSON)', true);
            self::appendFunction('lf', 'addLinkForCourse', 'Adds link for a course. Params: UnitId Description Link', true);
            self::appendFunction('ls', 'runHISLinkCron', 'Runs the cron script to send the links from ILIAS to HISinOne', true);
        }
    }

    /**
     * @param      $id
     * @param      $function
     * @param      $comment
     * @param bool $debug
     */
    protected static function appendFunction($id, $function, $comment, $debug = false)
    {
        if (array_key_exists($id, self::$collection)) {
            Utils::LogToShellAndExit(sprintf('Short "%s" handle already in use for "%s".', $id, self::$collection[$id]->getFunction()));
        }
        $func = new FunctionObject();
        $func->setId($id);
        $func->setFunction($function);
        $func->setComment($comment);
        $func->setDebug($debug);
        self::$collection[$func->getId()] = $func;
    }
}
