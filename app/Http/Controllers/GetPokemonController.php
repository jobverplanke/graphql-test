<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Services\GraphQL\Client;
use App\Services\GraphQL\Queries\PokemonQuery;

class GetPokemonController
{
    public function __construct(
        private readonly Client $client,
    ) {
    }

    public function __invoke(string $pokemon, PokemonQuery $pokemonQuery): object|array
    {
        return $this->client->run(query: $pokemonQuery, variables: ['pokemon' => $pokemon])->getData();
    }
}
