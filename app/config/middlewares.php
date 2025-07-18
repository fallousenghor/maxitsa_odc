<?php

use App\Core\Middlewares\Auth;
use Maxitsa\Middlewares\AshPassWord;
$middlewares = [
     "auth" => Auth::class,
     "ahspw" => AshPassWord::class
];
