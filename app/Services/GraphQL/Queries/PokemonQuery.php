<?php

declare(strict_types=1);

namespace App\Services\GraphQL\Queries;

use GraphQL\Query as GraphQLQuery;
use GraphQL\QueryBuilder\QueryBuilder;
use GraphQL\QueryBuilder\QueryBuilderInterface;

class PokemonQuery extends Query
{
    public function __invoke(): GraphQLQuery|QueryBuilderInterface
    {
        $builder = new QueryBuilder(queryObject: 'getPokemon');

        $abilities = new PokemonAbilitiesQuery();

        return $builder
            ->setVariable(name: 'pokemon', type: 'PokemonEnum', isRequired: true)
            ->setArgument(argumentName: 'pokemon', argumentValue: '$pokemon')
            ->selectField(selectedField: 'num')
            ->selectField(selectedField: 'sprite')
            ->selectField(selectedField: 'bulbapediaPage')
            ->selectField(selectedField: 'serebiiPage')
            ->selectField(selectedField: $abilities->getQuery());
    }
}
