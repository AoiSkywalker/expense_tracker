<?php
require_once('controllers/base_controller.php');

class PagesController extends BaseController {
     function __construct() {
          $this -> folder = 'pages';
     }

     public function index() {

     }

     public function home() {
          $hours = date('H');
          if ($hours > 4 && $hours < 11) {
               $time = "morning";
          } else if ($hours >= 11 && $hours <= 18) {
               $time = "afternoon";
          } else {
               $time = "evening";
          }
          $data = array(
               'time' => $time,
               'greeting' => "how are you today ?"
          );
          $this -> render('home', $data);
     }

     public function error() {
          $this -> render('error');
     }
}

?>
