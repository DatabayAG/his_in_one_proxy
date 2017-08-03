<?php

namespace HisInOneProxy\Log;

class LogLevel
{
	const DEBUG = 100;
	const INFO = 200;
	const NOTICE = 250;
	const WARNING = 300;
	const ERROR = 400;
	const CRITICAL = 500;
	const ALERT = 550;
	const EMERGENCY = 600;
	const OFF = 1000;

	/**
	 * @return array
	 */
	public static function getLevels()
	{
		return array(
			self::DEBUG,
			self::INFO,
			self::NOTICE,
			self::WARNING,
			self::ERROR,
			self::CRITICAL,
			self::ALERT,
			self::EMERGENCY,
			self::OFF
		);
	}
}
