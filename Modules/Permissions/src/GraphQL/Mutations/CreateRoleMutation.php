<?php

namespace Unite\UnisysApi\Modules\Permissions\GraphQL\Mutations;

use Illuminate\Database\Eloquent\Model;
use Unite\UnisysApi\Modules\GraphQL\GraphQL\Mutations\CreateMutation as BaseCreateMutation;
use Unite\UnisysApi\Modules\Permissions\GraphQL\Inputs\RoleInput;
use Unite\UnisysApi\Modules\Permissions\Role;

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
    : Model
    {
        /** @var Role $model */
        $model = parent::create($args);

        $model->permissions()->sync($args['permissions_ids'] ?? []);

        return $model;
    }
}
