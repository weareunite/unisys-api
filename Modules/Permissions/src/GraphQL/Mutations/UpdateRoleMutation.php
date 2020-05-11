<?php

namespace Unite\UnisysApi\Modules\Permissions\GraphQL\Mutations;

use Unite\UnisysApi\Modules\GraphQL\GraphQL\Mutations\UpdateMutation as BaseUpdateMutation;
use Unite\UnisysApi\Modules\Permissions\GraphQL\Inputs\RoleInput;
use Unite\UnisysApi\Modules\Permissions\Role;

/**
 * @property Role $model
 */
class UpdateRoleMutation extends BaseUpdateMutation
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

    protected function update(array $args)
    {
        parent::update($args);

        $this->model->permissions()->sync($args['permissions_ids'] ?? []);
    }
}
