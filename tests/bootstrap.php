<?php

// Define path to application directory
defined('APPLICATION_PATH')
    || define('APPLICATION_PATH', realpath(dirname(__FILE__) . '/../application'));

// Define application environment
defined('APPLICATION_ENV')
    || define('APPLICATION_ENV', (getenv('APPLICATION_ENV') ? getenv('APPLICATION_ENV') : 'testing'));

defined('DATA_PATH')
    || define('DATA_PATH', APPLICATION_PATH. DIRECTORY_SEPARATOR. '..'. DIRECTORY_SEPARATOR. 'data');

defined('CACHE_PATH')
    || define('CACHE_PATH', DATA_PATH. DIRECTORY_SEPARATOR. 'cache');

defined('LOGS_PATH')
    || define('LOGS_PATH', DATA_PATH. DIRECTORY_SEPARATOR. 'logs');

defined('LOG_FILENAME')
    || define('LOG_FILENAME', 'application.'. date('Y'). '-'. date('W'). '.log');

// Ensure library/ is on include_path
set_include_path(implode(PATH_SEPARATOR, array(
    realpath(APPLICATION_PATH . '/../library'),
    get_include_path(),
)));

require_once 'Zend/Application.php';
require_once 'ModelTestCase.php';

// Create application, bootstrap, and run
$application = new Zend_Application(
   APPLICATION_ENV,
   APPLICATION_PATH . '/configs/application.ini'
);

clearstatcache();
