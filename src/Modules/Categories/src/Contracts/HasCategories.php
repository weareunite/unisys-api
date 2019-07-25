<?php

namespace Unite\UnisysApi\Modules\Categories\Contracts;

use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Builder;

interface HasCategories
{
    public function categories(): MorphMany;

    public function createCategory(array $attributes);

    public function deleteCategory(int $id);

    public function updateCategory(int $id, $attributes);

    public function availableCategories();

    public function scopeWithAllCategories(Builder $query, $categories, string $group = null);

    public function scopeWithAnyCategories(Builder $query, $categories, string $group = null);

    public function attachCategories(...$category_ids);

    public function attachCategory(int $category_id);

    public function detachCategories(...$category_ids);

    public function detachCategory(int $category_id);

    public function detachAllCategories();

    public function syncCategories(... $category_ids);
}
