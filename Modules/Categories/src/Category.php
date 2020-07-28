<?php

namespace Unite\UnisysApi\Modules\Categories;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Unite\UnisysApi\Modules\Properties\HasProperties;
use Unite\UnisysApi\Modules\Properties\Contracts\HasProperties as HasPropertiesContract;
use Unite\UnisysApi\Modules\Categories\Contracts\Category as CategoryContract;
use Unite\UnisysApi\QueryFilter\HasQueryFilter;
use Unite\UnisysApi\QueryFilter\HasQueryFilterInterface;

class Category extends Model implements CategoryContract, HasPropertiesContract, HasQueryFilterInterface
{
    use HasProperties;
    use HasQueryFilter;

    protected $fillable = [
        'name', 'group',
    ];

    public function scopeForGroups(Builder $query, ...$groups)
    : Builder
    {
        if (empty($groups)) {
            return $query;
        }

        if(is_array($groups[0])) {
            $groups = $groups[0];
        }

        return $query->whereIn('group', $groups);
    }

    public static function getForGroups($columns = ['*'], ... $groups)
    : Collection
    {
        return static::forGroups($groups)->orderBy('name')->get($columns);
    }
}
