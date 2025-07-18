<?php
namespace Maxitsa\Service;

abstract class AbstractService {
protected static array $instances = [];
    protected function __construct() {}

   
    public static function getInstance() {
        $class = static::class;
        if (!isset(self::$instances[$class])) {
            self::$instances[$class] = new static();
        }
        return self::$instances[$class];
    }
}
