<?php

namespace Unite\UnisysApi\QueryFilter;

interface QueryFilterInterface
{
    public function filterCondition(array $condition);

    public function filterSearch(array $search);
}
