<?php

use Symfony\Component\Console\Helper\HelperSet;
use Doctrine\ORM\Tools\Console\ConsoleRunner;

require_once __DIR__ . '/../vendor/autoload.php';
$configFile = __DIR__ . '/../' . 'cli-config.php';
$commandsFile = __DIR__ . '/../' . 'cli-commands.php';
$helperSet = require $configFile;
$commands = require $commandsFile;

if ( ! ($helperSet instanceof HelperSet)) {
    foreach ($GLOBALS as $helperSetCandidate) {
        if ($helperSetCandidate instanceof HelperSet) {
            $helperSet = $helperSetCandidate;
            break;
        }
    }
}

\Doctrine\ORM\Tools\Console\ConsoleRunner::run($helperSet, $commands);