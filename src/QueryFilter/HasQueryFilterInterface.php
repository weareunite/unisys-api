<?php

namespace Unite\UnisysApi\QueryFilter;

use Illuminate\Database\Eloquent\Builder;

/**
 * @method Builder filter($filter)
 */
interface HasQueryFilterInterface
{
    public function scopeFilter($query, $filter);

    public function newQueryFilter($query)
    : QueryFilterInterface;
}
