<?php

namespace Unite\UnisysApi\Modules\GraphQL\GraphQL;

use Rebing\GraphQL\Support\Facades\GraphQL;
use GraphQL\Type\Definition\Type;

abstract class ListQuery extends PaginateQuery
{
    public function attributes()
    : array
    {
        return [
            'name'        => lcfirst($this->name),
            'description' => 'Paginated list of ' . $this->name,
        ];
    }

    public function type()
    : Type
    {
        return GraphQL::paginate($this->name);
    }
}
