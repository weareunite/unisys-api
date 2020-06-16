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

    private static function replaceDotByUnderscore(string $field)
    : string
    {
        return str_replace('.', '_', $field);
    }

    private static function sanitizeFieldName(string $field)
    : string
    {
        return ucfirst(Str::camel(self::replaceDotByUnderscore($field)));
    }

    protected static function getFilterMethodName(string $field)
    : string
    {
        return 'filter' . self::sanitizeFieldName($field);
    }

    protected static function getSearchMethodName(string $field)
    : string
    {
        return 'search' . self::sanitizeFieldName($field);
    }

    protected static function getOrderMethodName(string $field)
    : string
    {
        return 'order' . self::sanitizeFieldName($field);
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

        $this->query->where($field, 'like', $search . ($fulltext ? '%' : ''));
    }

    protected function prepareCondition(array $condition)
    : Builder
    {
        $method = self::getFilterMethodName($condition['field']);

        if (method_exists($this, $method)) {
            call_user_func_array([ $this, $method ], [ $condition['values'] ]);
        } else {
            $field = self::getFieldName($condition['field']);

            $forceResolve = false;

            if($field === $this->model->getKeyName()) {
                $forceResolve = true;
            }

            if (in_array($field, $this->model->getFillable()) || $forceResolve) {
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

        $method = self::getOrderMethodName($column);

        if (method_exists($this, $method)) {
            call_user_func_array([ $this, $method ], $direction);
        } else {
            $this->query->orderBy($column, $direction);
        }

        return $this->query;
    }

    protected function resolveLimit($value = null)
    {
        $this->query->limit(self::handleLimit($value));
    }

    protected function resolvePrimaryKey($value)
    {
        $this->query->where($this->model->getKeyName(), '=', $value);
    }

    public function filter(array $filter)
    : Builder
    {
        if (isset($filter['id'])) {
            $this->resolvePrimaryKey($filter['id']);

            return $this->query;
        }

        $this->resolveLimit($filter['limit'] ?? null);

        $this->resolveOrder($filter['order'] ?? null);

        $conditions = $filter['filter']['conditions'] ?? $filter['conditions'] ?? [];

        if(is_string($conditions)) {
            $conditions = json_decode($conditions, true);
        }

        foreach ($conditions as $condition) {
            $this->prepareCondition($condition);
        }

        $search = $filter['search'] ?? null;

        if(is_string($search)) {
            $search = json_decode($search, true);
        }

        $this->prepareSearch($search ?: null);

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
        $args = $request->only([ 'id', 'page', 'limit', 'order', 'search', 'filter', 'conditions' ]);

        $limit = QueryFilter::handleLimit($args['limit'] ?? null);
        $page = QueryFilter::handlePage($args['page'] ?? null);

        if (method_exists($query->getModel(), 'scopeFilter')) {
            $query = $query->filter($args);
        }

        $query->addSelect([ $query->getModel()->getTable() . '.*' ]);

        return $query->paginate($limit, [], config('unisys.query-filter.page_name'), $page);
    }
}
