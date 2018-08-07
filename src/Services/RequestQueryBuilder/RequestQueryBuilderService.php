<?php

namespace Unite\UnisysApi\Services\RequestQueryBuilder;

use Doctrine\DBAL\Query\QueryBuilder;
use Illuminate\Database\Eloquent\Concerns\QueriesRelationships;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Arr;
use Unite\UnisysApi\Repositories\Repository;
use Unite\UnisysApi\Services\AbstractService;

class RequestQueryBuilderService extends AbstractService
{
    /** @var Repository */
    protected $repository;

    /** @var integer */
    protected $limit;

    /** @var integer */
    protected $page;

    /** @var string */
    protected $search;

    /** @var QueryBuilder|Builder|QueriesRelationships */
    protected $query;

    /** @var string[] */
    protected $data;

    /** @var string[] */
    protected $joins = [];

    const JOIN_DELIMITER = '|';

    /**
     * RequestQueryBuilderService constructor.
     * @param string[]|null $data
     */
    public function __construct(array $data = null)
    {
        if ($data) {
            $this->init($data);
        }
    }

    /**
     * @param string[] $data
     * @return $this
     */
    public function init(array $data)
    {
        $this->setData($data);

        $this->setLimit();

        $this->setPage();

        return $this;
    }

    /**
     * @param string[] $data
     * @return $this
     */
    public function setData(array $data)
    {
        $this->data = $data;

        return $this;
    }

    /**
     * @param Repository $repository
     * @return $this
     */
    public function setRepository(Repository $repository)
    {
        $this->repository = $repository;

        return $this;
    }

    /**
     * @param array $columns
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function get(array $columns = [ '*' ])
    {
        $this->buildQuery();

        if ($columns === [ '*' ]) {
            $columns = $this->baseSelect();
        }

        return $this->query->get($columns);
    }

    /**
     * @param array $columns
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function paginate(array $columns = [ '*' ])
    {
        $this->buildQuery();

        if ($columns === [ '*' ]) {
            $columns = $this->baseSelect();
        }

        return $this->query->paginate($this->limit, $columns, config('query-filter.page_name'), $this->page);
    }

    /**
     * @return void
     */
    private function buildQuery()
    {
        $this->initQuery();

        $this->handleSearch();

        $this->handleFilter();

        $this->setOrderBy();

        $this->resolveJoins();

        $this->query->distinct();
    }

    /**
     * @return array
     */
    private function baseSelect()
    : array
    {
        return [ $this->repository->getTable() . '.*' ];
    }

    /**
     * @return $this
     */
    private function initQuery()
    {
        $this->query = $this->repository->getQueryBuilder();

        return $this;
    }

    /**
     * @return $this
     */
    private function setOrderBy()
    {
        if (!isset($this->data['order'])) {
            $column = config('query-filter.default_order_column');
            $direction = config('query-filter.default_order_direction');
        } elseif (substr($this->data['order'], 0, 1) === '-') {
            $direction = 'desc';
            $column = substr($this->data['order'], 1);
        } else {
            $direction = 'asc';
            $column = $this->data['order'];
        }

        if (RelationResolver::hasRelation($column)) {
            $this->addJoins($column);
            $column = RelationResolver::columnWithTable($column);
        } else {
            $column = $this->repository->getTable() . '.' . $column;
        }

        $this->query = $this->query->orderBy($column, $direction);

        return $this;
    }

    /**
     * @param string $column
     * @return $this
     */
    private function addJoins(string $column)
    {
        $base_table = $this->repository->getTable();

        $relations = explode('.', RelationResolver::onlyRelations($column, $this->repository->getResourceLocalMap()));

        for ($i = 0; $i < count($relations); $i++) {

            $table = RelationResolver::relationToTable($relations[ $i ]);

            if (RelationResolver::hasManyMorphed($relations[ $i ])) {
                $first = $table . '.' . RelationResolver::foreignId($table);

                if ($i === 0) {
                    $second = RelationResolver::relationId($base_table);
                } else {
                    $second = RelationResolver::relationId($relations[ $i - 1 ]);
                }

                $this
                    ->addJoin(
                        $table,
                        $first,
                        $second,
                        $table . '.' . RelationResolver::manyMorphedType($table),
                        $this->repository->getModelClass())
                    ->addJoin(
                        $relations[ $i ],
                    $table . '.' . RelationResolver::foreignId($relations[ $i ]),
                    RelationResolver::clearRelationId($relations[ $i ])
                );

            } elseif (RelationResolver::hasMany($relations[ $i ])) {
                if ($i === 0) {
                    $first = RelationResolver::relationId($base_table);
                    $second = $table . '.' . RelationResolver::foreignId($base_table);
                } else {
                    $first = RelationResolver::relationId($relations[ $i - 1 ]);
                    $second = $table . '.' . RelationResolver::foreignId($relations[ $i - 1 ]);
                }

                $this->addJoin($table, $first, $second);
            } else {
                if ($i === 0) {
                    $first = $base_table . '.' . RelationResolver::foreignId($relations[ $i ]);
                } else {
                    $first = RelationResolver::relationToTable($relations[ $i - 1 ]) . '.' . RelationResolver::foreignId($relations[ $i ]);
                }

                $second = RelationResolver::relationId($relations[ $i ]);

                $this->addJoin($table, $first, $second);
            }
        }

        return $this;
    }

