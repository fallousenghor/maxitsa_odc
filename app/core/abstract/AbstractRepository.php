<?php
namespace Maxitsa\Abstract;

use Maxitsa\Core\App;

abstract class AbstractRepository {
protected static array $instances = [];
    protected \PDO $pdo;
    protected function __construct() {}

    
    public static function getInstance(): static {
        $class = static::class;
        if (!isset(self::$instances[$class])) {
            self::$instances[$class] = new static();
        }
        return self::$instances[$class];
    }

    abstract public function insert($entity = null);
   
}
