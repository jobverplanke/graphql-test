<?php

declare(strict_types=1);

namespace App\Services\GraphQL\Exceptions;

class InvalidQueryException extends \Exception
{
    public static function make(?string $message = null): InvalidQueryException
    {
        return new static(message: $message ?? 'Invalid GraphQL query');
    }
}
