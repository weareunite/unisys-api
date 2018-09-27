<?php

namespace Unite\UnisysApi\QueryBuilder\Parsers;

use Illuminate\Support\Arr;
use stdClass;
use Unite\UnisysApi\QueryBuilder\Types\Column;
use Unite\UnisysApi\QueryBuilder\Types\DataItem;
use Unite\UnisysApi\QueryBuilder\Types\Filter;

class FilterParser extends Parser
{
    /** @var Column */
    protected $column;

    /** @var string */
    protected $operator;

    /** @var \Illuminate\Support\Collection|DataItem[] */
    protected $data;

    protected function handle($value = null)
    {
        $rawFilters = $value ? json_decode(base64_decode($value)) : [];
        $rawFilters = $rawFilters ?: [];
        $filters = [];

        foreach ($rawFilters as $column => $filter) {
            $this->column = $this->queryBuilder->resolveColumn($column);

            $this->reset();

            $filters[] = $this->createFilter($filter);
        }

        return collect($filters);
    }

    protected function reset()
    {
        $this->operator = 'or';
        $this->data = collect();
    }

    protected function createFilter($value)
    {
        switch (gettype($value)) {
            case 'object':
                $this->parseObject($value);
                break;
            case 'array':
                $this->parseArray($value);
                break;
            case 'string':
                $this->parseString($value);
                break;
            default:
                break;
        }

        return new Filter($this->column, $this->operator, $this->data);
    }

    protected function parseObject(stdClass $value)
    {
        if (in_array($value->operator, [ 'and', 'or', 'between' ])) {
            $this->operator = $value->operator;
        }

        if (Arr::accessible($value->data)) {
            $this->parseArray($value->data);
        } else {
            $this->parseString($value->data);
        }
    }

    protected function parseArray(array $valueArray)
    {
        foreach ($valueArray as $value) {
            $this->parseString($value);
        }
    }

    protected function parseString(string $value)
    {
        $this->data->push($this->parseFilterValue($value));
    }

    protected static function parseFilterValue(string $value)
    : DataItem
    {
        $operator = '=';
        $firstChar = mb_substr($value, 0, 1, "utf-8");

        if (in_array($firstChar, ['<', '>', '=', '%'])) {
            $value = substr($value, 1);

            switch ($firstChar) {
                case '<':
                    $operator = '<';
                    break;
                case '>':
                    $operator = '>';
                    break;
                case '%':
                    $operator = 'like';
                    $value = $value . '%';
                    break;
            }
        }

        return new DataItem($operator, $value);
    }
}