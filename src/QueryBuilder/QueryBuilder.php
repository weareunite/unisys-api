<?php

namespace Unite\UnisysApi\QueryBuilder;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Unite\UnisysApi\Models\Model;
use Unite\UnisysApi\QueryBuilder\Parsers\FilterParser;
use Unite\UnisysApi\QueryBuilder\Parsers\LimitParser;
use Unite\UnisysApi\QueryBuilder\Parsers\OrderParser;
use Unite\UnisysApi\QueryBuilder\Parsers\PageParser;
use Unite\UnisysApi\QueryBuilder\Parsers\SearchParser;
use Unite\UnisysApi\QueryBuilder\Types\Column;
use Unite\UnisysApi\QueryBuilder\Types\Filter;
use Unite\UnisysApi\QueryBuilder\Types\Join;
use Unite\UnisysApi\QueryBuilder\Types\OrderBy;
use Unite\UnisysApi\QueryBuilder\Types\Search;
use Unite\UnisysApi\Repositories\Repository;

class QueryBuilder
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

    /** @var Collection|Filter[] */
    protected $filters;

    /** @var Collection|Join[] */
    protected $joins;

    /** @var string */
    public $baseTable;

    /** @var Model */
    public $baseModel;

    /** @var string */
    public $modelClass;

    /** @var JoinResolver */
    public $joinResolver;

    /** @var array */
    public $virtualFields;

    public function __construct(Builder $builder, ? Request $request = null)
    {
        $this->builder = new Builder($builder->getQuery());

        $this->initializeFromBuilder($builder);

        $this->request = $request ?? request();

        $this->parseRequest();
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
        $this->filters = (new FilterParser($this))->parse($requestData['filter']);

        $this->joins = $this->resolveJoins();
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

    public static function for($baseQuery, ? Request $request = null) : self
    {
        if (is_string($baseQuery)) {
            /** @var \Illuminate\Database\Eloquent\Builder $baseQuery */
            $baseQuery = ($baseQuery)::query();
        } elseif($baseQuery instanceof Repository) {
            $repository = $baseQuery;
            $baseQuery = $baseQuery
                ->getQueryBuilder()
                ->with($repository->getResourceEagerLoads());
        } elseif($baseQuery instanceof Model) {
            $baseQuery = $baseQuery
                ->newQuery()
                ->with($baseQuery->getResourceEagerLoads());
        }

        return new static($baseQuery, $request ?? request());
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

    protected function buildQuery()
    {
        $this->addSearchToBuilder();

        $this->addFilterToBuilder();

        $this->addOrderByToBuilder();

        $this->addJoinsToBuilder();

        $this->builder->distinct();
    }

    protected function addSearchToBuilder()
    {
        if($this->search->query) {
            $this->builder->where(function (Builder $query) {
                $this->search->columns->each(function(Column $column) use ($query) {
                    if($this->isVirtualField($column->fullColumn)) {
                          $this->executeVirtualField($query, $column->fullColumn, $this->search->query, 'or');
                    } else {
                        $query->orWhere($column->fullColumn, 'like', '%' . $this->search->query . '%');
                    }
                });
            });
        }
    }

    protected function executeVirtualField(Builder $query, $field, $value, string $operator = 'and')
    {
        return $this->virtualFields[$field]($query, $value, $operator);
    }

    protected function isVirtualField(string $field)
    {
        return isset($this->virtualFields[$field]);
    }

    public function setVirtualFields(array $virtualFields)
    {
        $this->virtualFields = $virtualFields;

        return $this;
    }

    protected function addFilterToBuilder()
    {
        foreach ($this->filters as $filter) {
            $this->builder->where(function ($query) use ($filter) {
                /** @var $query Builder */
                $this->addFilterDataToBuilder($query, $filter);
            });
        }
    }

    protected function addFilterDataToBuilder(Builder $query, Filter $filter)
    {
        foreach ($filter->data as $dataItem) {
            if($filter->operator === 'and') {
                if($this->isVirtualField($filter->column->fullColumn)) {
                    $this->executeVirtualField($query, $filter->column->fullColumn, $this->search->query);
                } else {
                    $query->where($filter->column->fullColumn, $dataItem->operator, $dataItem->value);
                }
            } elseif ($filter->operator === 'or') {
                if($this->isVirtualField($filter->column->fullColumn)) {
                    $this->executeVirtualField($query, $filter->column->fullColumn, $this->search->query, 'or');
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
        $this->builder->orderBy($this->orderBy->column->fullColumn, $this->orderBy->direction);
    }

    protected function addJoinsToBuilder()
    {
        $this->joins->each(function (Join $join) {
            if($join->conditions->isEmpty()) {
                $this->builder->join($join->table, $join->first, '=', $join->second);
            } else {
                $this->builder->join($join->table, function ($q) use ($join) {
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

// $column
// $operator
// $value

// if $column = 'expenses.draw_state'

// if $value = 'overdrawn' then $sql = where CASE WHEN expenses.amount < expenses.drawn THEN TRUE ELSE FALSE END