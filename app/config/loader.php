<?php

$loader = new \Phalcon\Autoload\Loader();

/**
 * We're a registering a set of directories taken from the configuration file
 */

/* $loader->registerFiles(
    [
        'functions.php',
        'arrayFunctions.php',
    ]
);
 */

$loader->setDirectories(
    [
        $config->application->controllersDir,
        $config->application->modelsDir,
        $config->application->libraryDir,
    ]
)->register();
