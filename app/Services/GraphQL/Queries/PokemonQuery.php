<?php

declare(strict_types=1);

namespace App\Services\GraphQL\Queries;

use App\Services\GraphQL\Contracts\Query;
use GraphQL\Query as GraphQLQuery;
use GraphQL\QueryBuilder\QueryBuilder;
use GraphQL\QueryBuilder\QueryBuilderInterface;

class PokemonQuery implements Query
{
    public function __invoke(): GraphQLQuery|QueryBuilderInterface
    {
        $builder = new QueryBuilder(queryObject: 'getPokemon');

        $abilities = new PokemonAbilitiesQuery();

        return $builder
            ->setVariable(name: 'pokemon', type: 'PokemonEnum', isRequired: true)
            ->setArgument(argumentName: 'pokemon', argumentValue: '$pokemon')
            ->selectField(selectedField: 'num')
            ->selectField(selectedField: 'types')
            ->selectField(selectedField: 'sprite')
            ->selectField(selectedField: $abilities()->getQuery())
            ->selectField(selectedField: 'serebiiPage')
            ->selectField(selectedField: 'bulbapediaPage');
    }
}