    /**
     * @param string $table
     * @param string $first
     * @param string $second
     * @param array $conditions
     * @return $this
     */
    private function addJoin(string $table, string $first, string $second, ... $conditions)
    {
        $join = $table . self::JOIN_DELIMITER . $first . self::JOIN_DELIMITER . $second;

        if($conditions) {
            foreach($conditions as $condition) {
                $join .= self::JOIN_DELIMITER . $condition;
            }
        }

        if (!in_array($join, $this->joins)) {
            $this->joins[] = $join;
        }

        return $this;
    }

    /**
     * @return $this
     */
    private function resolveJoins()
    {
        foreach ($this->joins as $join) {
            $joins = explode(self::JOIN_DELIMITER, $join);

            if(count($joins) === 3) {
                $this->query = $this->query->join($joins[0], $joins[1], '=', $joins[2]);
            } else {
                $this->query->join($joins[0], function ($join) use ($joins) {
                    /** @var \Illuminate\Database\Query\JoinClause $join */
                    $join->on($joins[1], '=', $joins[2]);
                    $join->where($joins[3], '=', $joins[4]);
                });
            }
        }

        return $this;
    }

    /**
     * @return $this
     */
    private function setLimit()
    {
        $this->limit = $this->data['limit'] ?? config('query-filter.default_limit');

        if ($this->limit > config('query-filter.max_limit')) {
            $this->limit = config('query-filter.max_limit');
        }

        return $this;
    }

    /**
     * @return $this
     */
    private function setPage()
    {
        $this->page = $this->data['page'] ?? 1;

        return $this;
    }

    /**
     * @return $this
     */
    private function handleFilter()
    {
        $filter = isset($this->data['filter'])
            ? json_decode($this->data['filter'], true)
            : [];

        foreach ($filter as $column => $value) {
            $this->setFilterFieldByColumn($column, $value);
        }

        return $this;
    }

    /**
     * @param string $value
     * @return array
     */
    private function makeFilter(string $value)
    {
        $operator = '=';

        if (substr($value, 0, 1) === '<') {
            $operator = '<=';
            $value = substr($value, 1);
        } elseif (substr($value, 0, 1) === '>') {
            $operator = '>=';
            $value = substr($value, 1);
        } elseif (substr($value, 0, 1) === '%') {
            $operator = 'like';
            $value = substr($value, 1) . '%';
        }

        return [
            'operator' => $operator,
            'value'    => $value,
        ];
    }

    /**
     * @return $this
     */
    private function handleSearch()
    {
        $search = isset($this->data['search'])
            ? json_decode($this->data['search'], true)
            : '';

        if (isset($search['query']) && $search['query'] !== '') {
            $this->search = $search['query'];
        }

        if (isset($search['fields']) && is_array($search['fields'])) {
            $this->query = $this->query->where(function ($query) use ($search) {
                foreach ($search['fields'] as $column) {
                    $this->setSearchFieldByColumn($column, $query);
                }
            });
        }

        return $this;
    }

    /**
     * @param string $column
     * @param QueryBuilder|Builder|QueriesRelationships $query
     */
    private function setSearchFieldByColumn(string $column, &$query)
    {
        if (RelationResolver::hasRelation($column)) {
            $this->addJoins($column);

            $column = RelationResolver::columnWithTable($column);
        }

        $query->orWhere($column, 'like', '%' . $this->search . '%');
    }

    /**
     * @param string $column
     * @param string|array $value
     */
    private function setFilterFieldByColumn(string $column, $value)
    {
        if (RelationResolver::hasRelation($column)) {
            $this->addJoins($column);

            $column = RelationResolver::columnWithTable($column);
        }

        if (Arr::accessible($value)) {
            $this->query = $this->query->where(function ($query) use ($value, $column) {
                /** @var $query QueryBuilder|Builder|QueriesRelationships; */

                if (str_contains($column, [ '_date', 'date_' ])) {
                    $query->whereBetween($column, $value);
                } else {
                    foreach ($value as $item) {
                        $filter = $this->makeFilter($item);

                        $query->orWhere($column, $filter['operator'], $filter['value']);
                    }
                }
            });
        } else {
            $this->query = $this->query->where(function ($query) use ($column, $value) {
                /** @var $query QueryBuilder|Builder|QueriesRelationships; */
                $filter = $this->makeFilter($value);

                $query->orWhere($column, $filter['operator'], $filter['value']);
            });
        }
    }
}