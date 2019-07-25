<?php

namespace App\Modules\Categories\Services;

use Unite\UnisysApi\Modules\Categories\Category;
use Unite\UnisysApi\Modules\Categories\Contracts\HasCategories;
use Unite\UnisysApi\Services\Service;
use DB;

class CategoryService extends Service
{
    protected $model;

    public function __construct(Category $model)
    {
        $this->model = $model;
    }

    public function createFor(HasCategories $parent, array $attributes = [])
    {
        DB::beginTransaction();

        try {
            /** @var Category $model */
            $model = $this->model->newInstance(
                array_merge(
                    $attributes,
                    [
                        'group' => $parent->getCategoryGroup(),
                    ])
            );
            $model->save();

            $model->handleProperties($attributes['properties'] ?? null);

            DB::commit();
        } catch (\Exception $ex) {
            DB::rollback();

            throw $ex;
        }

        return $model;
    }

    public function deleteFor(HasCategories $parent, int $id)
    {
        if (!$category = $this->model->where('id', '=', $id)->forGroups($parent->getPotentialCategoryGroups())->first([ 'id' ])) {

        }

        return $category->delete();
    }

    public function updateFor(HasCategories $parent, int $id, $attributes)
    {
        /** @var Category $category */
        if ($category = $this->model->where('id', '=', $id)->forGroups($parent->getPotentialCategoryGroups())->first()) {
            $category->update($attributes);

            $category->handleProperties($attributes['properties'] ?? null);
        }
    }
}