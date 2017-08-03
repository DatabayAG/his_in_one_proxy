<?php

namespace HisInOneProxy\System\Console;

class Functions
{
	/**
	 * @var array
	 */
	protected static $collection = array();

	protected static function addFunctions()
	{
		self::appendFunction('lc', 'getLectures', 'Gets all lectures and add them to queue.');
		self::appendFunction('li', 'getLectureById', 'Gets a Lecture by id. Uses id as param.');
		self::appendFunction('in', 'getInstitutions', 'Gets all institutions.');
		self::appendFunction('cc', 'getCourseCatalog', 'Gets course catalog.');
		self::appendFunction('sq', 'startQueue', 'Starts queue which is used to communicate with the ecs server.');
		self::appendFunction('ro', 'getRootIdOfTerm', 'Get root id of term', true);
		self::appendFunction('le', 'getCourseCatalogLeaf', 'Gets course catalog leaf by id.', true);
		self::appendFunction('gg', 'getAllParallelGroups', 'Gets all parallel group types.', true);
		self::appendFunction('gw', 'getAllWorkStatus', 'Gets all work status types.', true);
		self::appendFunction('ge', 'getAllElearningPlatforms', 'Gets all work status types.', true);
		self::appendFunction('gt', 'getAllTermTypes', 'Gets all term types.', true);
		self::appendFunction('rp', 'readPerson', 'Reads person by id.', true);
	}

	/**
	 * @param $id
	 * @param $function
	 * @param $comment
	 * @param $debug
	 */
	protected static function appendFunction($id, $function, $comment, $debug = false)
	{
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
		self::addFunctions();
		return self::$collection;
	}
}