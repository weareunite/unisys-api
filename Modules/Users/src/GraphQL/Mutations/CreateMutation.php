<?php

namespace Unite\UnisysApi\Modules\Users\GraphQL\Mutations;

use Illuminate\Database\Eloquent\Model;
use Unite\UnisysApi\Modules\GraphQL\GraphQL\Mutations\CreateMutation as BaseCreateMutation;
use Unite\UnisysApi\Modules\Users\User;

class CreateMutation extends BaseCreateMutation
{
    protected function inputClass()
    : string
    {
        return config('unisys.userInput');
    }

    protected function modelClass()
    : string
    {
        return config('unisys.user');
    }

    protected function create(array $data)
    : Model
    {
        /** @var User $model */
        $model = parent::create($data);

        if (isset($args['roles_ids'])) {
            $model->roles()->sync($data['roles_ids'] ?: []);
        }

        return $model;
    }
}
