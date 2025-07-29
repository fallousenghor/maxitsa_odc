<?php

$DB_HOST = $_ENV['DB_HOST'] ?? getenv('DB_HOST');
$DB_NAME = $_ENV['DB_NAME'] ?? getenv('DB_NAME');
$DB_USER = $_ENV['DB_USER'] ?? getenv('DB_USER');
$DB_PASS = $_ENV['DB_PASS'] ?? getenv('DB_PASS');
$BASE_URL = $_ENV['BASE_URL'] ?? getenv('BASE_URL');

$PGSQL_DSN = "pgsql:host=$DB_HOST;dbname=$DB_NAME;port=5432";

// $MYSQL_DSN = "mysql:host=$DB_HOST;dbname=$DB_NAME;port=3306";
