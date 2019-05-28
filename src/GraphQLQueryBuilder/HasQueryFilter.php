<?php

namespace Unite\UnisysApi\GraphQLQueryBuilder;

use Rebing\GraphQL\Support\Type as GraphQLType;

trait HasQueryFilter
{
    public function scopeFilter($query, $filterData = null, GraphQLType $graphQLType)
    {
        $filter = QueryFilter::createFilter($filterData);

        $qf = new QueryFilter($query);
        $qf->setFilter($filter);
        $qf->setGraphQLType($graphQLType);
        $qf->buildQuery();

        return $qf->getBuilder();
    }
}