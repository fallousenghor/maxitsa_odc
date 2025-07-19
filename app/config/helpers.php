<?php

require_once __DIR__ . '/env.php';
function redirect($path)
{
    global $BASE_URL;
    $baseUrl = $BASE_URL ?? getenv('BASE_URL');
    if (!$baseUrl) {
       
        die('BASE_URL non défini dans .env');
    }
    $baseUrl = rtrim($baseUrl, '/;');
    $path = ltrim($path, '/');
    header('Location: ' . $baseUrl . '/' . $path);
    exit;
}

function dd($data)
{
    echo '<pre>';
    var_dump($data);
    echo '</pre>';
    exit;
}
