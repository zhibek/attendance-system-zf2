<?php
use Doctrine\ORM\Tools\Console\ConsoleRunner;

// Define path to application directory
defined('APPLICATION_PATH')
    || define('APPLICATION_PATH', realpath(dirname(__FILE__) . '/application'));

// Define application environment
defined('APPLICATION_ENV')
    || define('APPLICATION_ENV', (getenv('APPLICATION_ENV') ? getenv('APPLICATION_ENV') : 'testing'));

// Ensure library/ is on include_path
require_once 'vendor/autoload.php';

require_once 'Zend/Loader/Autoloader.php';
Zend_Loader_Autoloader::getInstance();

// Create application, bootstrap, and run
$application = new Zend_Application(
    APPLICATION_ENV,
    APPLICATION_PATH . '/configs/application.yaml'
);
$bootstrap = $application->bootstrap();

$entityManager = $bootstrap->getBootstrap()->getResource('entityManager');

return ConsoleRunner::createHelperSet($entityManager);