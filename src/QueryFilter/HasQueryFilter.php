<?php

namespace Unite\UnisysApi\QueryFilter;

trait HasQueryFilter
{
    public function scopeFilter($query, $filter)
    {
        $queryFilter = $this->newQueryFilter($query);
        $queryFilter->setModel($this);

        return $queryFilter->filter($filter['conditions']);
    }

    public function newQueryFilter($query)
    : QueryFilterInterface
    {
        return new QueryFilter($query);
    }
}
