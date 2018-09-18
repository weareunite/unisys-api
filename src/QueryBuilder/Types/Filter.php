<?php

namespace Unite\UnisysApi\QueryBuilder\Types;

use Illuminate\Support\Collection;

class Filter extends Type
{
    /** @var Column */
    public $column;

    /** @var string */
    public $operator;

    /** @var Collection|DataItem[]|DataItem */
    public $data;

    public function __construct(Column $column, string $operator, $data)
    {
        $this->column = $column;
        $this->operator = $operator;
        $this->data = $data;
    }

    public function getDataValues(): array
    {
        if($this->data instanceof DataItem) {
            return [$this->data->value];
        }

        $values = [];

        foreach ($this->data as $dataItem) {
            $values[] = $dataItem->value;
        }

        return $values;
    }
}