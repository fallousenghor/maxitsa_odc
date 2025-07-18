<?php
namespace Maxitsa\Core;

use Maxitsa\Core\Session;

class App {
   
    private static array $dependencies = [
       
        'core' => [
            'Database' => Database::class,
            'Session' => Session::class,
            'Validator' => Validator::class,
        ],
       
        'repository' => [
            'PersonneRepository' => \Maxitsa\Repository\PersonneRepository::class,
            'CompteRepository' => \Maxitsa\Repository\CompteRepository::class,
        ],
      
        'controller' => [
            'UserController' => \Maxitsa\Controller\UserController::class,
            'HomeController' => \Maxitsa\Controller\HomeController::class,
        ],
     
        'service' => [
            'PersonneService' => \Maxitsa\Service\PersonneService::class,
            'CompteService' => \Maxitsa\Service\CompteService::class,
            'TransactionService' => \Maxitsa\Service\TransactionService::class,
        ],
    ];

   
    public static function getDependency(string $category, string $name)
    {
        if (isset(self::$dependencies[$category][$name])) {
            $class = self::$dependencies[$category][$name];
      
            if ($category === 'core' && $name === 'Database') {
    
                return Database::getInstance();
            }
        
            return new $class();
            
        }
        return null;
    }
}
