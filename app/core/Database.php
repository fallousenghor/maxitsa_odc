<?php
namespace Maxitsa\Core;

use PDO;
use PDOException;
class Database {
    private static $instance = null;
    private $pdo;

    private function __construct() {
       
        
        try {
            $this->pdo = new PDO("pgsql:host=localhost;dbname=maxitsa;port=5432", "admin", "gallas", [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
            ]);
        } catch (PDOException $e) {
            die('Database connection failed: ' . $e->getMessage());
        }
    }

    public static function getInstance() {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function getConnection() {
        return $this->pdo;
    }
}
