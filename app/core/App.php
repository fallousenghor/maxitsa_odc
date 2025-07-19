<?php
namespace Maxitsa\Core;

use Maxitsa\Core\Session;

class App {
   
    private static array $dependencies = [];

    // Charger les dépendances depuis le fichier YAML
    public static function loadDependencies(string $filePath)
    {
        if (file_exists($filePath)) {
            require_once __DIR__ . '/../../vendor/autoload.php';
            self::$dependencies = \Symfony\Component\Yaml\Yaml::parseFile($filePath);
        }
    }

   
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
