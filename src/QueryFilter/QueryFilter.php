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

    protected function resolveFilter(string $field, string $operator, array $values)
    {
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

    public function filterCondition(array $condition)
    : Builder
    {
        $method = self::getFilterMethodName($condition['field']);

        if (method_exists($this, $method)) {
            call_user_func_array([ $this, $method ], [ $condition['values'] ]);
        } else {
            $field = self::getFieldName($condition['field']);

            if (in_array($field, $this->model->getFillable())) {
                $this->resolveFilter($field, $condition['operator'], $condition['values']);
            }
        }

        return $this->query;
    }

    public function filterSearch(array $search)
    {
        foreach ($search['fields'] as $field) {
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

    public function filter(array $filter)
    {
        if (isset($filter['conditions'])) {
            foreach ($filter['conditions'] as $condition) {
                $this->filterCondition($condition);
            }
        }

        if (isset($filter['search'])) {
            $this->filterSearch($filter['search']);
        }

        return $this->query;
    }

    public static function getAvailableCustomFilters()
    : array
    {
        $list = [];

        foreach (get_class_methods(self::class) as $method) {
            if (Str::startsWith('filter', $method)) {
                $list[] = self::getFieldName(substr($method, 6));
            }
        }

        return $list;
    }
}
