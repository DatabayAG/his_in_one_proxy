<?php

namespace HisInOneProxy\System;

class Utils
{
	/**
	 * @param $path
	 * @return string
	 */
	public static function ensureTrailingSlash($path)
	{
		$path = self::ensureNoTrailingSlash($path);
		return $path . '/';
	}

	/**
	 * @param $path
	 * @return string
	 */
	public static function ensureNoTrailingSlash($path)
	{
		return rtrim($path, '/');
	}

	/**
	 * @param $msg
	 */
	public static function LogToShellAndExit($msg)
	{
		echo $msg . " Exiting!\n";
		self::terminate();
	}

	/**
	 * @param int $code
	 */
	public static function terminate($code = 0)
	{
		exit($code);
	}
}