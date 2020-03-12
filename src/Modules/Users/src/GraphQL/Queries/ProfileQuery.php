<?php

namespace Unite\UnisysApi\Modules\Users\GraphQL\Queries;

use Closure;
use GraphQL\Type\Definition\ResolveInfo;
use Illuminate\Support\Facades\Auth;
use Unite\UnisysApi\Modules\Users\User;

class ProfileQuery extends DetailQuery
{
    public $name = 'profile';

    protected function modelClass()
    : string
    {
        return User::class;
    }

    public function args()
    : array
    {
        return [];
    }

    public function resolve($root, $args, $context, ResolveInfo $resolveInfo, Closure $getSelectFields)
    {
        $this->find(['id' => Auth::id()], $getSelectFields());

        return $this->model;
    }
}
