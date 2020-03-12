<?php

namespace Unite\UnisysApi\Modules\Company\GraphQL\Queries;

use Rebing\GraphQL\Support\SelectFields;
use Unite\UnisysApi\Modules\Company\Company;
use Unite\UnisysApi\Modules\GraphQL\GraphQL\DetailQuery as BaseDetailQuery;

class DetailQuery extends BaseDetailQuery
{
    protected function modelClass()
    : string
    {
        return Company::class;
    }

    public function args()
    : array
    {
        return [];
    }

    protected function find(array $args, SelectFields $fields)
    {
        $this->model = $this->newQuery()->with($fields->getRelations())
            ->select($fields->getSelect())
            ->firstOrFail();
    }
}