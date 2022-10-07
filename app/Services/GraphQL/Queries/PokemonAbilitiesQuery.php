<?php

declare(strict_types=1);

namespace App\Services\GraphQL\Queries;

use GraphQL\Query as GraphQLQuery;
use GraphQL\QueryBuilder\QueryBuilder;
use GraphQL\QueryBuilder\QueryBuilderInterface;

class PokemonAbilitiesQuery extends Query
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
