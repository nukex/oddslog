<?php
declare(strict_types=1);

use Phalcon\Escaper;
use Phalcon\Flash\Direct as Flash;
use Phalcon\Mvc\Model\Metadata\Memory as MetaDataAdapter;
use Phalcon\Mvc\View;
use Phalcon\Mvc\View\Engine\Php as PhpEngine;
use Phalcon\Mvc\View\Engine\Volt as VoltEngine;
use Phalcon\Session\Adapter\Stream as SessionAdapter;
use Phalcon\Session\Manager as SessionManager;
use Phalcon\Mvc\Url as UrlResolver;
use Phalcon\Html\Breadcrumbs;
use Phalcon\Http\Response\Cookies;
use Phalcon\Cache\Cache;
use Phalcon\Cache\AdapterFactory;
use Phalcon\Storage\SerializerFactory;


$di->setShared('config', function () {
    return include APP_PATH . "/config/config.php";
});


$di->setShared('url', function () {
    $config = $this->getConfig();

    $url = new UrlResolver();
    $url->setBaseUri($config->application->baseUri);

    return $url;
});



$di->setShared('view', function () {
    $config = $this->getConfig();

    $view = new View();
    $view->setDI($this);
    $view->setViewsDir($config->application->viewsDir);

    $view->registerEngines([
        '.volt' => function ($view) {
            $config = $this->getConfig();

            $volt = new VoltEngine($view, $this);

            $volt->setOptions([
                'path' => $config->application->cacheDir,
                'separator' => '_'
            ]);

            $compiler = $volt->getCompiler();
            $compiler->addFilter('slug', 'Slug');
            $compiler->addFunction('statPercent', 'statPercent');
            $compiler->addFunction('h2hStatus', 'h2hStatus');
            $compiler->addFunction('h2hWinCalc', 'h2hWinCalc');
            $compiler->addFunction('h2hPPGCalc', 'h2hPPGCalc');
            $compiler->addFunction('h2hScored',  'h2hScored');
            $compiler->addFunction('h2hBTTS',  'h2hBTTS');

            return $volt;
        },
        '.phtml' => PhpEngine::class

    ]);

    return $view;
});

$di->setShared(
    'modelsCache',
    function () {
        $serializerFactory = new SerializerFactory();
        $adapterFactory    = new AdapterFactory($serializerFactory);

        $options = [
            'defaultSerializer' => 'Php',
            'lifetime'          => 7200
        ];

        $adapter = $adapterFactory->newInstance('apcu', $options);

        return new Cache($adapter);
    }
);


$di->setShared('db', function () {
    $config = $this->getConfig();

    $class = 'Phalcon\Db\Adapter\Pdo\\' . $config->database->adapter;
    $params = [
        'host'     => $config->database->host,
        'username' => $config->database->username,
        'password' => $config->database->password,
        'dbname'   => $config->database->dbname,
        'charset'  => $config->database->charset
    ];

    if ($config->database->adapter == 'Postgresql') {
        unset($params['charset']);
    }

    return new $class($params);
});



$di->setShared('modelsMetadata', function () {
    return new MetaDataAdapter();
});


$di->set('flash', function () {
    $escaper = new Escaper();
    $flash = new Flash($escaper);
    $flash->setImplicitFlush(false);
    $flash->setCssClasses([
        'error'   => 'alert alert-danger',
        'success' => 'alert alert-success',
        'notice'  => 'alert alert-info',
        'warning' => 'alert alert-warning'
    ]);

    return $flash;
});


$di->setShared('session', function () {
    $session = new SessionManager();
    $files = new SessionAdapter([
        'savePath' => ( $_SERVER['REMOTE_ADDR'] == "127.0.0.1" ? sys_get_temp_dir() :  '/home/webuser/tmp') // ,
    ]);
    $session->setAdapter($files);
    $session->start();

    return $session;
});

$di->setShared('breadcrumbs', function () {
    return new Breadcrumbs;
});


$di->setShared('cookies', function () {
    $cookies = new Cookies();

    $cookies->useEncryption(false);

    return $cookies;
});