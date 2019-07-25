<?php

namespace Unite\UnisysApi\Modules\Categories;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

/**
 * @property-read \Illuminate\Database\Eloquent\Collection|\Unite\UnisysApi\Modules\Categories\Category[] $categories
 */
trait HasCategories
{
    protected $queuedCategories = [];

    protected $categoryGroup = null;

    protected function getCategoryGroup()
    : ?string
    {
        if (!$this->categoryGroup) {
            return self::class;
        }

        return $this->categoryGroup;
    }

    protected function getPotentialCategoryGroups()
    : array
    {
        $potentialGroups[] = self::class;

        if ($this->categoryGroup) {
            $potentialGroups[] = $this->categoryGroup;
        }

        return $potentialGroups;
    }

    public function createCategory(array $attributes)
    {
        /** @var Category $category */
        return Category::createFor($this, $attributes);
    }

    public function deleteCategory(int $id)
    {
        return Category::deleteFor($this, $id);
    }

    public function updateCategory(int $id, $attributes)
    {
        /** @var Category $category */
        if ($category = Category::where('id', '=', $id)->forGroups($this->getPotentialCategoryGroups())->first()) {
            $category->update($attributes);

            if ($attributes['properties']) {
                foreach ($attributes['properties'] as $property) {
                    $category->addOrUpdateProperty($property['key'], $property['value']);
                }
            }
        }
    }

    public function categories()
    : MorphToMany
    {
        return $this
            ->morphToMany(Category::class, 'categoryable')
            ->withPivot('id as pivot_id')
            ->orderBy('pivot_id');
    }

    public function availableCategories()
    : Builder
    {
        return Category::forGroups($this->getPotentialCategoryGroups());
    }

    public function scopeWithAllCategories(Builder $query, $categories, string $group = null)
    : Builder
    {
        $categories = static::convertToCategories($categories, $group);

        collect($categories)->each(function ($category) use ($query) {
            $query->whereHas('categories', function (Builder $query) use ($category) {
                return $query->where('id', $category ? $category->id : 0);
            });
        });

        return $query;
    }

    public function scopeWithAnyCategories(Builder $query, $categories, string $group = null)
    : Builder
    {
        $categories = static::convertToCategories($categories, $group);

        return $query->whereHas('categories', function (Builder $query) use ($categories) {
            $categoryIds = collect($categories)->pluck('id');

            $query->whereIn('id', $categoryIds);
        });
    }

    public function attachCategories(...$category_ids)
    {
        $this->categories()->syncWithoutDetaching($category_ids);

        return $this;
    }


    public function attachCategory(int $category_id)
    {
        return $this->attachCategories([ $category_id ]);
    }

    /**
     * @param array|\ArrayAccess $categories
     *
     * @return $this
     */
    public function detachCategories(...$category_ids)
    {
        $this->categories()->detach($category_ids);

        return $this;
    }

    public function detachCategory(int $category_id)
    {
        return $this->detachCategories([ $category_id ]);
    }

    /**
     * @return $this
     */
    public function detachAllCategories()
    {
        $this->categories()->sync([]);

        return $this;
    }

    /**
     * @param array|\ArrayAccess $categories
     *
     * @return $this
     */
    public function syncCategories(... $category_ids)
    {
        $this->categories()->sync($category_ids);

        return $this;
    }

    protected function syncCategoryIds($ids, string $group = null, $detaching = true)
    {
        $isUpdated = false;

        // Get a list of category_ids for all current categories
        $current = $this->categories()
            ->newPivotStatement()
            ->where('categoryable_id', $this->getKey())
            ->when($group !== null, function ($query) use ($group) {
                $categoryModel = $this->categories()->getRelated();

                return $query->join(
                    $categoryModel->getTable(),
                    'categoryables.category_id',
                    '=',
                    $categoryModel->getTable() . '.' . $categoryModel->getKeyName()
                )
                    ->where('categories.group', $group);
            })
            ->pluck('category_id')
            ->all();

        // Compare to the list of ids given to find the categories to remove
        $detach = array_diff($current, $ids);
        if ($detaching && count($detach) > 0) {
            $this->categories()->detach($detach);
            $isUpdated = true;
        }

        // Attach any new ids
        $attach = array_diff($ids, $current);
        if (count($attach) > 0) {
            collect($attach)->each(function ($id) {
                $this->categories()->attach($id, []);
            });
            $isUpdated = true;
        }

        // Once we have finished attaching or detaching the records, we will see if we
        // have done any attaching or detaching, and if we have we will touch these
        // relationships if they are configured to touch on any database updates.
        if ($isUpdated) {
            $this->categories()->touchIfTouching();
        }
    }
}
