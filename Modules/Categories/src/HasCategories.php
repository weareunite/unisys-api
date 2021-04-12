<?php

namespace Unite\UnisysApi\Modules\Categories;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

/**
 * @property-read \Illuminate\Database\Eloquent\Collection|\Unite\UnisysApi\Modules\Categories\Category[] $categories
 */
trait HasCategories
{
    protected $queuedCategories = [];

    protected $categoryGroup = null;

    public function categories()
    : MorphToMany
    {
        return $this
            ->morphToMany(
                Category::class,
                'model',
                'model_has_categories',
                'model_id',
                'category_id'
            )
            ->withPivot('id as pivot_id')
            ->using(CategoryPivot::class)
            ->orderBy('pivot_id');
    }

    public function getCategoryGroup()
    : string
    {
        if (!$this->categoryGroup) {
            return self::class;
        }

        return $this->categoryGroup;
    }

    public function getPotentialCategoryGroups()
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
        return app(CategoryService::class)->create($attributes, $this->getCategoryGroup());
    }

    public function updateCategory(int $id, $attributes)
    {
        return app(CategoryService::class)->update($id, $attributes, $this->getPotentialCategoryGroups());
    }

    public function deleteCategory(int $id)
    {
        return app(CategoryService::class)->delete($id, $this->getPotentialCategoryGroups());
    }

    public function availableCategories()
    : Builder
    {
        return app(CategoryService::class)->forGroups($this->getPotentialCategoryGroups());
    }

    public function scopeWithAllCategories(Builder $query, array $category_ids, string $group = null)
    : Builder
    {
        collect($category_ids)->each(function ($category_id) use ($query) {
            $query->whereHas('categories', function (Builder $query) use ($category_id) {
                return $query->where('categories.id', '=', $category_id);
            });
        });

        return $query;
    }

    public function scopeWithAnyCategories(Builder $query, array $category_ids, string $group = null)
    : Builder
    {
        return $query->whereHas('categories', function (Builder $query) use ($category_ids) {
            $query->whereIn('categories.id', '=', $category_ids);
        });
    }

    public function findByName(string $name, array $attributes = [ '*' ])
    : Category
    {
        return app(CategoryService::class)->findByName($name, $this->getPotentialCategoryGroups(), $attributes);
    }

    public function attachCategories(array $category_ids)
    {
        $this->categories()->syncWithoutDetaching($category_ids);

        return $this;
    }


    public function attachCategory($category)
    {
        $category_id = $this->detectCategoryId($category);

        return $this->attachCategories([ $category_id ]);
    }

    /**
     * @param array|\ArrayAccess $categories
     *
     * @return $this
     */
    public function detachCategories(array $category_ids)
    {
        $this->categories()->detach($category_ids);

        return $this;
    }

    protected function detectCategoryId($category)
    {
        if (is_string($category)) {
            $category_id = $this->findByName($category, [ 'id' ])->id;
        } else {
            $category_id = $category;
        }

        return $category_id;
    }

    public function detachCategory($category)
    {
        $category_id = $this->detectCategoryId($category);

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
    public function syncCategories(array $category_ids)
    {
        $this->categories()->sync($category_ids);

        return $this;
    }

    public function syncCategoriesByNames(array $category_names)
    {
        $category_ids = app(CategoryService::class)->convertNamesToIds($category_names, $this->getPotentialCategoryGroups());

        $this->syncCategories($category_ids);
    }

    protected function syncCategoryIds($ids, string $group = null, $detaching = true)
    {
        $isUpdated = false;

        // Get a list of category_ids for all current categories
        $current = $this->categories()
            ->newPivotStatement()
            ->where('model_id', $this->getKey())
            ->when($group !== null, function ($query) use ($group) {
                $categoryModel = $this->categories()->getRelated();

                return $query->join(
                    $categoryModel->getTable(),
                    'model_has_categories.category_id',
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
