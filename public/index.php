<?php

// Define path to application directory
defined('APPLICATION_PATH')
    || define('APPLICATION_PATH', realpath(dirname(__FILE__) . DIRECTORY_SEPARATOR. '..'. DIRECTORY_SEPARATOR. 'application'));

// Define application environment
defined('APPLICATION_ENV')
    || define('APPLICATION_ENV', (getenv('APPLICATION_ENV') ? getenv('APPLICATION_ENV') : 'production'));

defined('CONFIGS_PATH')
    || define('CONFIGS_PATH', APPLICATION_PATH. DIRECTORY_SEPARATOR. 'configs');

defined('DATA_PATH')
    || define('DATA_PATH', APPLICATION_PATH. DIRECTORY_SEPARATOR. '..'. DIRECTORY_SEPARATOR. 'data');

defined('CACHE_PATH')
    || define('CACHE_PATH', DATA_PATH. DIRECTORY_SEPARATOR. 'cache');


defined('UPLOADS_PATH')
    || define('UPLOADS_PATH', DATA_PATH. DIRECTORY_SEPARATOR. 'uploads');

defined('LOGS_PATH')
    || define('LOGS_PATH', DATA_PATH. DIRECTORY_SEPARATOR. 'logs');

defined('LOG_FILENAME')
    || define('LOG_FILENAME', 'application.'. date('Y'). '-'. date('W'). '.log');
	
defined('UMASK')
    || define('UMASK', "0022");
	
// Ensure library/ is on include_path
set_include_path(implode(PATH_SEPARATOR, array(
    realpath(APPLICATION_PATH . '/../library'),
    get_include_path(),
)));

// control rights and the existence of files
if (!file_exists('.htaccess')) {
    die('Please copy ".'. DIRECTORY_SEPARATOR. '.htaccess.sample" to ".'. DIRECTORY_SEPARATOR. '.htaccess"');
}

if (!file_exists(APPLICATION_PATH . DIRECTORY_SEPARATOR. 'configs'. DIRECTORY_SEPARATOR. 'application.ini')) {
    die('Please copy "'. APPLICATION_PATH. DIRECTORY_SEPARATOR. 'configs'. DIRECTORY_SEPARATOR. 'application.ini.sample" to "'. APPLICATION_PATH. DIRECTORY_SEPARATOR. 'configs'. DIRECTORY_SEPARATOR. 'application.ini"');
}

if (!is_writable(LOGS_PATH)) {
    die('Folder "'. LOGS_PATH. '" is not writable, please set CHMOD 777.');
}

if (!is_writable(CACHE_PATH)) {
    die('Folder "'. CACHE_PATH. '" is not writable, please set CHMOD 777.');
}

if (!is_writable(UPLOADS_PATH)) {
    die('Folder "'. UPLOADS_PATH. '" is not writable, please set CHMOD 777.');
}

/** Zend_Application */
require_once 'Zend/Application.php';

// Create application, bootstrap, and run
$application = new Zend_Application(
    APPLICATION_ENV,
    APPLICATION_PATH . '/configs/application.ini'
);
$application->bootstrap()
            ->run();