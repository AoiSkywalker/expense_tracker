<?php
class DB {
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
                              password TEXT NOT NULL,
                              avatar TEXT,
                              real_name TEXT NOT NULL,
                              email TEXT,
                              phone TEXT,
                              dob DATE,
                              address TEXT
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

class Entity_User {
     private $id;
     private $name;
     private $password;
     public $avatar;
     private $real_name;
     private $email;
     private $phone;
     private $dob;
     private $address;

     public function __construct($id=null, $name=null, $password=null, $avatar=null, $real_name=null, $email=null, $phone=null, $dob=null, $address=null) {
          if ($id !== null) $this->id = $id;
          if ($name !== null) $this->name = $name;
          if ($password !== null) $this->password = $password;
          if ($avatar !== null) $this->avatar = $avatar;
          if ($real_name !== null) $this->real_name = $real_name;
          if ($email !== null) $this->email = $email;
          if ($phone !== null) $this->phone = $phone;
          if ($dob !== null) $this->dob = $dob;
          if ($address !== null) $this->address = $address;
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

     public function set_real_name($real_name) {
          $this -> real_name = $real_name;
     }

     public function get_real_name() {
          return $this -> real_name;
     }

     public function set_email($email) {
          $this -> email = $email;
     }

     public function get_email() {
          return $this -> email;
     }

     public function set_dob($dob) {
          $this -> dob = $dob;
     }

     public function get_dob() {
          return $this -> dob;
     }

     public function set_phone($phone) {
          $this -> phone = $phone;
     }

     public function get_phone() {
          return $this -> phone;
     }

     public function set_address($address) {
          $this -> phone = $phone;
     }

     public function get_address() {
          return $this -> address;
     }

     public function verify_user($user_input, $password_input) {
          if ($user_input === $this -> name) {
               return password_verify($password_input, $this -> password);
          } else {
               return false;
          }
     }

     public static function verify_reset($username, $email) {
          $db = DB::getInstance();
          $stmt = $db -> prepare("SELECT * FROM users WHERE name = ? AND email = ? LIMIT 1");
          $stmt -> execute([$username, $email]);
          $stmt -> setFetchMode(PDO::FETCH_CLASS, self::class);
          return $stmt -> fetch();
     }

     public function save() {
          $db = DB::getInstance();
          
          if ($this -> id !== null) {
               // update
              $stmt = $db -> prepare("UPDATE users SET name=?, password=?, avatar=?, real_name=?, email=?, phone=?, dob=?, address=? WHERE id=?");
              return $stmt -> execute([
                  $this -> name, $this -> password, $this -> avatar, $this -> real_name, 
                  $this -> email, $this -> phone, $this -> dob, $this -> address, $this -> id
              ]);
          } else {
               // register
              $stmt = $db -> prepare("INSERT INTO users (name, password, real_name, email) VALUES (?, ?, ?, ?)");
              $result = $stmt -> execute([$this -> name, $this -> password, $this -> real_name, $this -> email]);
              if ($result) {
                  $this -> id = $db -> lastInsertId(); 
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

     public function delete() {
          $db = DB::getInstance();
          
          $stmt1 = $db -> prepare("DELETE FROM transactions WHERE user_id = ?");
          $stmt1 -> execute([$this -> id]);
          
          $stmt2 = $db -> prepare("DELETE FROM users WHERE id = ?");
          return $stmt2 -> execute([$this -> id]);
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
          if ($id !== null) $this -> id = $id;
          if ($title !== null) $this -> title = $title;
          if ($amount !== null) $this -> amount = $amount;
          if ($category_id !== null) $this -> category_id = $category_id;
          if ($user_id !== null) $this -> user_id = $user_id;
          if ($created_at !== null) $this -> created_at = $created_at;
     }

     public static function all($user_id) {
          $db = DB::getInstance();
          $sql = "SELECT 
                      t.id as id, 
                      t.title as title, 
                      t.amount as amount, 
                      t.category_id as category_id, 
                      t.user_id as user_id, 
                      t.created_at as created_at,
                      c.title as category_name, 
                      c.type as category_type 
                  FROM transactions t 
                  LEFT JOIN category c ON t.category_id = c.id 
                  WHERE t.user_id = ? 
                  ORDER BY t.created_at DESC";
                  
          $stmt = $db->prepare($sql);
          $stmt -> execute([$user_id]);
          return $stmt->fetchAll(PDO::FETCH_CLASS, self::class);
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

class Entity_Category {
     public $id;
     public $title;
     public $type;
 
     public function __construct($id = null, $title = null, $type = null) {
         if ($id) $this->id = $id;
         if ($title) $this->title = $title;
         if ($type) $this->type = $type;
     }
 
     public function save() {
         $db = DB::getInstance();
         $stmt = $db->prepare("INSERT INTO category (title, type) VALUES (?, ?)");
         return $stmt->execute([$this->title, $this->type]);
     }
 
     public static function all() {
         $db = DB::getInstance();
         $stmt = $db->query("SELECT * FROM category ORDER BY type, title");
         return $stmt->fetchAll(PDO::FETCH_CLASS, self::class);
     }
 }

?>