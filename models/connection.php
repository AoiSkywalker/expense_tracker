<?php
class DB
{
     private static $instance = NULL;
     public static function getInstance() {
          if (!isset(self::$instance)) {
               try {
                    self::$instance = new PDO("sqlite:app.db");
                    self::$instance -> setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
                    $sql = "
                         CREATE TABLE IF NOT EXISTS users (
                              id INTEGER PRIMARY KEY AUTOINCREMENT,
                              name TEXT NOT NULL,
                              password TEXT NOT NULL
                         );
                         CREATE TABLE IF NOT EXISTS category (
                              id INTEGER PRIMARY KEY AUTOINCREMENT,
                              title TEXT NOT NULL,
                              type TEXT CHECK(type IN ('expense','income'))
                         );
                         CREATE TABLE IF NOT EXISTS transactions (
                              id INTEGER PRIMARY KEY AUTOINCREMENT,
                              title TEXT NOT NULL,
                              amount REAL NOT NULL,
                              category_id INTEGER,
                              user_id INTEGER,
                              created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
                              FOREIGN KEY (category_id) REFERENCES category(id),
                              FOREIGN KEY (user_id) REFERENCES users(id)
                         );
                         ";
                    self::$instance -> exec($sql);
               } catch (PDOException $ex) {
                    die(" Connection error: " . $ex -> getMessage());
               }
          }
          return self::$instance;
     }
}

class Entity_User 
{
     private $id;
     private $name;
     private $password;

     public function __construct($id = null, $name = null, $password = null) {
          if ($id) $this -> id = $id;
          if ($name) $this -> name = $name;
          if ($password) $this -> password = $password;
     }

     public function get_id() {
          return $this -> id;
     }

     public function get_name() {
          return $this -> name;
     }

     public function set_name($name) {
          $this -> name = $name;
     }

     public function get_password() {
          return $this -> password;
     }

     public function set_password($raw_password) {
          $this -> password = password_hash($raw_password, PASSWORD_DEFAULT);
     }

     public function verify_user($user_input, $password_input) {
          if ($user_input === $this -> name) {
               return password_verify($password_input, $this -> password);
          } else {
               return false;
          }
     }

     public function save() {
          $db = DB::getInstance();
          
          if ($this->id !== null) {
              $stmt = $db->prepare("UPDATE users SET name = ?, password = ? WHERE id = ?");
              return $stmt->execute([$this->name, $this->password, $this->id]);
          } 
          
          else {
              $stmt = $db->prepare("INSERT INTO users (name, password) VALUES (?, ?)");
              $result = $stmt->execute([$this->name, $this->password]);
              
              if ($result) {
                  $this->id = $db->lastInsertId(); 
                  return true;
              }
              return false;
          }
      }

     public static function all() {
          $db = DB::getInstance();
          $stmt = $db -> query("SELECT * FROM users");
          return $stmt -> fetchAll(PDO::FETCH_CLASS, self::class);
     }

     public static function find($id) {
          $db = DB::getInstance();
          $stmt = $db -> prepare("SELECT * FROM users WHERE id = ? LIMIT 1");
          $stmt -> execute([$id]);
          $stmt -> setFetchMode(PDO::FETCH_CLASS, self::class);
          return $stmt -> fetch();
     }
     public static function findByName($name) {
          $db = DB::getInstance();
          $stmt = $db -> prepare("SELECT * FROM users WHERE name = ? LIMIT 1");
          $stmt -> execute([$name]);
          $stmt -> setFetchMode(PDO::FETCH_CLASS, self::class);
          return $stmt -> fetch();
     }
}

class Entity_Transaction {
    public $id;
    public $title;
    public $amount;
    public $category_id;
    public $user_id;
    public $created_at;

    public function __construct($id=null, $title=null, $amount=null, $category_id=null, $user_id=null, $created_at=null) {
        $this -> id = $id;
        $this -> title = $title;
        $this -> amount = $amount;
        $this -> category_id = $category_id;
        $this -> user_id = $user_id;
        $this -> created_at = $created_at;
    }

    public static function all($user_id) {
        $db = DB::getInstance();
        $sql = "SELECT t.*, c.title as category_name 
                FROM transactions t 
                LEFT JOIN category c ON t.category_id = c.id 
                WHERE t.user_id = ? 
                ORDER BY t.created_at DESC";
        $stmt = $db->prepare($sql);
        $stmt -> execute([$user_id]);
        return $stmt -> fetchAll(PDO::FETCH_CLASS, self::class);
    }

    public static function find($id) {
        $db = DB::getInstance();
        $stmt = $db -> prepare("SELECT * FROM transactions WHERE id = ?");
        $stmt -> execute([$id]);
        $stmt -> setFetchMode(PDO::FETCH_CLASS, self::class);
        return $stmt -> fetch();
    }

    public function save() {
        $db = DB::getInstance();
        if ($this -> id) {
            // update
            $stmt = $db -> prepare("UPDATE transactions SET title=?, amount=?, category_id=? WHERE id=?");
            return $stmt -> execute([$this->title, $this->amount, $this->category_id, $this->id]);
        } else {
            // insert
            $stmt = $db -> prepare("INSERT INTO transactions (title, amount, category_id, user_id, created_at) VALUES (?, ?, ?, ?, datetime('now'))");
            return $stmt -> execute([$this->title, $this->amount, $this->category_id, $this->user_id]);
        }
    }

    public function delete() {
        $db = DB::getInstance();
        $stmt = $db -> prepare("DELETE FROM transactions WHERE id = ?");
        return $stmt -> execute([$this->id]);
    }
    
    public static function getCategories() {
        $db = DB::getInstance();
        $stmt = $db -> query("SELECT * FROM category");
        return $stmt -> fetchAll(PDO::FETCH_OBJ);
    }
}
?>