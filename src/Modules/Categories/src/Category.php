<?php

namespace Unite\UnisysApi\Modules\Categories;

use App\Modules\Categories\Services\CategoryService;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Unite\UnisysApi\Models\Model;
use Unite\UnisysApi\Modules\Properties\HasProperties;
use Unite\UnisysApi\Modules\Properties\Contracts\HasProperties as HasPropertiesContract;
use Unite\UnisysApi\Modules\Categories\Contracts\Category as CategoryContract;
use Unite\UnisysApi\Modules\Users\HasInstance;
use Unite\UnisysApi\Modules\Categories\Contracts\HasCategories;

class Category extends Model implements CategoryContract, HasPropertiesContract
{
    use HasProperties;
    use HasInstance;

    protected $fillable = [
        'name', 'group',
    ];

    public function scopeForGroups(Builder $query, ...$groups)
    : Builder
    {
        if (empty($groups)) {
            return $query;
        }

        return $query->where(function ($q) use ($groups) {
            foreach ($groups as $group) {
                $q->orWhere('group', '=', $group);
            }
        });
    }

    public static function getForGroups($columns = ['*'], ... $groups)
    : Collection
    {
        return static::forGroups($groups)->orderBy('name')->get($columns);
    }

    public static function createFor(HasCategories $parent, array $attributes)
    {
        return app(CategoryService::class)->createFor($parent, $attributes);
    }

    public static function deleteFor(HasCategories $parent, int $id)
    {
        return app(CategoryService::class)->deleteFor($parent, $id);
    }
}
