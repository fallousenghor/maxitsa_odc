<?php
require_once __DIR__ . '/../app/config/bootstrap.php';
require_once __DIR__ . '/../app/config/env.php';
require_once __DIR__ . '/../vendor/autoload.php';
use Maxitsa\Seeder\Seeder;
use Maxitsa\Core\Database;

$pdo = Database::getInstance()->getConnection();
Seeder::seed($pdo);
echo "Données de test insérées !\n";
