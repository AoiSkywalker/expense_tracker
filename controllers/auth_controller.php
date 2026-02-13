<?php
require_once('controllers/base_controller.php');
require_once('models/connection.php');

class AuthController extends BaseController {
     function __construct() {
          $this -> folder = 'auth';
     }

     public function register() {
          $data = array();
          if ($_SERVER['REQUEST_METHOD'] === 'POST') {
               $username = $_POST['username'];
               $password = $_POST['password'];
               $confirm_password = $_POST['confirm_password'];

               if ($password !== $confirm_password) {
                    $data['error'] = "Invalid password !";
               } else if (Entity_User::findByName($username)) {
                    $data['error'] = "Username is not available !";
               } else {
                    $new_user = new Entity_User();
                    $new_user -> set_name($username);
                    $new_user -> set_password($password);
                    if ($new_user -> save()) {
                         header('Location: /login');
                         exit;
                    } else {
                         $data['error'] = "Something occurs error. Please try again :(";
                    }
                    $data['username'] = $username;
               }
          }

          $this -> render('register', $data);
     }

     public function login() {
          $data = array();
          if (isset($_POST['username']) && isset($_POST['password'])) {
               // $data['message'] = "Login error";
               // $data['user_id'] = $_POST['username'];
               $username = $_POST['username'];
               $password = $_POST['password'];
               $user = Entity_User::findByName($username);
               if ($user && $user -> verify_user($username, $password)) {
                    $_SESSION['user_id'] = $user -> get_id();
                    // $_SESSION['username'] = $user -> name;
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
          session_unset();
          session_destroy();

          // if (isset($_SESSION['user'])) {
          //      destroySession();
          //      echo "<br><div class='center'>You have been logged out. Please
          //      <a data-transition='slide' href='index.php'>click here</a> to refresh the screen.</div>";
          // } else echo "<div class='center'>You cannot log out because
          //           you are not logged in</div>";
          header('Location: /home');
          exit;
     }
}
?>
