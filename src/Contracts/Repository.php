<?php

namespace Unite\UnisysApi\Contracts;

use Illuminate\Database\Eloquent\Builder;

interface Repository
{
    public function newQuery()
    : Builder;

    public function getTable()
    : string;
}