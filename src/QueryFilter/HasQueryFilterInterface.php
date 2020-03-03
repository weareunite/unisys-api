<?php

namespace Unite\UnisysApi\QueryFilter;

interface HasQueryFilterInterface
{
    public function scopeFilter($query, $filter);

    public function newQueryFilter($query)
    : QueryFilterInterface;
}
