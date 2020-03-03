<?php

namespace Unite\UnisysApi\QueryFilter;

interface HasQueryFilterInterface
{
    public function scopeFilter($query, $condition = null);

    public function newQueryFilter($query)
    : QueryFilterInterface;
}
