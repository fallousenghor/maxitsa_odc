<?php

use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable(__DIR__ . '/../../');
$dotenv->safeLoad(); 

require_once __DIR__ . '/helpers.php';
require_once __DIR__ . '/middlewares.php';
