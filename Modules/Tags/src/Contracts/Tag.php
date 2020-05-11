<?php

namespace Unite\UnisysApi\Modules\Tags\Contracts;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;

interface Tag
{
    public function scopeWithType(Builder $query, string $type = null): Builder;

    public static function getWithType(string $type): Collection;

    public static function findOrCreate($values, string $type = null);

    public static function findFromString(string $name, string $type = null);
}
