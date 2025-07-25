
<?php
// Debug : afficher et loguer toutes les erreurs PHP
ini_set('display_errors', 1);
ini_set('log_errors', 1);
ini_set('error_log', __DIR__ . '/../php_error.log');
error_reporting(E_ALL);

use Maxitsa\Core\Router;


require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../app/config/bootstrap.php';


use Maxitsa\Core\App;
App::loadDependencies(__DIR__ . '/../app/config/services.yml');



$router = new Router();
$router->dispatch($_SERVER['REQUEST_URI']);



$host = getenv("DB_HOST");
$db   = getenv("DB_NAME");
$user = getenv("DB_USER");
$pass = getenv("DB_PASSWORD");
$port = getenv("DB_PORT");

$dsn = "pgsql:host=$host;port=$port;dbname=$db";

try {
    $pdo = new PDO($dsn, $user, $pass);
    echo "Connexion réussie à la base PostgreSQL Render !";
} catch (PDOException $e) {
    echo "Erreur de connexion : " . $e->getMessage();
}
?>
