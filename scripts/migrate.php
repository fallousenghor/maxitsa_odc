<?php
require_once __DIR__ . '/../app/config/bootstrap.php';
require_once __DIR__ . '/../app/config/env.php';
require_once __DIR__ . '/../vendor/autoload.php';
use Maxitsa\Migrations\Migration;
use Maxitsa\Core\Database;

$pdo = Database::getInstance()->getConnection();
Migration::migrate($pdo);
echo "Migration terminée !\n";
