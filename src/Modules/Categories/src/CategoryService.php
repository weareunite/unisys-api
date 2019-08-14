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

    public function update(int $id, array $attributes, ... $groups)
    {
        /** @var Category $category */
        if ($category = $this->model->where('id', '=', $id)->forGroups($groups)->first()) {
            $category->update($attributes);

            $category->handleProperties($attributes['properties'] ?? null);
        }
    }

    public function delete(int $id, ... $groups)
    {
        if (!$category = $this->model->where('id', '=', $id)->forGroups($groups)->first([ 'id' ])) {
            throw new CategoryDoesNotExistsException;
        }

        return $category->delete();
    }

    public function find(int $id, ... $groups)
    {
        /** @var Category $category */
        if (!$category = $this->model->where('id', '=', $id)->forGroups($groups)->first()) {
            throw new CategoryDoesNotExistsException;
        }

        return $category;
    }

    public function forGroups(... $groups)
    : Builder
    {
        return $this->model->forGroups($groups);
    }
}