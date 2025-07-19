<?php
namespace Maxitsa\Core;

use PDO;
use PDOException;

require_once dirname(__DIR__,2) . '/app/config/bootstrap.php';
require_once dirname(__DIR__,2) . '/app/config/env.php';
class Database {
    private static $instance = null;
    private $pdo;

    private function __construct() {
        global $PGSQL_DSN, $DB_USER, $DB_PASS;
       
        if (!$PGSQL_DSN || !$DB_USER || !$DB_PASS) {
            die('DSN ou identifiants vides :<br>DSN=' . var_export($PGSQL_DSN, true) . '<br>USER=' . var_export($DB_USER, true) . '<br>PASS=' . var_export($DB_PASS, true));
        }
        try {
            $this->pdo = new PDO($PGSQL_DSN, $DB_USER, $DB_PASS, [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
            ]);
        } catch (PDOException $e) {
            die('Database connection failed: ' . $e->getMessage() . '<br>DSN=' . var_export($PGSQL_DSN, true));
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
