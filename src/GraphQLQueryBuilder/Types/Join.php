<?php

namespace Unite\UnisysApi\GraphQLQueryBuilder\Types;

class Join extends Type
{
    /** @var string */
    public $table;

    /** @var string */
    public $first;

    /** @var string */
    public $second;

    /** @var \Illuminate\Support\Collection */
    public $conditions;

    public function __construct(string $table, string $first, string $second, array $conditions = null)
    {
        $this->table = $table;
        $this->first = $first;
        $this->second = $second;
        $this->conditions = collect($conditions);

    }
}