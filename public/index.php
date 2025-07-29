
<?php
session_start();


use Maxitsa\Core\Router;


require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../app/config/bootstrap.php';


use Maxitsa\Core\App;
App::loadDependencies(__DIR__ . '/../app/config/services.yml');



$router = new Router();
$router->dispatch($_SERVER['REQUEST_URI']);




 