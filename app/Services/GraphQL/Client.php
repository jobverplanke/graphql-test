<?php

declare(strict_types=1);

namespace App\Services\GraphQL;

use App\Services\GraphQL\Contracts\Query as QueryContract;
use App\Services\GraphQL\Exceptions\MissingImplementationException;
use GraphQL\Client as GraphQLClient;
use GraphQL\Results;
use Illuminate\Support\Facades\Cache;

class Client
{
    private GraphQLClient $client;

    public function __construct()
    {
        $this->client = $this->client();
    }

    public function client(): GraphQLClient
    {
        return new GraphQLClient(
            endpointUrl: config(key: 'services.pokemon.url'),
        );
    }

    public function run(
        QueryContract $query,
        array $variables = [],
        bool $shouldCache = false,
        bool $asArray = true,
    ): Results|array {

        if (! $shouldCache) {
            return $this->client->runQuery(query: $query->getQuery(), resultsAsArray: $asArray, variables: $variables);
        }

        // Set hashed GraphQL query as cache key
        $key = md5(string: $query->toGraphQuery());
        $ttl = config(key: 'services.pokemon.ttl');

        return Cache::remember(
            $key,
            $ttl,
            fn () => $this->client->runQuery(query: $query->getQuery(), resultsAsArray: $asArray, variables: $variables)
        );
    }

    /**
     * @throws \App\Services\GraphQL\Exceptions\MissingImplementationException
     */
    public function runRaw()
    {
        throw MissingImplementationException::make(method: __METHOD__);
    }
}
