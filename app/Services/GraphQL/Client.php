<?php

declare(strict_types=1);

namespace App\Services\GraphQL;

use App\Services\GraphQL\Contracts\Query;
use App\Services\GraphQL\Contracts\RawQuery;
use App\Services\GraphQL\Exceptions\InvalidQueryException;
use App\Services\GraphQL\Exceptions\RawQueryFileNotFoundException;
use GraphQL\Client as GraphQLClient;
use GraphQL\Query as GraphQLQuery;
use GraphQL\Results;
use Illuminate\Support\Facades\Cache;

class Client
{
    public array $paths;

    public function __construct(
        private GraphQLClient|null $client = null,
    )
    {
        $this->client = $client ?? new GraphQLClient(
            endpointUrl: config(key: 'services.graphql.url'),
        );

        $this->paths = array_map(callback: [$this, 'resolvePath'], array: config(key: 'services.graphql.paths'));
    }

    /**
     * @throws \App\Services\GraphQL\Exceptions\InvalidQueryException
     * @throws \App\Services\GraphQL\Exceptions\RawQueryFileNotFoundException
     */
    public function run(
        Query|RawQuery $query,
        array $variables = [],
        bool $shouldCache = false,
        bool $asArray = true,
    ): Results {

        if ($query instanceof RawQuery) {
            return $this->runFromFile(file: $query, variables: $variables, shouldCache: $shouldCache, asArray: $asArray);
        }

        if (! $shouldCache) {
            return $this->client->runQuery(query: $query()->getQuery(), resultsAsArray: $asArray, variables: $variables);
        }

        return $this->cache(query: $query, asArray: $asArray, variables: $variables);
    }

    /**
     * @throws \App\Services\GraphQL\Exceptions\RawQueryFileNotFoundException
     * @throws \App\Services\GraphQL\Exceptions\InvalidQueryException
     */
    public function runFromFile(
        RawQuery|string $file,
        array $variables = [],
        bool $shouldCache = false,
        bool $asArray = true,
    ): Results {

        $query = ($file instanceof RawQuery)
            ? $this->resolveQueryFromFile(file: $file())
            : $this->resolveQueryFromFile(file: $file);

        if (! $shouldCache) {
            return $this->client->runRawQuery(queryString: $query, resultsAsArray: $asArray, variables: $variables);
        }

        return $this->cache(query: $file, asArray: $asArray, variables: $variables);
    }

    public function toGql(Query|RawQuery $query): string
    {
        return ($query() instanceof GraphQLQuery)
            ? $query()->__toString()
            : $query()->getQuery()->__toString();
    }

    private function cache(Query|RawQuery $query, bool $asArray, array $variables)
    {
        $queryString = $this->toGql(query: $query);

        $key = md5(string: $queryString);
        $ttl = config(key: 'services.graphql.ttl');

        return Cache::remember($key, $ttl,
            fn () => $this->client->runRawQuery(queryString: $queryString, resultsAsArray: $asArray, variables: $variables),
        );
    }

    /**
     * @throws \App\Services\GraphQL\Exceptions\InvalidQueryException
     * @throws \App\Services\GraphQL\Exceptions\RawQueryFileNotFoundException
     */
    private function resolveQueryFromFile(string $file): string
    {
        if (! $query = file_get_contents(filename: $this->findInPaths(file: $file, paths: $this->paths))) {
            throw InvalidQueryException::make();
        }

        return $query;
    }

    /**
     * @throws \App\Services\GraphQL\Exceptions\RawQueryFileNotFoundException
     */
    private function findInPaths($file, $paths): string
    {
        if ($file === '') {
            throw RawQueryFileNotFoundException::make(file: $file);
        }

        foreach ($paths as $path) {
            if (file_exists(filename: $query = $path . '/' . $file)) {
                return $query;
            }
        }

        throw RawQueryFileNotFoundException::make(file: $file);
    }

    private function resolvePath(string $path): bool|string
    {
        return realpath(path: $path) ?: $path;
    }
}
