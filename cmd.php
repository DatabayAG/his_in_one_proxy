<?php
namespace HisInOneProxy\Command;
use HisInOneProxy\System\ConsoleHandler;

require_once './libs/composer/vendor/autoload.php';
function startHandler()
{
	if($_SERVER['argc'] < 2)
	{
		$handler = new ConsoleHandler(null, null);
		$handler->printHelp();
	}
	else if($_SERVER['argc'] >= 2)
	{
		$param	= null;
		$func	= null;
		$term	= null;
		$year	= null;
        $output_format = 'plain';

		if(array_key_exists(1, $_SERVER['argv']))
		{
			$func = $_SERVER['argv'][1];
		}
		if(array_key_exists(2, $_SERVER['argv']))
		{
			$term = $_SERVER['argv'][2];
		}
		if(array_key_exists(3, $_SERVER['argv']))
		{
			$year = $_SERVER['argv'][3];
		}
        if(array_key_exists(4, $_SERVER['argv']))
        {
            $output_format = $_SERVER['argv'][4];
        }

        array_splice($_SERVER['argv'], 0, 5);
        $param = $_SERVER['argv'];
		$handler	= new ConsoleHandler($term, $year, $output_format);
		$handler->functionMap($func, $param);
	}
}

if(!defined('PHPUNIT'))
{
	startHandler();
}
