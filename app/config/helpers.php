<?php

function redirect($path)
{
    $baseUrl = getenv('BASE_URL');
    if (!$baseUrl) {
        $baseUrl = 'http://localhost:8082'; 
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
