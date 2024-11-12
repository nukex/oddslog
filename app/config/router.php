<?php

$router = $di->getRouter();

######################################
##  Site

$router->add(
    '/football/([0-9]{1,9})/(.*)',
    [
        'controller' => 'match',
        'action'     => 'view',
        'id'    => 1,
        'slug'  => 2,
    ]
);
$router->add(
    '/football/([0-9]{1,9})/(.*)',
    [
        'controller' => 'match',
        'action'     => 'ajax',
        'id'    => 1,
        'slug'  => 2,
    ]
)->via(['POST']);

$router->add(
    '/',
    [
        'controller' => 'index',
        'action'     => 'index',
    ]

);
$router->add(
    '/live',
    [
        'controller' => 'index',
        'action'     => 'live',
    ]

);

$router->add(
    '/date/',
    [
        'controller' => 'index',
        'action'     => 'index',
    ]

);

$router->add(
    '/date/([0-9]{4})-([0-9]{2})-([0-9]{2})',
    [
        'controller' => 'index',
        'action'     => 'index',
        'year'       => 1, 
        'month'      => 2, 
        'day'        => 3, 

    ]
);





$router->add(
    '/search/',
    [
        'controller' => 'index',
        'action'     => 'search',
    ]
)->via(['POST']);




//captcha page
$router->add(
    '/captcha',
    [
        'controller' => 'index',
        'action'     => 'captcha',
    ]
)->via(['POST']);

//generate captcha image
$router->add(
    '/captcha-image',
    [
        'action'     => 'captchaImg',
    ]
);



$router->add(
    '/sitemap.xml',
    [
        'controller' => 'sitemap',
        'action'     => 'sitemaps',

    ]
);



$router->add(
    '/sitemap-([0-9]{1,3}).xml',
    [
        'controller' => 'sitemap',
        'action'     => 'sitemap',
        'page' => 1,
    ]

);




$router->add(
    '/form/(.*)',
    [
        'controller' => 'index',
        'action'     => 'getForm',
        'form'  => 1,
    ]
);



######################################
##  USER

$router->add(
    '/user/dashboard',
    [
        'controller' => 'user',
        'action'     => 'dashboard',
    ]
);

// user Reg
$router->add(
    '/user/signup',
    [
        'controller' => 'user',
        'action'     => 'signup',
    ]
)->via(['POST']);

$router->add(
    '/user/signin',
    [
        'controller' => 'user',
        'action'     => 'signin',
    ]
)->via(['POST']);

$router->add(
    '/logout',
    [
        'controller' => 'user',
        'action'     => 'logout',
    ]
);



$router->add(
    '/user/reset-password',
    [
        'controller' => 'user',
        'action'     => 'resetPassword',
    ]
);


$router->add(
    '/user/reset-password',
    [
        'controller' => 'user',
        'action'     => 'resetPasswordPost',
    ]
)->via(['POST']);


$router->add(
    '/user/change-password',
    [
        'controller' => 'user',
        'action'     => 'changePassword',
    ]
);

$router->add(
    '/user/activate',
    [
        'controller' => 'user',
        'action'     => 'activate',
    ]
);




//Set 404 paths
$router->notFound(array(
    "controller" => "index",
    "action" => "route404"
));



$router->handle($_SERVER["REQUEST_URI"]);
