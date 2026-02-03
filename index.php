<?php
session_start();

ini_set('display_errors',1);
ini_set('display_startup_errors',1);
error_reporting(E_ALL);

$controllers = array(
     'pages' => ['home','error'],
     'auth' => ['register','login','logout'],
     'trans' => ['dashboard','add','delete','report']
);

$routes = [
     'login'     => ['auth', 'login'],
     'register'  => ['auth', 'register'],
     'logout'    => ['auth', 'logout'],
     'dashboard' => ['trans', 'dashboard'],
     'home'      => ['pages', 'home']
];

require_once('models/connection.php');

if (preg_match('/\.(?:png|jpg|jpeg|gif|css|js)$/', $_SERVER['REQUEST_URI'])) {
     return false;
}

$request_uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$request_uri = trim($request_uri, '/');

if (array_key_exists($request_uri, $routes)) {
     $controller = $routes[$request_uri][0];
     $action = $routes[$request_uri][1];
} else {
     if (empty($request_uri)) {
          $controller = 'pages';
          $action = 'home';
     } else {
          $segments = explode('/', $request_uri);
          if (count($segments) != 2) {
               $controller = 'pages';
               $action = 'error';
          } else {
               $controller = $segments[0];
               $action = $segments[1];
          }
     }
}


// if (!array_key_exists($controller, $controllers) || !in_array($action, $controllers[$controller])) {
//      $controller = 'pages';
//      $action = 'error';
// }

if ($controller == 'trans' && !isset($_SESSION['user_id'])) {
     $controller = 'auth';
     $action = 'login';
}

$file_controller = 'controllers/' . $controller . '_controller.php';
if (file_exists($file_controller)) {
     include_once($file_controller);
     $klass = str_replace('_', '', ucwords($controller, '_')) . 'Controller';
     if (class_exists($klass) && method_exists($klass, $action)) {
          $controller = new $klass;
          $controller -> $action();
     } else {
          $controller = 'pages';
          $action = 'error';
     }
}
?>
