<?

if (preg_match('/(Tablet PC 2\.0|\.NET CLR 3|ahrefs)/i', $_SERVER['HTTP_USER_AGENT'])) {
    header('HTTP/1.0 403 Forbidden');
    die('error 403');
}

// if ($_SERVER['HTTP_REFERER'] == 'https://www.google.com/' ) {
//     header('HTTP/1.0 403 Forbidden');
//     die('Forbidden');
// }

if  ( isset($_SERVER['HTTP_REFERER']) && $_SERVER['HTTP_REFERER'] == 'https://www.google.com/' ) {


    $data_client = 
    "--------------------

    {$_SERVER['REMOTE_ADDR']}
    {$_SERVER['HTTP_SEC_CH_UA']}
    {$_SERVER['HTTP_ACCEPT_LANGUAGE']}
    {$_SERVER['HTTP_SEC_CH_UA_PLATFORM']}
    {$_SERVER['HTTP_COOKIE']} \n\n";
    


    if ($_SERVER['HTTP_ACCEPT_LANGUAGE'] == 'ru-RU,ru') {
        $data_client .= "===BAN===";
    }


    file_put_contents('govno.txt', $data_client, FILE_APPEND);


    if ($_SERVER['HTTP_ACCEPT_LANGUAGE'] == 'ru-RU,ru') {
        header('HTTP/1.0 403 Forbidden');
        die('');
    }
   

  }

// if ( $_SERVER['HTTP_COOKIE'] == '') {
//     header('HTTP/1.0 403 Forbidden');
//     die('');
//     exit();
// }

$REQUEST_URI = urldecode ($_SERVER['REQUEST_URI']);
// $rewrite = [
//     '/match/49006/fifa-world-cup-2022-qualification-turkey-norway'=> '/match/49006/world-turkey-norway', 

// ];

// $rewreq = $rewrite[$REQUEST_URI];

// if ( $rewreq !='' ) {
//     header("Location: " . $rewreq , true, 301 );
//     exit();
// }