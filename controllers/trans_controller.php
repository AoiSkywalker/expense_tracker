<?php
require_once('controllers/base_controller.php');
require_once('models/connection.php');

class TransController extends BaseController {
    
    function __construct() {
        $this->folder = 'trans';
        if (!isset($_SESSION['user_id'])) {
            header('Location: /login');
            exit;
        }
    }

    public function dashboard() {
        $transactions = Entity_Transaction::all($_SESSION['user_id']);
        $categories = Entity_Transaction::getCategories(); 
        
        $chartData = [];
        $totalIncome = 0;
        $totalExpense = 0;
        
        foreach ($transactions as $t) {
            $amount = (float) $t -> amount;
            $type = !empty($t -> category_type) ? $t -> category_type : 'expense';
        
            if ($type === 'expense') {
                $totalExpense += $amount;
                $catName = !empty($t -> category_name) ? $t -> category_name : 'Other';
                $chartData[$catName] = ($chartData[$catName] ?? 0) + $amount;
            } else if ($type === 'income') {
                $totalIncome += $amount;
            }
        }

        $balance = $totalIncome - $totalExpense;
        $labels = array_keys($chartData);
        $data = array_values($chartData);

        $this -> render('dashboard', [
            'transactions' => $transactions,
            'transactionsJson' => json_encode($transactions), 
            'categories' => $categories,                      
            
            'chartLabels' => json_encode($labels),
            'chartData' => json_encode($data),
            'totalIncome' => $totalIncome,
            'totalExpense' => $totalExpense,
            'balance' => $balance
        ]);
    }

    public function add() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $category_id = $_POST['category_id'];
            
            if ($category_id === 'new') {
                $db = DB::getInstance();
                $stmt = $db->prepare("INSERT INTO category (title, type) VALUES (?, ?)");
                $stmt->execute([$_POST['new_cat_title'], $_POST['new_cat_type']]);
                
                $category_id = $db->lastInsertId();
            }

            $trans = new Entity_Transaction();
            $trans->title = $_POST['title'];
            $trans->amount = $_POST['amount'];
            $trans->category_id = $category_id;
            $trans->user_id = $_SESSION['user_id'];
            
            $trans->save();
            header('Location: /dashboard');
            exit;
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