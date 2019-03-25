<?php

namespace Unite\UnisysApi\Modules\Users\GraphQL\Mutations;

use Illuminate\Database\Eloquent\Model;
use Unite\UnisysApi\GraphQL\Mutations\MassDeleteMutation as BaseMassDeleteMutation;
use Unite\UnisysApi\Modules\Users\UserRepository;

class MassDeleteMutation extends BaseMassDeleteMutation
{
    protected $attributes = [
        'name' => 'massDeleteUser',
    ];

    public function repositoryClass()
    : string
    {
        return UserRepository::class;
    }

    protected function beforeDelete(Model $model, $root, $args)
    {
        // todo: before delete User
    }
}
