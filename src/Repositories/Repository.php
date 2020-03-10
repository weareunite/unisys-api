<?php

namespace Unite\UnisysApi\Repositories;

use Illuminate\Container\Container;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Unite\UnisysApi\Contracts\Repository as RepositoryContract;

abstract class Repository implements RepositoryContract
{
    /** @var Builder */
    protected $query;

    /** @var string */
    protected $modelClass;

    /** @var Model */
    protected $model;

    /**
     * Repository constructor.
     * @param Container $app
     * @throws BindingResolutionException
     */
    public function __construct(Container $app)
    {
        $this->model = $app->make($this->modelClass);
    }

    public function getModelClass()
    : string
    {
        return $this->modelClass;
    }

    public function newQuery()
    : Builder
    {
        return $this->query = $this->model->newQuery();
    }

    public function getTable()
    : string
    {
        return $this->model->getTable();
    }
}