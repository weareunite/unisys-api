<?php

namespace Unite\UnisysApi\Modules\GraphQL\GraphQL;

use Unite\UnisysApi\Modules\GraphQL\GraphQL\Queries\PaginateQuery;

abstract class ListQuery extends PaginateQuery
{
    public function attributes()
    : array
    {
        return [
            'name'        => lcfirst($this->name),
            'description' => 'Paginated list of ' . $this->type ?: $this->name,
        ];
    }
}
