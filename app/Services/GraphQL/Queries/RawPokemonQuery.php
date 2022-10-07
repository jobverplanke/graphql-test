<?php

declare(strict_types=1);

namespace App\Services\GraphQL\Queries;

use App\Services\GraphQL\Contracts\RawQuery;

class RawPokemonQuery implements RawQuery
{
    public function __invoke(): string
    {
        return 'GetPokemonQuery';
    }
}
