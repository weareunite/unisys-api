<?php

namespace Unite\UnisysApi\QueryFilter;

use Illuminate\Database\Eloquent\Builder;

interface QueryFilterInterface
{
    public function filter(array $filter)
    : Builder;
}
