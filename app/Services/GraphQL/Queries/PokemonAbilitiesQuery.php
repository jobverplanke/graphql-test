<?php

declare(strict_types=1);

namespace App\Services\GraphQL\Queries;

use App\Services\GraphQL\Contracts\Query;
use GraphQL\Query as GraphQLQuery;
use GraphQL\QueryBuilder\QueryBuilder;
use GraphQL\QueryBuilder\QueryBuilderInterface;

class PokemonAbilitiesQuery implements Query
{
    public function __invoke(): GraphQLQuery|QueryBuilderInterface
    {
        $builder = new QueryBuilder(queryObject: 'abilities');

        return $builder
            ->selectField(selectedField: 'first')
            ->selectField(selectedField: 'second')
            ->selectField(selectedField: 'hidden');
    }
}
