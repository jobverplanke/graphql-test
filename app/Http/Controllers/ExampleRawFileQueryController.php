<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Services\GraphQL\Client;
use App\Services\GraphQL\Queries\RawPokemonQuery;

class ExampleRawFileQueryController
{
    public function __construct(
        private readonly Client $client,
    ) {
        //
    }

    /**
     * call `runFromFile` directly on the client instance to resolve the raw query from a file of a string
     */
    public function methodOne(string $pokemon)
    {
        return $this->client->runFromFile(file: 'GetPokemonQuery', variables: ['pokemon' => $pokemon])->getData();
    }

    /**
     * call `runFromFile` directly on the client instance to resolve the raw query from a file of a class
     */
    public function methodTwo(string $pokemon, RawPokemonQuery $pokemonQuery)
    {
        return $this->client->runFromFile(file: $pokemonQuery, variables: ['pokemon' => $pokemon])->getData();
    }

    /**
     * call `run` and make sure the Query class implements the `raw` method returning the file with the raw query
     */
    public function methodThree(string $pokemon, RawPokemonQuery $pokemonQuery)
    {
        return $this->client->run(query: $pokemonQuery, variables: ['pokemon' => $pokemon])->getData();
    }

}
