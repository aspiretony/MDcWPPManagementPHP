<?php
declare(strict_types=1);

use Cake\Cache\Cache;
use Cake\Chronos\Chronos;
use Cake\Core\Configure;
use Cake\Log\Log;
use Cake\Utility\Security;

/**
 * This common bootstrap script ensures that autoloader and constants are well configured
 * It also set up a few more configuration
 */

// Autoloader
$findRoot = function ($root) {
    do {
        $lastRoot = $root;
        $root = dirname($root);
        if (is_dir($root . '/vendor/cakephp/cakephp')) {
            return $root;
        }
    } while ($root !== $lastRoot);

    throw new Exception('Cannot find the root of the application, unable to run tests');
};

$root = $findRoot(__FILE__);
unset($findRoot);

if (is_file('vendor/autoload.php')) {
    include_once 'vendor/autoload.php';
} else {
    include_once dirname(__DIR__) . '/vendor/autoload.php';
}

if (!defined('DS')) {
    define('DS', DIRECTORY_SEPARATOR);
}

define('ROOT', dirname(dirname(__DIR__)));
define('TMP', sys_get_temp_dir() . DS);
define('FIXTURES', ROOT . DS . 'tests' . DS . 'Fixture' . DS);
define('LOGS', ROOT . DS . 'logs' . DS);
define('CACHE', TMP . 'cache' . DS);
define('SESSIONS', TMP . 'sessions' . DS);
define('CAKE_CORE_INCLUDE_PATH', ROOT . DS . 'vendor' . DS . 'cakephp' . DS . 'cakephp');
define('CORE_PATH', CAKE_CORE_INCLUDE_PATH . DS);
define('CAKE', CORE_PATH . 'src' . DS);
define('CORE_TESTS', CORE_PATH . 'tests' . DS);
define('CORE_TEST_CASES', CORE_TESTS . 'TestCase');
define('TEST_APP', ROOT . DS . 'tests' . DS);
define('APP', TEST_APP . 'TestApp' . DS);
define('WWW_ROOT', TEST_APP . 'webroot' . DS);
define('CONFIG', TEST_APP . 'config' . DS);

// phpcs:disable
@mkdir(LOGS);
@mkdir(SESSIONS);
@mkdir(CACHE);
@mkdir(CACHE . 'views');
@mkdir(CACHE . 'models');
// phpcs:enable

require_once CORE_PATH . 'config' . DS . 'bootstrap.php';

date_default_timezone_set('UTC');
mb_internal_encoding('UTF-8');

Configure::write('debug', true);

// Cache configuration
Cache::setConfig(
    [
    '_cake_core_' => [
        'engine' => 'File',
        'prefix' => 'cake_core_',
        'serialize' => true,
    ],
    '_cake_model_' => [
        'engine' => 'File',
        'prefix' => 'cake_model_',
        'serialize' => true,
    ],
    ]
);

// Logger configuration
Log::setConfig(
    [
      'debug' => [
          'engine' => 'Cake\Log\Engine\FileLog',
          'levels' => ['notice', 'info', 'debug'],
          'file' => 'debug',
          'path' => LOGS,
      ],
      'error' => [
          'engine' => 'Cake\Log\Engine\FileLog',
          'levels' => ['warning', 'error', 'critical', 'alert', 'emergency'],
          'file' => 'error',
          'path' => LOGS,
      ],
      'queries' => [
          'className' => 'Console',
          'stream' => 'php://stderr',
          'scopes' => ['queriesLog'],
      ],
    ]
);

// Basic for tests
Chronos::setTestNow(Chronos::now());
Security::setSalt('a-long-but-not-random-value');
