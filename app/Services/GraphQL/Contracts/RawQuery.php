<?php

declare(strict_types=1);

namespace App\Services\GraphQL\Contracts;

interface RawQuery
{
    public function __invoke(): string;
}
