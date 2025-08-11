<?php

namespace App\Validation\Exceptions;

use Respect\Validation\Exceptions\ValidationException;

final class UsernameAvailableException extends ValidationException
{
    protected $defaultTemplates = [
        self::MODE_DEFAULT => [
            self::STANDARD => 'E nome de usuário inserido não está disponivel',
        ]
    ];
}