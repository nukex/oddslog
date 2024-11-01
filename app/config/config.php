<?php
use Phalcon\Config\Adapter\Ini;

defined('BASE_PATH') || define('BASE_PATH', getenv('BASE_PATH') ?: realpath(dirname(__FILE__) . '/../..'));
defined('APP_PATH') || define('APP_PATH', BASE_PATH . '/app');




$fileName = BASE_PATH.'/config.ini';
$mode     =  INI_SCANNER_NORMAL;
$config   = new Ini($fileName, $mode);

return new \Phalcon\Config\Config([
    'database' => [
        'adapter'     => 'Mysql',
        'host'        => $config->get('database')->get('host'),
        'username'    => $config->get('database')->get('username'),
        'password'    => $config->get('database')->get('password'),
        'dbname'      => $config->get('database')->get('dbname'),
        'charset'     =>  $config->get('database')->get('charset'),
    ],
    'application' => [
        'appDir'         => APP_PATH . '/',
        'controllersDir' => APP_PATH . '/controllers/',
        'modelsDir'      => APP_PATH . '/models/',
        // 'migrationsDir'  => APP_PATH . '/migrations/',
        'viewsDir'       => APP_PATH . '/views/',
        // 'pluginsDir'     => APP_PATH . '/plugins/',
        'libraryDir'     => APP_PATH . '/library/',
        'cacheDir'       => BASE_PATH . '/cache/',
        'baseUri'        => '/',
    ]
]);
