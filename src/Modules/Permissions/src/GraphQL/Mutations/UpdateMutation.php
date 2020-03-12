<?php

namespace Unite\UnisysApi\Modules\Permissions\GraphQL\Mutations;

use GraphQL\Type\Definition\Type;
use Unite\UnisysApi\Modules\GraphQL\GraphQL\Mutations\UpdateMutation as BaseUpdateMutation;
use Unite\UnisysApi\Modules\Permissions\PermissionRepository;

class UpdateMutation extends BaseUpdateMutation
{
    protected $attributes = [
        'name' => 'updatePermission',
    ];

    public function repositoryClass()
    : string
    {
        return PermissionRepository::class;
    }

    public function args()
    {
        return array_merge(parent::args(), [
            'name'       => [
                'type'  => Type::string(),
                'rules' => [
                    'string',
                ],
            ],
            'guard_name' => [
                'type'  => Type::string(),
                'rules' => [
                    'string',
                ],
            ],
        ]);
    }
}
