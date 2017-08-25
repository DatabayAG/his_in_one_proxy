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

	protected static function addFunctions()
	{
		if(count(self::$collection) == 0)
		{
			self::appendFunction('lc', 'getLectures', 'Gets all lectures and add them to queue.');
			self::appendFunction('li', 'getLectureById', 'Gets a Lecture by id. Uses id as param.');
			self::appendFunction('in', 'getInstitutions', 'Gets all institutions.');
			self::appendFunction('cc', 'getCourseCatalog', 'Gets course catalog.');
			self::appendFunction('ts', 'wsdlHelper', 'Gets wsdls needed for unittests and runs tests.');
			#self::appendFunction('sq', 'startQueue', 'Starts queue which is used to communicate with the ecs server.');
			self::appendFunction('ro', 'getRootIdOfTerm', 'Get root id of term', true);
			self::appendFunction('le', 'getCourseCatalogLeaf', 'Gets course catalog leaf by id.', true);
			self::appendFunction('gg', 'getAllParallelGroups', 'Gets all parallel group types.', true);
			self::appendFunction('gw', 'getAllWorkStatus', 'Gets all work status types.', true);
			self::appendFunction('ge', 'getAllElearningPlatforms', 'Gets all elearning platforms.', true);
			self::appendFunction('gt', 'getAllTermTypes', 'Gets all term types.', true);
			self::appendFunction('dl', 'getDefaultLanguageId', 'Gets default language id.', true);
			self::appendFunction('ct', 'getCurrentTerm', 'Gets current term.', true);
			self::appendFunction('rs', 'readStudentWithCoursesOfStudyByPersonId', 'Read student with course of study by person id', true);
			self::appendFunction('ci', 'getCourseOfStudyById', 'Get course of study by id.', true);
			self::appendFunction('rp', 'readPerson', 'Reads person by id.', true);
			self::appendFunction('ra', 'readAccount', 'Reads account by id.', true);
			self::appendFunction('sa', 'searchAccountForPerson61', 'Reads accounts by person id.', true);
			self::appendFunction('ea', 'readEAddressesForPerson', 'Reads electronic addresses by person id.', true);
		}
	}

	/**
	 * @param      $id
	 * @param      $function
	 * @param      $comment
	 * @param bool $debug
	 * @throws \Exception
	 */
	protected static function appendFunction($id, $function, $comment, $debug = false)
	{
		if(array_key_exists($id, self::$collection))
		{
			Utils::LogToShellAndExit(sprintf('Short "%s" handle already in use for "%s".', $id, self::$collection[$id]->getFunction()));
		}
		$func = new FunctionObject();
		$func->setId($id);
		$func->setFunction($function);
		$func->setComment($comment);
		$func->setDebug($debug);
		self::$collection[$func->getId()] = $func;
	}

	/**
	 * @return array
	 */
	public static function getFunctions()
	{
		if(count(self::$collection) === 0)
		{
			self::addFunctions();
		}

		return self::$collection;
	}
}