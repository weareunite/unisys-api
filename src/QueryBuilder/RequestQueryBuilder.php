<?php

namespace Unite\UnisysApi\QueryBuilder;

use Closure;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Unite\UnisysApi\Models\Model;
use Unite\UnisysApi\QueryBuilder\Parsers\ConditionsParser;
use Unite\UnisysApi\QueryBuilder\Parsers\LimitParser;
use Unite\UnisysApi\QueryBuilder\Parsers\OrderParser;
use Unite\UnisysApi\QueryBuilder\Parsers\PageParser;
use Unite\UnisysApi\QueryBuilder\Parsers\SearchParser;
use Unite\UnisysApi\QueryBuilder\Types\Column;
use Unite\UnisysApi\QueryBuilder\Types\Condition;
use Unite\UnisysApi\QueryBuilder\Types\Join;
use Unite\UnisysApi\QueryBuilder\Types\OrderBy;
use Unite\UnisysApi\QueryBuilder\Types\Search;

class RequestQueryBuilder
{
    /** @var \Illuminate\Database\Eloquent\Builder */
    protected $builder;

    /** @var \Illuminate\Http\Request */
    protected $request;

    /** @var integer */
    protected $limit;

    /** @var integer */
    protected $page;

    /** @var OrderBy */
    protected $orderBy;

    /** @var Search|null */
    protected $search;

    /** @var Collection|Condition[] */
    protected $filters;

    /** @var Collection|Join[] */
    protected $joins;

    /** @var string */
    public $baseTable;

    /** @var Model */
    public $baseModel;

    /** @var string */
    public $modelClass;

    /** @var \Unite\UnisysApi\Http\Resources\Resource */
    public $resourceClass;

    /** @var JoinResolver */
    public $joinResolver;

    /** @var array */
    public $virtualFields;

    public function __construct(Builder $builder, ? Request $request = null)
    {
        $this->builder = $builder;

        $this->initializeFromBuilder($builder);

        $this->request = $request ?? request();
    }

    public function getBuilder()
    {
        return $this->builder;
    }

    protected static function availableRequestKeys()
    {
        return collect([
            'limit', 'order', 'page', 'search', 'filter'
        ]);
    }

    protected function data()
    {
        $data = [];

        $this->availableRequestKeys()->each(function ($key) use (&$data) {
            $data[$key] = $this->request->query($key);
        });

        return $data;
    }

    protected function parseRequest()
    {
        $requestData = $this->data();

        $this->limit = (new LimitParser($this))->parse($requestData['limit']);
        $this->orderBy = (new OrderParser($this))->parse($requestData['order']);
        $this->page = (new PageParser($this))->parse($requestData['page']);
        $this->search = (new SearchParser($this))->parse($requestData['search']);
        $this->filters = (new ConditionsParser($this))->parse($requestData['conditions']);
    }

    public function computeColumn(string $column)
    {
        $this->resolveColumn($column);

        return $this;
    }

    public function resolveColumn(string $column)
    {
        $column = new Column($column, $this->baseTable, $this->resourceClass::tableTrough()->toArray());

        if($column->needJoin) {
            $this->joinResolver->addColumn($column);
        }

        return $column;
    }

    public function resolveJoins()
    {
        $this->joinResolver->makeJoins();

        return $this->joinResolver->getJoins();
    }

    /**
     * Add the model, scopes, eager loaded relationships, local macro's and onDelete callback
     * from the $builder to this query builder.
     *
     * @param \Illuminate\Database\Eloquent\Builder $builder
     */
    protected function initializeFromBuilder(Builder $builder)
    {
        $this->builder->setModel($builder->getModel())
            ->setEagerLoads($builder->getEagerLoads());

        $this->baseTable = $this->builder->getModel()->getTable();
        $this->baseModel = $this->builder->getModel();
        $this->modelClass = get_class($this->builder->getModel());

        $this->joinResolver = new JoinResolver($this);
    }

    protected function setResourceClass(string $value)
    {
        $this->resourceClass = $value;

        return $this;
    }

    protected function init()
    {
        $this->loadAllVirtualFields();
    }

    protected function loadAllVirtualFields()
    {
        $this->virtualFields = $this->resourceClass::getVirtualFields();
    }

    /**
     * @param \Unite\UnisysApi\Http\Resources\Resource $resourceClass
     */
    protected function getTableFromModelClass(string $resourceClass)
    {
        return with(new $resourceClass)->getTable();
    }

