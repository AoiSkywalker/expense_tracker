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
               $real_name = $_POST['real_name'];
               $email = trim($_POST['email']);

               $existing_user = Entity_User::findByName($username);

               if ($password !== $confirm_password) {
                    $data['error'] = "Invalid password !";
               } else if (Entity_User::findByName($username)) {
                    $data['error'] = "Username is not available !";
               } else {
                    $new_user = new Entity_User();
                    $new_user -> set_name($username);
                    $new_user -> set_password($password);
                    $new_user -> set_real_name($real_name);
                    $new_user -> set_email($email);

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

     public function profile() {
          if (!isset($_SESSION['user_id'])) {
              header('Location: /login');
              exit;
          }
  
          $user = Entity_User::find($_SESSION['user_id']);

          if (!$user) {
               session_unset();     
               session_destroy();   
               header('Location: /login');
               exit;
           }

          $data = ['user' => $user, 'message' => ''];
  
          if ($_SERVER['REQUEST_METHOD'] === 'POST') {
          //     $user -> set_phone() = $_POST['phone'];
          //     $user -> set_dob() = $_POST['dob'];
          //     $user -> set_address() = $_POST['address'];
  
              if (!empty($_POST['new_password'])) {
                  $user->password = password_hash($_POST['new_password'], PASSWORD_DEFAULT);
              }
  
              if (isset($_FILES['avatar']) && $_FILES['avatar']['error'] === UPLOAD_ERR_OK) {
                  $uploadDir = 'assets/uploads/';
                  if (!is_dir($uploadDir)) { mkdir($uploadDir, 0777, true); }
  
                  $fileName = time() . '_' . basename($_FILES['avatar']['name']);
                  $targetFilePath = $uploadDir . $fileName;
                  $fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION);
                  $allowTypes = array('jpg', 'png', 'jpeg', 'gif');
                  
                  if (in_array(strtolower($fileType), $allowTypes)) {
                      if (move_uploaded_file($_FILES['avatar']['tmp_name'], $targetFilePath)) {
                          $user->avatar = '/' . $targetFilePath;
                      }
                  } else {
                      $data['message'] = "Only file types of JPG, JPEG, PNG, GIF are supported.";
                  }
              }
  
              if ($user->save()) {
                    $data['message'] = "Update profile successfully!";
               } else {
                    $data['message'] = "Error founded. Please try again later.";
               }
          }
  
          $this->render('profile', $data); 
     }

     public function delete_account() {
          if (!isset($_SESSION['user_id'])) {
              header('Location: /login');
              exit;
          }
  
          if ($_SERVER['REQUEST_METHOD'] === 'POST') {
              $user = Entity_User::find($_SESSION['user_id']);
              
              if ($user) {
                  $user->delete();
                  session_unset();
                  session_destroy();
              }
          }
          
          header('Location: /login');
          exit;
     }

     public function forgot_password() {
          $data = ['message' => ''];
          
          if ($_SERVER['REQUEST_METHOD'] === 'POST') {
              $username = trim($_POST['username']);
              $email = trim($_POST['email']);
              
              $user = Entity_User::verify_reset($username, $email);
              
              if ($user) {
                  $_SESSION['reset_user_id'] = $user -> get_id();
                  header('Location: /reset_password');
                  exit;
              } else {
                  $data['message'] = "Username or email is not available";
              }
          }
          $this -> render('forgot_password', $data);
      }
  
      public function reset_password() {
          if (!isset($_SESSION['reset_user_id'])) {
              header('Location: /forgot_password');
              exit;
          }
  
          $data = ['message' => ''];
          
          if ($_SERVER['REQUEST_METHOD'] === 'POST') {
              $new_password = $_POST['new_password'];
              $confirm_password = $_POST['confirm_password'];
  
              if ($new_password === $confirm_password) {
                  $user = Entity_User::find($_SESSION['reset_user_id']);
                  if ($user) {
                      $user -> set_password($new_password);
                      $user -> save();
                      
                      unset($_SESSION['reset_user_id']);
                      
                      header('Location: /login?reset=success');
                      exit;
                  }
              } else {
                  $data['message'] = "Cannot confirm password!";
              }
          }
          $this -> render('reset_password', $data);
      }

     }
?>
