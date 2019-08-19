<?php

namespace Unite\UnisysApi\Modules\Categories\Contracts;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

interface HasCategories
{
    public function categories()
    : MorphToMany;

    public function getCategoryGroup()
    : string;

    public function getPotentialCategoryGroups()
    : array;

    public function createCategory(array $attributes);

    public function deleteCategory(int $id);

    public function updateCategory(int $id, $attributes);

    public function availableCategories();

    public function scopeWithAllCategories(Builder $query, array $category_ids, string $group = null)
    : Builder;

    public function scopeWithAnyCategories(Builder $query, array $category_ids, string $group = null)
    : Builder;

    public function findByName(string $name)
    : Category;

    public function attachCategories(array $category_ids);

    public function attachCategory($category);

    public function detachCategories(array $category_ids);

    public function detachCategory($category);

    public function detachAllCategories();

    public function syncCategories(array $category_ids);

    public function syncCategoriesByNames(array $category_names);
}
