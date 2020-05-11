<?php

namespace Unite\UnisysApi\Modules\GraphQL\GraphQL\Queries;

abstract class ListQuery extends PaginateQuery
{
    public function __construct()
    {
        $this->pluralizedName = true;

        parent::__construct();
    }

    public function attributes()
    : array
    {
        return [
            'name'        => lcfirst($this->name),
            'description' => 'Paginated list of ' . $this->type ?: $this->name,
        ];
    }
}
