<?php

namespace Unite\UnisysApi\Modules\Tags;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Unite\UnisysApi\Modules\Properties\Contracts\HasProperties as HasPropertiesContract;
use Unite\UnisysApi\Modules\Properties\HasProperties;
use Unite\UnisysApi\Modules\Tags\Contracts\Tag as TagContract;
use Unite\UnisysApi\QueryFilter\HasQueryFilter;
use Unite\UnisysApi\QueryFilter\HasQueryFilterInterface;

class Tag extends Model implements TagContract, HasQueryFilterInterface, HasPropertiesContract
{
    use HasQueryFilter;
    use HasProperties;

    protected $fillable = [
        'name', 'type',
    ];

    protected $casts = [
    ];

    protected $with = ['properties'];

    public function scopeWithType(Builder $query, string $type = null): Builder
    {
        if (is_null($type)) {
            return $query;
        }

        return $query->where('type', $type);
    }

    public static function getWithType(string $type): Collection
    {
        return static::withType($type)->orderBy('name')->get();
    }

    public static function findOrCreate($values, string $type = null)
    {
        $tags = collect($values)->map(function ($value) use ($type) {
            if ($value instanceof Tag) {
                return $value;
            }
            return static::findOrCreateFromString($value, $type);
        });

        return is_string($values) ? $tags->first() : $tags;
    }

    protected static function findOrCreateFromString(string $name, string $type = null): Tag
    {
        $tag = static::findFromString($name, $type);
        if (! $tag) {
            $tag = static::create([
                'name' => $name,
                'type' => $type,
            ]);
        }
        return $tag;
    }

    public static function findFromString(string $name, string $type = null)
    {
        return static::query()
            ->where('name', $name)
            ->where('type', $type)
            ->first();
    }
}
