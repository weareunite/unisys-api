<?php

namespace Unite\UnisysApi\Modules\Users\GraphQL\Mutations;

use Unite\UnisysApi\Modules\GraphQL\GraphQL\Mutations\CreateMutation as BaseCreateMutation;
use Unite\UnisysApi\Modules\Users\GraphQL\Inputs\UserInput;
use Unite\UnisysApi\Modules\Users\User;

class CreateMutation extends BaseCreateMutation
{
    protected function inputClass()
    : string
    {
        return UserInput::class;
    }

    protected function modelClass()
    : string
    {
        return User::class;
    }

    protected function create(array $data)
    {
        parent::create($data);

        if (isset($args['roles_ids'])) {
            $this->model->roles()->sync($data['roles_ids'] ?: []);
        }
    }
}
