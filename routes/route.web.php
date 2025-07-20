<?php

use Maxitsa\Controller\ErrorController;
use Maxitsa\Controller\HomeController;
use Maxitsa\Controller\UserController;
use Maxitsa\Controller\TransactionController;

return [
    'GET' => [
        '/' => [UserController::class, 'login'],
        '/signup' => [UserController::class, 'signup'],
        '/login' => [UserController::class, 'login'],
        '/accueil' => [HomeController::class, 'index',"middlewares" => ['auth']],
        '/transactions' => [TransactionController::class, 'transactions',"middlewares" => ['auth']],
        '/tout-historique' => [TransactionController::class, 'toutHistorique', "middlewares" => ['auth']],
        '/transfert' => [TransactionController::class, 'showTransfertForm', "middlewares" => ['auth']],
        '/error404' => [ErrorController::class, 'error404'],
        '/logout' => [UserController::class, 'logout'],
    ],
    'POST' => [
        '/signin' => [UserController::class, 'signin'],
        '/signup' => [UserController::class, 'signup', "middlewares" => ['ahspw']],
        '/add-secondary-account' => [UserController::class, 'addSecondaryAccount'],
        '/changer-compte' => [HomeController::class, 'changerCompte'],
        '/annuler-transfert' => [TransactionController::class, 'annulerTransfert', "middlewares" => ['auth']],
        '/transfert' => [TransactionController::class, 'transfert', "middlewares" => ['auth']],
    ]
];

