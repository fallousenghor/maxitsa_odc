<?php

use Maxitsa\Controller\ErrorController;
use Maxitsa\Controller\HomeController;
use Maxitsa\Controller\UserController;

return [
    'GET' => [
        '/' => [UserController::class, 'login'],
        '/signup' => [UserController::class, 'signup'],
        '/login' => [UserController::class, 'login'],
        '/accueil' => [HomeController::class, 'index',"middlewares" => ['auth']],
        '/transactions' => [HomeController::class, 'transactions',"middlewares" => ['auth']],
        '/tout-historique' => [HomeController::class, 'toutHistorique', "middlewares" => ['auth']],
        '/error404' => [ErrorController::class, 'error404'],
        '/logout' => [UserController::class, 'logout'],
    ],
    'POST' => [
        '/signin' => [UserController::class, 'signin'],
        '/signup' => [UserController::class, 'signup'],
        '/add-secondary-account' => [UserController::class, 'addSecondaryAccount'],
        '/changer-compte' => [HomeController::class, 'changerCompte'],
    ]
];

