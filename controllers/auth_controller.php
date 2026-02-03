<?php
require_once('controllers/base_controller.php');
require_once('models/connection.php');

class AuthController extends BaseController {
     function __construct() {
          $this -> folder = 'auth';
     }

     public function register() {
          
     }

     public function login() {
          $data = array();
          if (isset($_POST['username'])  && isset($_POST['password'])) {
               // $data['message'] = "Login error";
               // $data['user_id'] = $_POST['username'];
               $username = $_POST['username'];
               $password = $_POST['password'];
               $user = User::verify_password($username, $password);
               if ($user) {
                    $_SESSION['user_id'] = $user['id'];
                    $_SESSION['username'] = $user['name'];
                    header('Location: /dashboard');
                    exit;
               } else {
                    $data['message'] = "Invalid credentials";
                    $data['username'] = $username;
               }
          }
          $this -> render('login', $data);
     }

     public function logout() {
          if (session_status() === PHP_SESSION_NONE) {
               session_start();
          }
          
          $_SESSION = array();
          session_destroy();

          // if (isset($_SESSION['user'])) {
          //      destroySession();
          //      echo "<br><div class='center'>You have been logged out. Please
          //      <a data-transition='slide' href='index.php'>click here</a> to refresh the screen.</div>";
          // } else echo "<div class='center'>You cannot log out because
          //           you are not logged in</div>";
          header('Location: /views/pages/home');
          exit;
     }
}
?>
