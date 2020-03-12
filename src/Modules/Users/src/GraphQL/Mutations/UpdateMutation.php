<?php

namespace Unite\UnisysApi\Modules\Users\GraphQL\Mutations;

use GraphQL\Type\Definition\Type;
use Unite\UnisysApi\Modules\GraphQL\GraphQL\Mutations\UpdateMutation as BaseUpdateMutation;
use Illuminate\Database\Eloquent\Model;
use Unite\UnisysApi\Modules\Users\GraphQL\Inputs\UserInput;
use Unite\UnisysApi\Modules\Users\User;
use Unite\UnisysApi\Modules\Users\UserRepository;

class UpdateMutation extends BaseUpdateMutation
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
