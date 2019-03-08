<?php

namespace Unite\UnisysApi\Modules\Permissions\GraphQL;

use GraphQL;
use Rebing\GraphQL\Support\Query;
use Unite\UnisysApi\Modules\Permissions\Permission;

class ListQuery extends Query
{
    protected $attributes = [
        'name' => 'roles',
    ];

    public function type()
    {
        return GraphQL::pagination(GraphQL::type('Role'));
    }

    public function args()
    {
        return [
            'paging' => [
                'type' => GraphQL::type('PaginationInput')
            ],
            'filter' => [
                'type' => GraphQL::type('QueryFilterInput')
            ]
        ];
    }

    public function resolve($root, $args)
    {
        $allPermissions = Permission::all([
            'id',
            'name',
            'guard_name',
        ]);
        $permissionsForRole = $model->permissions()->get([
            'id',
            'name',
            'guard_name',
        ]);

        $allPermissions->transform(function (Permission $item) use ($permissionsForRole) {
            $selected = false;

            if ($permissionsForRole->contains('id', $item->id)) {
                $selected = true;
            }

            $item->selected = $selected;

            return $item;
        });

        $model->frontendPermissions = $allPermissions->where('guard_name', '=', 'frontend')->values();
        $model->apiPermissions = $allPermissions->where('guard_name', '=', 'api')->values();

        return response()->json([
            'data' => $model,
        ], 200);
    }
}
