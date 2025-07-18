<?php
namespace Maxitsa\Abstract;

use Maxitsa\Core\App;

abstract class AbstractRepository {
    protected static ?self $instance = null;
    protected \PDO $pdo;
    protected function __construct() {}

    
    public static function getInstance(): static {
        if (static::$instance === null) {
            static::$instance = new static();
        }
        return static::$instance;
    }

    abstract public function insert($entity = null);
   
}
