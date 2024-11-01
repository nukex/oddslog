<?php
declare(strict_types=1);

function get_sec()
{
    $mtime = microtime();
    $mtime = explode(" ",$mtime);
    $mtime = $mtime[1] + $mtime[0];
    return $mtime;
}
$start_time = get_sec();


// if (! (isset($_SERVER['HTTPS']) && ($_SERVER['HTTPS'] == 'on' || 
//    $_SERVER['HTTPS'] == 1) ||  
//    isset($_SERVER['HTTP_X_FORWARDED_PROTO']) &&   
//    $_SERVER['HTTP_X_FORWARDED_PROTO'] == 'https'))
// {
//    $redirect = 'https://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
//    header('HTTP/1.1 301 Moved Permanently');
//    header('Location: ' . $redirect);
//    exit();
// }


// if ($_SERVER['REQUEST_URI'] == '/index.html') {
//     header('HTTP/1.1 301 Moved Permanently');
//     header('Location: https://oddslogs.com');
//     exit();
// }

// include  'rewrite.php';


use Phalcon\Di\FactoryDefault;

error_reporting(E_ALL);

define('BASE_PATH', dirname(__DIR__));
define('APP_PATH', BASE_PATH . '/app');

try {
    /**
     * The FactoryDefault Dependency Injector automatically registers
     * the services that provide a full stack framework.
     */
    $di = new FactoryDefault();

    /**
     * Handle routes
     */
    include APP_PATH . '/config/router.php';

    /**
     * Read services
     */
    include APP_PATH . '/config/services.php';

    /**
     * Get config service for use in inline setup below
     */
    $config = $di->getConfig();

    /**
     * Include Autoloader
     */
    include APP_PATH . '/config/loader.php';

    include_once  APP_PATH . "/library/functions.php";


    /**
     * Handle the request
     */
    $application = new \Phalcon\Mvc\Application($di);

    echo $application->handle($_SERVER['REQUEST_URI'])->getContent();

    printf("<!-- %f -->", (get_sec() - $start_time) );
    
} catch (\Exception $e) {
    header("HTTP/1.0 404 Not Found");

    echo '<!--' . $e->getMessage() . '<br>';
    echo '<pre>' . $e->getTraceAsString() . '</pre>-->';


}