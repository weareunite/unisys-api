<?php

namespace Unite\UnisysApi\Modules\Tags\Contracts;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

interface HasTags
{
    public static function getTagClassName();

    public function tags(): MorphToMany;

    public function setTagsAttribute($tags);

    public function scopeWithAllTags(Builder $query, $tags, string $type = null): Builder;

    public function scopeWithAnyTags(Builder $query, $tags, string $type = null): Builder;

    public function tagsWithType(string $type = null): Collection;

    public function attachTags($tags);

    public function attachTag($tag);

    public function detachTags($tags);

    public function detachTag($tag);

    public function detachAllTags();

    public function syncTags($tags);

    public function syncTagsWithType($tags, string $type = null);
}
