<?php

namespace Unite\UnisysApi\Modules\Users\GraphQL\Mutations;

use Unite\UnisysApi\Modules\GraphQL\GraphQL\Mutations\UpdateMutation as BaseUpdateMutation;

class UpdateMutation extends BaseUpdateMutation
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

    protected function update(array $args)
    {
        parent::update($args);

        $this->model->roles()->sync($args['roles_ids'] ?? []);
    }


    public function rules(array $args = [])
    : array
    {
        return [
            'email'    => [
                'email',
                'unique:users,email,' . $args['id'],
            ],
            'username' => [
                'regex:/^\S*$/u',
                'min:4',
                'max:100',
                'unique:users,username,' . $args['id'],
            ],
        ];
    }
}
