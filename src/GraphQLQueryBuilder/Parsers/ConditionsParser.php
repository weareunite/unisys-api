<?php

namespace Unite\UnisysApi\GraphQLQueryBuilder\Parsers;

use Illuminate\Support\Arr;
use stdClass;
use Unite\UnisysApi\GraphQLQueryBuilder\Types\Column;
use Unite\UnisysApi\GraphQLQueryBuilder\Types\DataItem;
use Unite\UnisysApi\GraphQLQueryBuilder\Types\Condition;

class ConditionsParser extends Parser
{
    /** @var Column */
    protected $column;

    /** @var string */
    protected $operator;

    /** @var \Illuminate\Support\Collection|DataItem[] */
    protected $values;

    protected function handle($value)
    {
        if(!is_array($value)) {
            $value = json_decode($value);
        }

        $conditions = [];

        foreach ($value as $condition) {
            if(!is_object($condition)) {
                $condition = (object) $condition;
            }

            $this->column = $condition->field;

            $this->reset();

            $conditions[] = $this->createCondition($condition);
        }

        return collect($conditions);
    }

    protected function reset()
    {
        $this->operator = 'or';
        $this->values = collect();
    }

    protected function createCondition($value)
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

        return new Condition($this->column, $this->operator, $this->values);
    }

    protected function parseObject(stdClass $value)
    {
        if (isset($value->operator) && in_array($value->operator, [ 'and', 'or', 'between' ])) {
            $this->operator = $value->operator;
        }

        if (Arr::accessible($value->values)) {
            $this->parseArray($value->values);
        } else {
            $this->parseString($value->values);
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
        $this->values->push($this->parseConditionValue($value));
    }

    protected static function parseConditionValue(string $value)
    : DataItem
    {
        $operator = '=';
        $firstChar = mb_substr($value, 0, 1, "utf-8");

        if($value === 'true') {
            $value = true;
        } elseif($value === 'false') {
            $value = false;
        }

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