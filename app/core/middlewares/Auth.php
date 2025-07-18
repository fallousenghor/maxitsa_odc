<?php
namespace App\Core\Middlewares;
use Maxitsa\Core\Session;



class Auth {
    public function __invoke( $next) {
        $session = Session::getInstance();
        
        if (!$session->isset('user')) {
            header('Location: /login');
            exit;
        }
        return $next();
    }
}
