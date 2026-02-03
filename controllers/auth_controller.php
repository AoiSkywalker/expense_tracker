<?php 
class AuthController {
     function __construct() {
          $this -> folder = 'auth';
     }

     public function register() {
          
     }

     public function login() {
          header('Location: /views/auth/login.php');
     }

     public function logout() {
          session_start();
          session_destroy();
          header('Location: /views/pages/home');
          exit;
     }
}
?>
