#!/bin/bash
php7.0 -dxdebug.coverage_enable=1  ./libs/phpunit-6.1.3.phar --coverage-html ./coverage --configuration ./test/phpunit.xml GlobalTestSuite ./test/GlobalTestSuite.php
#php7.0 -dxdebug.coverage_enable=1  ./libs/phpunit-6.1.3.phar --configuration ./test/phpunit.xml GlobalTestSuite ./test/GlobalTestSuite.php
