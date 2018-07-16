<?php

namespace Unite\UnisysApi\Services;

use Doctrine\DBAL\Query\QueryBuilder;
use Illuminate\Database\Eloquent\Concerns\QueriesRelationships;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Query\Builder;
use Illuminate\Http\Request;
use Unite\UnisysApi\Repositories\Repository;

class RequestQueryBuilderService extends AbstractService
{
    protected $request;

    /**
     * @var Repository
     */
    protected $repository;

    protected $limit;

    protected $page;

    protected $filter = [];

    protected $search;

    protected $relations = [];

    protected $searchFields = [];

    protected $filterFields = [];

    /**
     * @var Model|QueryBuilder|Builder|QueriesRelationships;
     */
    protected $query;

    /**
     * @var Model|QueryBuilder|Builder;
     */
    protected $model;

    protected $self_relation;

    public function __construct(Request $request)
    {
        $this->request = $request;

        $this->setLimit();

        $this->setPage();

        $this->handleFilter();

        $this->handleSearch();
    }

    public function setRepository(Repository $repository)
    {
        $this->repository = $repository;

        return $this;
    }

    public function get(array $columns = ['*'])
    {
        $this->initQuery();

        $this->setOrderBy();

        $this->setQueryFromFilter();

        $this->resolveSearchQuery();

        $this->loadRelations();

        return $this->query->paginate($this->limit, $columns, config('query-filter.page_name'), $this->page);
    }

    private function initQuery()
    {
        $this->query = $this->repository->getQueryBuilder();

        $this->self_relation = str_singular($this->query->getTable());

        return $this;
    }

    private function setOrderBy()
    {
        if(!$this->request->get('order')) {
            $column = config('query-filter.default_order_column');
            $direction = config('query-filter.default_order_direction');
        } elseif(substr($this->request->get('order'), 0, 1) === '-') {
            $direction = 'desc';
            $column = substr($this->request->get('order'), 1);
        } else {
            $direction = 'asc';
            $column = $this->request->get('order');
        }

        $this->query = $this->query->orderBy($column, $direction);

        return $this;
    }

    private function setLimit()
    {
        $this->limit = $this->request->get('limit') ?: config('query-filter.default_limit');

        if($this->limit > config('query-filter.max_limit')) {
            $this->limit = config('query-filter.max_limit');
        }

        return $this;
    }

    private function setPage()
    {
        $this->page = $this->request->get('page') ?: 1;

        return $this;
    }

    private function handleFilter()
    {
        $filter = $this->request->get('filter')
            ? json_decode($this->request->get('filter'), true)
            : [];

        foreach($filter as $column => $value) {
            $this->setFilterFieldByColumn($column, $value);

            if ($this->hasRelation($column)) {
                $this->addRelationByColumn($column);
            }
        }

        return $this;
    }

    private function setQueryFromFilter()
    {
        foreach($this->filterFields as $relation => $filter) {

            if(is_numeric($relation)) {
                if(!isset($filter['column'])) {
                    $this->query = $this->query->where(function ($q) use ($filter) {
                        foreach ($filter as $item) {
                            /** @var $q Model|QueryBuilder|Builder; */
                            $q->orWhere($item['column'], $item['operator'], $item['value']);
                        }
                    });
                } else {
                    $this->query = $this->query->where($filter['column'], $filter['operator'], $filter['value']);
                }
            } else {
                $this->query = $this->query->whereHas($relation, function ($query) use ($filter) {
                        /** @var $query Model|QueryBuilder|Builder|QueriesRelationships; */
                        $query->where($filter['column'], $filter['operator'], $filter['value']);
                });
            }
        }

        return $this;
    }

    private function getRelationFromColumn(string $column)
    {
        if (strpos($column, ".")) {
            $column_parts = explode('.', $column);

            return $column_parts[0];
        }

        return null;
    }

