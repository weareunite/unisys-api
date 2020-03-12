<?php

namespace Unite\UnisysApi\QueryFilter;

use Illuminate\Database\Eloquent\Builder;

/**
 * @method Builder filter($filter)
 */
trait HasQueryFilter
{
    public function scopeFilter($query, $filter)
    {
        $queryFilter = $this->newQueryFilter($query);
        $queryFilter->setModel($this);

        return $queryFilter->filter($filter);
    }

    public function newQueryFilter($query)
    : QueryFilterInterface
    {
        return new QueryFilter($query);
    }
}
