<?php

namespace Unite\UnisysApi\Modules\Permissions\GraphQL\Mutations;

use Unite\UnisysApi\GraphQL\Mutations\DeleteMutation as Mutation;
use Unite\UnisysApi\Modules\Permissions\RoleRepository;

class DeleteRoleMutation extends Mutation
{
    protected $attributes = [
        'name' => 'deleteRole',
    ];

    public function repositoryClass()
    : string
    {
        return RoleRepository::class;
    }
}
