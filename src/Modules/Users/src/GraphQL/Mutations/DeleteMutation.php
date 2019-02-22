<?php

namespace Unite\UnisysApi\Modules\Users\GraphQL\Mutations;

use Unite\UnisysApi\GraphQL\Mutations\DeleteMutation as BaseDeleteMutation;
use Unite\UnisysApi\Modules\Users\UserRepository;

class DeleteMutation extends BaseDeleteMutation
{
    protected $attributes = [
        'name' => 'deleteUser',
    ];

    public function repositoryClass()
    : string
    {
        return UserRepository::class;
    }
}
