<?php

namespace Unite\UnisysApi\Modules\Categories;

use Illuminate\Database\Eloquent\Builder;
use Unite\UnisysApi\Modules\Categories\Exceptions\CategoryDoesNotExistsException;
use Unite\UnisysApi\Services\Service;
use DB;

class CategoryService extends Service
{
    protected $model;

    public function __construct(Category $model)
    {
        $this->model = $model;
    }

    public function create(array $attributes, string $group)
    {
        DB::beginTransaction();

        try {
            /** @var Category $model */
            $model = $this->model->newInstance(
                array_merge(
                    $attributes,
                    [
                        'group' => $group,
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

    public function update(int $id, array $attributes, array $groups)
    {
        /** @var Category $category */
        if ($category = $this->model->where('id', '=', $id)->forGroups($groups)->first()) {
            $category->update($attributes);

            $category->handleProperties($attributes['properties'] ?? null);
        }
    }

    public function delete(int $id, array $groups)
    {
        if (!$category = $this->model->where('id', '=', $id)->forGroups($groups)->first([ 'id' ])) {
            throw new CategoryDoesNotExistsException;
        }

        return $category->delete();
    }

    public function find(int $id, array $groups)
    : Category
    {
        /** @var Category $category */
        if (!$category = $this->model->where('id', '=', $id)->forGroups($groups)->first()) {
            throw new CategoryDoesNotExistsException;
        }

        return $category;
    }

    public function findByName(string $name, array $groups, array $attributes = ['*'])
    : Category
    {
        /** @var Category $category */
        if (!$category = $this->model->where('name', '=', $name)->forGroups($groups)->first($attributes)) {
            throw new CategoryDoesNotExistsException;
        }

        return $category;
    }

    public function convertNamesToIds(array $names, array $groups)
    {
        return $this->model
            ->whereIn('name', $names)
            ->forGroups($groups)
            ->select('id')
            ->pluck('id');
    }

    public function forGroups(array $groups)
    : Builder
    {
        return $this->model->forGroups($groups);
    }
}