<?php

declare(strict_types=1);

namespace App\Services\GraphQL\Exceptions;

use Exception;

class MissingImplementationException extends Exception
{
    public static function make(string $method, ?string $message = null): MissingImplementationException
    {
        return new static(message: $message ?? 'Implementation of method ' . $method . ' missing.');
    }
}
