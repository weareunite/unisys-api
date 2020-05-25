<?php

namespace Unite\UnisysApi\Modules\Categories\Contracts;

use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;

interface Category
{
    public function scopeForGroups(Builder $query, ...$groups)
    : Builder;

    public static function getForGroups($columns = [ '*' ], ... $groups)
    : Collection;
}