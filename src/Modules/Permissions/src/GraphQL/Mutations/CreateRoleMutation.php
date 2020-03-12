<?php

namespace Unite\UnisysApi\Modules\Permissions\GraphQL\Mutations;

use Unite\UnisysApi\Modules\GraphQL\GraphQL\Mutations\CreateMutation as BaseCreateMutation;
use Unite\UnisysApi\Modules\Permissions\GraphQL\Inputs\RoleInput;
use Unite\UnisysApi\Modules\Permissions\Role;

/**
 * @property Role $model
 */
class CreateRoleMutation extends BaseCreateMutation
{
    protected function modelClass()
    : string
    {
        return Role::class;
    }

    protected function inputClass()
    : string
    {
        return RoleInput::class;
    }

    protected function create(array $args)
    {
        parent::create($args);

        $this->model->permissions()->sync($args['permissions_ids'] ?? []);
    }
}
