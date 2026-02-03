<?php
class DB
{
     private static $instance = NULL;
     public static function getInstance() {
          if (!isset(self::$instance)) {
               try {
                    self::$instance = new PDO("sqlite::app.db");
                    self::$instance -> setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
                    $sql = "
                         CREATE TABLE IF NOT EXISTS category (
                              id INTEGER PRIMARY KEY AUTOINCREMENT,
                              title TEXT NOT NULL,
                              type TEXT CHECK(type IN ('expense','income'));
                         );
                         CREATE TABLE IF NOT EXISTS transactions (
                              id INTEGER PRIMARY KEY AUTOINCREMENT,
                              title TEXT NOT NULL,
                              amount REAL NOT NULL,
                              category TEXT,
                              created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
                              FOREIGN KEY (category_id) REFERENCES category(id)
                         )
                         ";
                    self::instance -> exec($sql);
               } catch (PDOException $ex) {
                    die(" Connection error: " . $ex -> getMessage());
               }
          }
          return self::instance;
     }
}
