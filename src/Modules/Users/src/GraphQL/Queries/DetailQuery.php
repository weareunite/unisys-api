<?php

namespace Unite\UnisysApi\Modules\Users\GraphQL\Queries;

use GraphQL\Type\Definition\Type;
use Illuminate\Support\Facades\Auth;
use Unite\UnisysApi\Modules\GraphQL\GraphQL\DetailQuery as BaseDetailQuery;
use Unite\UnisysApi\Modules\Users\User;

class DetailQuery extends BaseDetailQuery
{
    protected function modelClass()
    : string
    {
        return User::class;
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
