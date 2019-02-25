<?php

namespace Unite\UnisysApi\QueryBuilder;

use Rebing\GraphQL\Support\Type as GraphQLType;

trait HasQueryFilter
{
    public function scopeFilter($query, $filterData = null, GraphQLType $graphQLType)
    {
        $filter = QueryFilter::createFilter($filterData);

        $query = new QueryFilter($query);
        $query->setFilter($filter);
        $query->setGraphQLType($graphQLType);
        $query->buildQuery();

        return $query;
    }
}