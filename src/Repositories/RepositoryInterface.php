<?php

namespace Unite\UnisysApi\Repositories;

use Illuminate\Database\Eloquent\Builder as EloquentBuilder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Query\Builder as QueryBuilder;

interface RepositoryInterface
{
    /**
     * Provides QueryBuilder
     *
     * @return Model|EloquentBuilder|QueryBuilder
     */
    public function getQueryBuilder();

    public function find($id, $columns = ['*']);

    public function create(array $attributes = []);

    public function update(array $values);

    public function delete($id);

}