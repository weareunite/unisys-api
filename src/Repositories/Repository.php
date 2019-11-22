<?php

namespace Unite\UnisysApi\Repositories;

use Illuminate\Container\Container;
use Illuminate\Database\Eloquent\Builder as EloquentBuilder;
use Illuminate\Database\Query\Builder as QueryBuilder;
use Unite\UnisysApi\Contracts\Repository as RepositoryContract;
use Unite\UnisysApi\Models\Model;

abstract class Repository implements RepositoryContract
{
    /**
     * @var Model;
     */
    protected $model;

    protected $modelClass;

    public function __construct(Container $app)
    {
        if (!class_exists($this->modelClass)) {
            $this->loadModelClass();
        }

        $this->model = $app->make($this->modelClass);
    }

    protected function loadModelClass()
    {
        list ($class) = array_slice(array_reverse(explode('\\', get_called_class())), 0, 2);

        $class = str_replace('Repository', '', $class);

        $this->setModelClass('App\\Models\\' . $class);

        return $this;
    }

    protected function setModelClass($class)
    {
        $this->modelClass = $class;

        return $this;
    }

    public function getModelClass(): string
    {
        return $this->modelClass;
    }

    /**
     * Provides QueryBuilder
     *
     * @return EloquentBuilder|QueryBuilder
     */
    public function getQueryBuilder()
    {
        return $this->model;
    }

    public function getTable()
    {
        return $this->model->getModel()->getTable();
    }

    public function find($id, $columns = ['*'])
    {
        return $this->model->find($id, $columns);
    }

    public function create(array $attributes = [])
    {
        $result = $this->model->create($attributes);

        return $result;
    }

    public function forceCreate(array $attributes = [])
    {
        $result = $this->model->forceCreate($attributes);

        return $result;
    }

    public function update(array $values)
    {
        $result = $this->model->update($values);

        return $result;
    }

    public function updateForId($id, array $values)
    {
        $result = $this->model->where('id', '=', $id)->update($values);

        return $result;
    }

    public function delete($id)
    {
        $result = $this->model->destroy($id);

        return $result;
    }

    public function massDelete(array $ids)
    {
        $result = null;

        foreach ($ids as $id) {
            $result = $this->model->destroy($id);
        }

        return $result;
    }

    public function join($table, $first, $operator = null, $second = null, $type = 'inner', $where = false)
    {
        return $this->model->join($table, $first, $operator, $second, $type, $where);
    }

    public function where($column, $operator = null, $value = null, $boolean = 'and')
    {
        return $this->model->where($column, $operator, $value, $boolean);
    }

    public function orWhere($column, $operator = null, $value = null)
    {
        return $this->model->orWhere($column, $operator, $value);
    }

    public function get($columns = ['*'])
    {
        return $this->model->get($columns);
    }

    public function paginate($perPage = null, $columns = ['*'], $pageName = 'page', $page = null)
    {
        return $this->model->paginate($perPage, $columns, $pageName, $page);
    }

    public function with($relations)
    {
        $this->model = $this->model->with($relations);

        return $this;
    }
}