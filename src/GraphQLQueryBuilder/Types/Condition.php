<?php

namespace Unite\UnisysApi\QueryBuilder\Types;

use Illuminate\Support\Collection;

class Condition extends Type
{
    /** @var string */
    public $column;

    /** @var string */
    public $operator;

    /** @var Collection|DataItem[]|DataItem */
    public $values;

    public function __construct(string $column, string $operator, $values)
    {
        $this->column = $column;
        $this->operator = $operator;
        $this->values = $values;
    }

    public function getDataValues(): array
    {
        if($this->values instanceof DataItem) {
            return [$this->values->value];
        }

        $values = [];

        foreach ($this->values as $dataItem) {
            $values[] = $dataItem->value;
        }

        return $values;
    }
}