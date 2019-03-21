<?php

namespace Unite\UnisysApi\Modules\Permissions\GraphQL\Mutations;

use Unite\UnisysApi\GraphQL\Mutations\DeleteMutation as Mutation;
use Unite\UnisysApi\Modules\Permissions\PermissionRepository;

class DeleteMutation extends Mutation
{
    protected $attributes = [
        'name' => 'deletePermission',
    ];

    public function repositoryClass()
    : string
    {
        return PermissionRepository::class;
    }
}
