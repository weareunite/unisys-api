<?php

namespace Unite\UnisysApi\Modules\Tags;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Unite\UnisysApi\Helpers\CustomProperty\HasCustomProperty;
use Unite\UnisysApi\Helpers\CustomProperty\HasCustomPropertyTrait;
use Unite\UnisysApi\Models\Model;
use Unite\UnisysApi\Modules\Tags\Contracts\Tag as TagContract;

class Tag extends Model implements HasCustomProperty, TagContract
{
    use HasCustomPropertyTrait;

    protected $fillable = [
        'name', 'type', 'custom_properties'
    ];

    protected $casts = [
        'custom_properties' => 'array',
    ];

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
