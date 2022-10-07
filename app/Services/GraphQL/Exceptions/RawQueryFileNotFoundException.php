<?php

declare(strict_types=1);

namespace App\Services\GraphQL\Exceptions;

use Exception;

class RawQueryFileNotFoundException extends Exception
{
    public static function make(string $file, ?string $message = null): RawQueryFileNotFoundException
    {
        return new static(message: $message ?? "Raw query file [$file] not found.");
    }
}
