<?php

namespace Unite\UnisysApi\GraphQLQueryBuilder\Types;

class OrderBy extends Type
{
    /**
     * @var Column
     */
    public $column;

    /**
     * @var string
     */
    public $direction;

    public function __construct($value = null)
    {
        $this->parse($value);
    }

    protected function parse($value = null)
    {
        if ($value === null) {
            $column = config('query-filter.default_order_column');
            $direction = config('query-filter.default_order_direction');
        } elseif (mb_substr($value, 0, 1, "utf-8") === '-') {
            $direction = 'desc';
            $column = substr($value, 1);
        } else {
            $direction = 'asc';
            $column = $value;
        }

        $this->direction = $direction;

        $this->column = $column;
    }
}