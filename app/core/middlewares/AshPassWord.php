<?php
namespace Maxitsa\Middlewares;

class AshPassWord {

    public  function __invoke(string $password): string {
        return password_hash($password, PASSWORD_DEFAULT);
    }
}
