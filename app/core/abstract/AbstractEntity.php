<?php
namespace Maxitsa\Abstract;
abstract class AbstractEntity {
    public function __get($arg){
        return property_exists($this, $arg) ? $this->$arg : null;
    }
    public function __set($arg, $value){
        $this->$arg = $value;
    }

 
    abstract public static function toObject(array $data): object;

  
    abstract public function toArray(): array;

   
    public function toJson(): string {
        return json_encode($this->toArray(), JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
    }
}
