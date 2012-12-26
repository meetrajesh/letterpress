<?php

ini_set('error_reporting', E_ALL | E_STRICT);
chdir(dirname(__FILE__));

if (file_exists('./init.local.php')) {
    require './init.local.php';
}

defined('IS_DEV') or define('IS_DEV', false);
ini_set('display_errors', IS_DEV);
ini_set('html_errors', IS_DEV);

session_start();
date_default_timezone_set('America/New_York');

require './lib/functions.php';

// to generate a new secret, run
//    $secret = ''; foreach (range(1,32) as $i) { @$secret .= chr(rand(33,126)); } echo $secret;
// on phpsh
add_define('CSRF_SECRET', '<Bot:e,42DCRNW5b/hH7nBPIUaYn&lEA');
add_define('UPLOAD_MAX_SIZE', 10*1024*1024); // 10M
add_define('STATIC_PREFIX', '/public/assets');
add_define('PATH_PREFIX', '/letterpress'); // e. /letterpress
add_define('WEB_ROOT', dirname(__FILE__) . PATH_PREFIX);
add_define('TEMPLATE_ROOT', dirname(__FILE__) . '/views');

// clean up $_GET and $_POST, ensure all values are strings (no arrays)
foreach (array('_GET', '_POST', '_REQUEST', '_COOKIE') as $sglobal) {
    foreach ($$sglobal as $k => $v) {
        $$sglobal[$k] = trim((string) $v);
    }
}

$routes = array('/$' => array('index', 'index'), // empty route, just root domain
				'/game/new' => array('game', 'new_game'),
				'/game/start' => array('game', 'start'),
				'/game/show' => array('game', 'show'),
				'/game/move' => array('game', 'move'),
				'/game/delete' => array('game', 'delete'),
				'/login' => array('index', 'login'),
				'/404' => array('index', 'misc_page', array('404')),
				);

return $routes;

