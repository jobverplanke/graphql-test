<?php

declare(strict_types=1);

namespace App\Services\GraphQL\Contracts;

use GraphQL\Query as GraphQLQuery;
use GraphQL\QueryBuilder\QueryBuilderInterface;

interface Query
{
    public function __invoke(): GraphQLQuery|QueryBuilderInterface;
}
