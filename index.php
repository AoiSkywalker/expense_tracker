<?php

ini_set('display_errors',1);
ini_set('display_startup_errors',1);
error_reporting(E_ALL);

require_once('models/connection.php');

if (preg_match('/\.(?:png|jpg|jpeg|gif|css|js)$/', $_SERVER['REQUEST_URI'])) {
     return false;
}

$request_uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$segments = explode('/', trim($request_uri, '/'));

if (empty($segments[0])) {
     $controller = 'pages';
     $action = 'home';
} else {
     $controller = $segments[0];
     if (empty($segments[1])) {
          $action = 'home';
     } else {
          $action = strtolower($segments[1]);
     }
}

require_once('routes.php');
?>