    /**
     * @param \Unite\UnisysApi\Http\Resources\Resource $resourceClass
     */
    protected function getTableFromResourceClass(string $resourceClass)
    {
        /** @var Model $modelClass */
        $modelClass = $resourceClass::modelClass();

        return $this->getTableFromModelClass($modelClass);
    }

    /**
     * @param \Unite\UnisysApi\Http\Resources\Resource $resourceClass
     * @param Request $request
     */
    public static function for(string $modelClass, ? Request $request = null) : self
    {
        /** @var \Illuminate\Database\Eloquent\Builder $baseQuery */
        $baseQuery = ($modelClass)::query();
        $baseQuery->with($resourceClass::getEagerLoads());

        $builder = new static($baseQuery, $request ?? request());
        $builder->setResourceClass($resourceClass);
        $builder->init();
        $builder->parseRequest();

        return $builder;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function get()
    {
        $this->buildQuery();

        return $this->builder->get($this->baseSelect());
    }

    /**
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function paginate()
    {
        $this->buildQuery();

        return $this->builder->paginate($this->limit, $this->baseSelect(), config('query-filter.page_name'), $this->page);
    }

    protected function baseSelect()
    : array
    {
        return [ $this->baseTable . '.*' ];
    }

    public function buildQuery()
    {
        $this->joins = $this->resolveJoins();

        $this->addSearchToBuilder();

        $this->addConditionToBuilder();

        $this->addOrderByToBuilder();

        $this->addJoinsToBuilder();

        $this->builder->select($this->baseSelect());

        $this->builder->distinct();

        return $this->builder;
    }

    protected function addSearchToBuilder()
    {
        if($this->search->query) {
            $this->builder->where(function (Builder $query) {
                $this->search->columns->each(function(Column $column) use ($query) {
                    if($this->isVirtualField($column->fullColumn)) {
                          $this->executeVirtualField($query, $column->fullColumn, $this->search->query);
                    } else {
                        $query->orWhere($column->fullColumn, 'like', ($this->search->fulltext ? '%' : '') . $this->search->query . '%');
                    }
                });
            });
        }
    }

    protected function executeVirtualField(Builder $query, $field, $value)
    {
        return $this->virtualFields[$field]($query, $value);
    }

    protected function isVirtualField(string $field)
    {
        return isset($this->virtualFields[$field]);
    }

    protected function addConditionToBuilder()
    {
        foreach ($this->filters as $filter) {
            $this->builder->where(function ($query) use ($filter) {
                /** @var $query Builder */
                $this->addConditionDataToBuilder($query, $filter);
            });
        }
    }

    protected function addConditionDataToBuilder(Builder $query, Filter $filter)
    {
        if($filter->operator === 'and') {
            $this->builder->groupBy($this->baseTable . '.id');
            $this->builder->havingRaw('COUNT(*) = ?', [$filter->data->count()]);
        }

        foreach ($filter->data as $dataItem) {
            if ($filter->operator === 'or' || $filter->operator === 'and') {
                if($this->isVirtualField($filter->column->fullColumn)) {
                    $this->executeVirtualField($query, $filter->column->fullColumn, $dataItem->value);
                } else {
                    $query->orWhere($filter->column->fullColumn, $dataItem->operator, $dataItem->value);
                }
            } elseif ($filter->operator === 'between') {
                $query->whereBetween($filter->column->fullColumn, $filter->getDataValues());
            }
        }

        return $query;
    }

    protected function addOrderByToBuilder()
    {
        if($this->isVirtualField($this->orderBy->column->fullColumn)) {
            $this->executeVirtualField($this->builder, $this->orderBy->column->fullColumn, $this->orderBy->direction);
        } else {
            $this->builder->orderBy($this->orderBy->column->fullColumn, $this->orderBy->direction);
        }
    }

    protected function addJoinsToBuilder()
    {
        $this->joins->each(function (Join $join) {
            if($join->conditions->isEmpty()) {
                $this->builder = $this->builder->join($join->table, $join->first, '=', $join->second);
            } else {
                $this->builder = $this->builder->join($join->table, function ($q) use ($join) {
                    /** @var \Illuminate\Database\Query\JoinClause $q */
                    $q->on($join->first, '=', $join->second);

                    foreach ($join->conditions as $condition) {
                        $q->where($condition['column'], '=', $condition['value']);
                    }
                });
            }
        });
    }
}