<?php

declare(strict_types=1);

namespace App\Services\GraphQL\Queries;

use App\Services\GraphQL\Contracts\Query as QueryContract;
use GraphQL\Query as GraphQLQuery;
use GraphQL\QueryBuilder\QueryBuilderInterface;

abstract class Query implements QueryContract
{
    abstract public function __invoke(): GraphQLQuery|QueryBuilderInterface;

    public function getQuery(): GraphQLQuery|QueryBuilderInterface
    {
        if ($this->__invoke() instanceof QueryBuilderInterface) {
            return $this->__invoke()->getQuery();
        }

        return $this->__invoke();
    }

    public function toGraphQuery(): string
    {
        if ($this->__invoke() instanceof QueryBuilderInterface) {
            return $this->__invoke()->getQuery()->__toString();
        }

        return $this->__invoke()->__toString();
    }
}