    private function getBaseColumn(string $column): string
    {
        if (strpos($column, ".")) {
            $column_parts = explode('.', $column);

            return $column_parts[1];
        }

        return $column;
    }

    private function makeFilter($column, $value)
    {
        $operator = '=';

        if(substr($value, 0, 1) === '<') {
            $operator = '<=';
            $value = substr($value, 1);
        } elseif(substr($value, 0, 1) === '>') {
            $operator = '>=';
            $value = substr($value, 1);
        } elseif(substr($value, 0, 1) === '%') {
            $operator = 'like';
            $value = substr($value, 1) . '%';
        }

        return [
            'column'    => $column,
            'operator'  => $operator,
            'value'     => $value,
        ];
    }

    private function handleSearch()
    {
        $search = $this->request->get('search')
            ? json_decode($this->request->get('search'), true)
            : '';

        if(isset($search['query']) && $search['query'] !== '') {
            $this->search = $search['query'];
        }

        if(isset($search['fields']) && is_array($search['fields'])) {
            foreach ($search['fields'] as $column) {

                $this->setSearchFieldByColumn($column);

                if ($this->hasRelation($column)) {
                    $this->addRelationByColumn($column);
                }
            }
        }

        return $this;
    }

    private function resolveSearchQuery()
    {
        if(empty($this->searchFields)) {
            return $this->query;
        }

        $this->query = $this->query->where(function ($query) {
            foreach ($this->searchFields as $relation => $columns) {
                if (is_array($columns)) {
                    /** @var $query Model|QueryBuilder|Builder|QueriesRelationships; */
                    $query->orWhereHas($relation, function ($query) use ($columns) {
                        /** @var $query Model|QueryBuilder|Builder|QueriesRelationships; */
                        $query->where(function ($query) use ($columns) {
                            /** @var $query Model|QueryBuilder|Builder|QueriesRelationships; */
                            foreach ($columns as $column) {
                                $query->orWhere($column, 'like', '%' . $this->search . '%');
                            }
                        });
                    });
                } else {
                    $query->orWhere($columns, 'like', '%' . $this->search . '%');
                }
            }
        });

        return $this;
    }

    private function hasRelation(string $column): bool
    {
        return (strpos($column, "."));
    }

    private function loadRelations()
    {
        $this->query->with($this->relations);
    }

    private function addRelationByColumn(string $column)
    {
        $relation = $this->getRelationFromColumn($column);

        if($relation !== null && $relation !== $this->self_relation && !in_array($relation, $this->relations)) {
            $this->relations[] = $relation;
        }
    }

    private function setSearchFieldByColumn(string $column)
    {
        $relation = $this->getRelationFromColumn($column);

        $column_base = $this->getBaseColumn($column);

        if($relation !== null) {
            if($relation !== $this->self_relation) {
                if (!isset($this->searchFields[ $relation ])) {
                    $this->searchFields[ $relation ] = [];
                }

                if (!in_array($column_base, $this->searchFields[ $relation ])) {
                    $field[ $relation ][] = $column_base;
                }
            }
        } else {
            $this->searchFields[] = $column;
        }
    }

    private function setFilterFieldByColumn(string $column, $value)
    {
        $relation = $this->getRelationFromColumn($column);

        $column_base = $this->getBaseColumn($column);

        if(is_array($value)) {
            $p = [];
            foreach ($value as $item) {
                $p[] = $this->makeFilter($column_base, $item);
            }

            $this->filterFields[] = $p;
        } else {
            if ($relation !== null) {
                if ($relation !== $this->self_relation) {
                    if (!isset($this->filterFields[ $relation ])) {
                        $this->filterFields[ $relation ] = $this->makeFilter($column_base, $value);
                    } else {
                        $this->filterFields[ $relation ][] = $this->makeFilter($column_base, $value);
                    }
                }
            } else {
                $this->filterFields[] = $this->makeFilter($column_base, $value);
            }
        }
    }
}