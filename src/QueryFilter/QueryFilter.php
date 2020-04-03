<?php

namespace Unite\UnisysApi\QueryFilter;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;

class QueryFilter implements QueryFilterInterface
{
    /** @var Builder */
    protected $query;

    /** @var Model */
    protected $model;

    public function __construct(Builder $query)
    {
        $this->query = $query;
    }

    public function setModel(Model $model)
    {
        $this->model = $model;

        return $this;
    }

    protected static function getFilterMethodName(string $field)
    : string
    {
        return 'filter' . ucfirst(Str::camel($field));
    }

    protected static function getSearchMethodName(string $field)
    : string
    {
        return 'search' . ucfirst(Str::camel($field));
    }

    protected static function getFieldName(string $field)
    : string
    {
        return lcfirst(Str::snake($field));
    }

    protected function resolveCondition(string $field, ?string $operator, array $values)
    {
        $operator = $operator ?: 'and';

        switch ($operator) {
            case 'and':
                if (count($values) === 1) {
                    $this->query->where($field, '=', $values[0]);
                } else {
                    $this->query->whereIn($field, $values);
                }
                break;
            case 'or':
                if (count($values) === 1) {
                    $this->query->orWhere($field, '=', $values[0]);
                } else {
                    $this->query->whereIn($field, $values, 'or');
                }
                break;
            case 'between';
                if (count($values) === 2) {
                    $this->query->whereBetween($field, [ $values[0], $values[1] ]);
                }
                break;
        }
    }

    protected function resolveSearch(string $field, string $search)
    {
        $fulltext = false;

        if ($firstChar = mb_substr($search, 0, 1) === '%') {
            $search = substr($search, 1);
            $fulltext = true;
        }

        $this->query->where($field, 'like', $search . $fulltext ? '%' : '');
    }

    protected function prepareCondition(array $condition)
    : Builder
    {
        $method = self::getFilterMethodName($condition['field']);

        if (method_exists($this, $method)) {
            call_user_func_array([ $this, $method ], [ $condition['values'] ]);
        } else {
            $field = self::getFieldName($condition['field']);

            if (in_array($field, $this->model->getFillable())) {
                $this->resolveCondition($field, $condition['operator'] ?? null, $condition['values']);
            }
        }

        return $this->query;
    }

    protected function prepareSearch(?array $search)
    {
        foreach ($search['fields'] ?? [] as $field) {
            $method = self::getSearchMethodName($field);

            if (method_exists($this, $method)) {
                call_user_func_array([ $this, $method ], $search['query']);
            } else {
                $field = self::getFieldName($field);

                if (in_array($field, $this->model->getFillable())) {
                    $this->resolveSearch($field, $search['query']);
                }
            }
        }


        return $this->query;
    }

    protected function resolveOrder($value = null)
    {
        if ($value === null) {
            $column = config('unisys.query-filter.default_order_column');
            $direction = config('unisys.query-filter.default_order_direction');
        } elseif (mb_substr($value, 0, 1, "utf-8") === '-') {
            $direction = 'desc';
            $column = substr($value, 1);
        } else {
            $direction = 'asc';
            $column = $value;
        }

        $this->query->orderBy($column, $direction);
    }

    protected function resolveLimit($value = null)
    {
        $this->query->limit(self::handleLimit($value));
    }

    public function filter(array $filter)
    : Builder
    {
        $this->resolveLimit($filter['limit'] ?? null);

        $this->resolveOrder($filter['order'] ?? null);

        $conditions = $filter['filter']['conditions'] ?? $filter['conditions'] ?? [];

        foreach ($conditions as $condition) {
            $this->prepareCondition($condition);
        }

        $this->prepareSearch($filter['search'] ?? null);

        return $this->query;
    }

    public static function getAvailableCustomFilters()
    : array
    {
        $list = [];

        foreach (get_class_methods(get_called_class()) as $method) {
            if (Str::startsWith($method, 'filter') && $method !== 'filter') {
                $field = substr($method, 6);

                if ($field !== '') {
                    $list[] = self::getFieldName(substr($method, 6));
                }
            }
        }

        return $list;
    }

    public static function handleLimit($value = null)
    {
        $limit = $value ?: config('unisys.query-filter.default_limit');

        if ($limit > config('unisys.query-filter.max_limit')) {
            $limit = config('unisys.query-filter.max_limit');
        }

        return $limit;
    }

    public static function handlePage($value = null)
    {
        return $value ?: 1;
    }

    public static function paginate(QueryFilterRequest $request, Builder $query)
    {
        $args = $request->only(['page', 'limit', 'order', 'search', 'filter']);

        $limit = QueryFilter::handleLimit($args['limit']);
        $page = QueryFilter::handlePage($args['page']);

        if(method_exists($query, 'filter')) {
            $query = $query->filter($args);
        }

        return $query->paginate($limit, [], config('unisys.query-filter.page_name'), $page);
    }
}
