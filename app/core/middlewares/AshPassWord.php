<?php
namespace Maxitsa\Middlewares;

class AshPassWord {

    public static function hashPassword(string $password): string {
        return password_hash($password, PASSWORD_DEFAULT);
    }
}
