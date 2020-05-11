<?php

namespace Unite\UnisysApi\Modules\Users\GraphQL\Queries;

use GraphQL\Type\Definition\Type;
use Illuminate\Support\Facades\Auth;
use Unite\UnisysApi\Modules\GraphQL\GraphQL\Queries\DetailQuery as BaseDetailQuery;

class DetailQuery extends BaseDetailQuery
{
    protected function modelClass()
    : string
    {
        return config('unisys.user');
    }

    public function args()
    : array
    {
        return [
            'id' => [
                'type'         => Type::int(),
                'defaultValue' => Auth::id(),
            ],
        ];
    }
}
