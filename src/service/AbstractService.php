<?php
namespace Maxitsa\Service;

abstract class AbstractService {
    protected static $instance = null;
    protected function __construct() {}

   
    public static function getInstance(): static {
        if (static::$instance === null) {
            static::$instance = new static();
        }
        return static::$instance;
    }
}
