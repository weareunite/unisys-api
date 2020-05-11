<?php

namespace Unite\UnisysApi\Modules\Users\GraphQL\Queries;

use Closure;
use GraphQL\Type\Definition\ResolveInfo;
use Illuminate\Support\Facades\Auth;

class ProfileQuery extends DetailQuery
{
    public $name = 'profile';

    protected $type = 'Profile';

    protected function modelClass()
    : string
    {
        return config('unisys.user');
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
