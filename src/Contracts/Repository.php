<?php

namespace Unite\UnisysApi\Contracts;

use Illuminate\Database\Eloquent\Builder as EloquentBuilder;
use Unite\UnisysApi\Models\Model;
use Illuminate\Database\Query\Builder as QueryBuilder;

interface Repository
{
    /**
     * Provides QueryBuilder
     *
     * @return Model|EloquentBuilder|QueryBuilder
     */
    public function getQueryBuilder();

    public function find($id, $columns = ['*']);

    public function get($columns = ['*']);

    public function paginate($perPage = null, $columns = ['*'], $pageName = 'page', $page = null);

    public function with($relations);

    public function create(array $attributes = []);

    public function forceCreate(array $attributes = []);

    public function updateForId($id, array $values);

    public function update(array $values);

    public function delete($id);

    public function massDelete(array $ids);

    public function getTable();
}