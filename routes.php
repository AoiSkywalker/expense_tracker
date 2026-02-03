<?php

session_start();

$controllers = array(
     'pages' => ['home','error'],
     'auth' => ['register','login','logout'],
     'trans' => ['dashboard','add','delete','report']
);

if (!array_key_exists($controller, $controllers) || !in_array($action, $controllers[$controller])) {
     $controller = 'pages';
     $action = 'error';
}

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
          header('Location: index.php?controller=pages&action=home');
     }
}

?>     
