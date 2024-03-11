<?php

namespace App\Libraries;

class Hash
{
    public static function make(string $password): string
    {
        return password_hash($password, PASSWORD_BCRYPT);
    }

    public static function check(string $entered_password, string $registered_password): bool
    {
        return password_verify($entered_password, $registered_password);
    }
}