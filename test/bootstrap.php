<?php

chdir(dirname(__DIR__));

if (!defined('PHPUNIT')) {
    define('PHPUNIT', true);
}

require_once __DIR__ . '/../libs/composer/vendor/autoload.php';
require_once __DIR__ . '/TestCaseExtension.php';

$unit_tests = \HisInOneProxy\Config\GlobalSettings::getInstance()->isPhpunitWithCoverage();
\HisInOneProxy\Config\GlobalSettings::getInstance()->readCustomConfig('test/php_unit_config.json');
\HisInOneProxy\Config\GlobalSettings::getInstance()->setPhpunitWithCoverage($unit_tests);

$map = new \HisInOneProxy\DataModel\HisToEcsIdMapping(\HisInOneProxy\Config\GlobalSettings::getInstance()->returnConfig());
$map->appendMapping('1', 2);
$map->appendMapping('2', 3);
$map->appendMapping('4', 5);
$map->appendMapping('232', 55);
