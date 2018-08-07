<?php

namespace Unite\UnisysApi\Repositories;

use Closure;
use Illuminate\Container\Container;
use Illuminate\Database\Eloquent\Builder as EloquentBuilder;
use Illuminate\Database\Query\Builder as QueryBuilder;
use Unite\UnisysApi\Services\CacheService;
use Unite\UnisysApi\Services\RequestQueryBuilder\RequestQueryBuilderService;

abstract class Repository implements RepositoryInterface
{
    /**
     * @var EloquentBuilder|QueryBuilder;
     */
    protected $model;

    protected $cacheService;

    protected $modelClass;

    protected $cache = false;

    protected $cacheKey;

    protected $cacheTags = [];

    protected $resourceRelations = [];

    protected $resourceLocalMap = [];

    public function __construct(Container $app, CacheService $cacheService)
    {
        if (!class_exists($this->modelClass)) {
            $this->loadModelClass();
        }

        $this->model = $app->make($this->modelClass);

        $this->cacheService = $cacheService;
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

    protected function handleQueryCache(Closure $callback)
    {
        if($this->cache !== true) {
            return $callback();
        }

        return $this->cacheService->remember($this->cacheKey, function () use($callback) {
            return $callback();
        }, $this->cacheTags);
    }

    protected function setCacheKey($name, ... $attributes)
    {
        $identifier = '';

        foreach($attributes as $attr) {
            $identifier .= '.' . $attr;
        }

        $this->cacheKey = $this->cacheService->makeKey($name . $identifier);

        return $this;
    }

    public function cache(bool $enableCache = true, array $tags = [])
    {
        $this->cache = $enableCache;
        $this->cacheTags = $tags;

        return $this;
    }

    public function makeBasicCacheTag(... $attributes)
    {
        $this->addCacheTag($attributes);
        $this->addCacheTag([$this->modelClass]);

        return $this;
    }

    public function addCacheTag(array $attributes)
    {
        $identifier = '';

        if(is_array($attributes) && count($attributes) > 1) {
            foreach($attributes as $attr) {
                $identifier .= '.' . $attr;
            }
        }

        $key = $this->modelClass . $identifier;

        if(!in_array($key, $this->cacheTags)) {
            array_push($this->cacheTags, $key);
        }

        return $this;
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
        $this->setCacheKey(__METHOD__, $id);
        $this->makeBasicCacheTag($id);

        return $this->handleQueryCache(function () use ($id, $columns) {
            return $this->model->find($id, $columns);
        });
    }

    public function create(array $attributes = [])
    {
        $result = $this->model->create($attributes);

        $this->cacheService->flushByTags([$this->modelClass]);

        return $result;
    }

    public function forceCreate(array $attributes = [])
    {
        $result = $this->model->forceCreate($attributes);

        $this->cacheService->flushByTags([$this->modelClass]);

        return $result;
    }

    public function update(array $values)
    {
        $result = $this->model->update($values);

        $this->cacheService->flushByTags([$this->modelClass]);

        return $result;
    }

    public function updateForId($id, array $values)
    {
        $result = $this->model->where('id', '=', $id)->update($values);

        $this->cacheService->flushByTags([$this->modelClass]);

        return $result;
    }

    public function delete($id)
    {
        $result = $this->model->destroy($id);

        $this->cacheService->flushByTags([$this->modelClass]);

        return $result;
    }

    public function massDelete(array $ids)
    {
        $result = null;

        foreach ($ids as $id) {
            $result = $this->model->destroy($id);
        }

        $this->cacheService->flushByTags([$this->modelClass]);

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
        $this->setCacheKey(__METHOD__);
        $this->makeBasicCacheTag();

        return $this->handleQueryCache(function () use ($columns) {
            return $this->model->get($columns);
        });
    }

    public function paginate($perPage = null, $columns = ['*'], $pageName = 'page', $page = null)
    {
        $this->setCacheKey(__METHOD__);
        $this->makeBasicCacheTag();

        return $this->handleQueryCache(function () use ($perPage, $columns, $pageName, $page) {
            return $this->model->paginate($perPage, $columns, $pageName, $page);
        });
    }

    public function with($relations)
    {
        $this->model = $this->model->with($relations);

        return $this;
    }

    public function filterByRequest( array $requestData )
    {
        return app(RequestQueryBuilderService::class)
            ->init($requestData)
            ->setRepository($this)
            ->paginate();
    }

    /**
     * @return array
     */
    public function getResourceRelations(): array
    {
        return $this->resourceRelations;
    }

    /**
     * @param string $value
     * @return $this
     */
    public function addResourceRelation(string $value)
    {
        if(!in_array($value, $this->resourceRelations)) {
            $this->resourceRelations[] = $value;
        }

        return $this;
    }

    /**
     * @param array $relations
     * @return $this
     */
    public function addResourceRelations(array $relations)
    {
        foreach ($relations as $relation) {
            $this->addResourceRelation($relation);
        }

        return $this;
    }

    /**
     * @return array
     */
    public function getResourceLocalMap(): array
    {
        return $this->resourceLocalMap;
    }

    /**
     * @param string $base
     * @param string $target
     * @param bool $rewrite
     * @return $this
     */
    public function addResourceMap(string $base, string $target, bool $rewrite = true)
    {
        if(isset($this->resourceLocalMap[$base]) && $rewrite === false) {
            return $this;
        }

        $this->resourceLocalMap[$base] = $target;

        return $this;
    }

    /**
     * @param array $map
     * @return $this
     */
    public function addResourceMaps(array $map)
    {
        foreach ($map as $base => $target) {
            $this->addResourceMap($base, $target);
        }

        return $this;
    }
}