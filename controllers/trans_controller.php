<?php
require_once('controllers/base_controller.php');
require_once('models/connection.php');

class TransController extends BaseController {
    
    function __construct() {
        $this -> folder = 'trans';
        
        if (!isset($_SESSION['user_id'])) {
            header('Location: /login');
            exit;
        }
    }

    public function dashboard() {
        $transactions = Entity_Transaction::all($_SESSION['user_id']);
        $this->render('dashboard', ['transactions' => $transactions]);
    }

    public function add() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $trans = new Entity_Transaction();
            $trans->title = $_POST['title'];
            $trans->amount = $_POST['amount'];
            $trans->category_id = $_POST['category_id'];
            $trans->user_id = $_SESSION['user_id']; 
            
            $trans->save();
            header('Location: /dashboard'); 
        } else {
            $categories = Entity_Transaction::getCategories();
            $this->render('add', ['categories' => $categories]);
        }
    }

    public function delete() {
        if (isset($_GET['id'])) {
            $trans = Entity_Transaction::find($_GET['id']);
            if ($trans && $trans->user_id == $_SESSION['user_id']) {
                $trans->delete();
            }
        }
        header('Location: /dashboard');
    }
}
?>