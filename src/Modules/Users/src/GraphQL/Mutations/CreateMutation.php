<?php

namespace Unite\UnisysApi\Modules\Users\GraphQL\Mutations;

use GraphQL\Type\Definition\Type;
use Unite\UnisysApi\GraphQL\Mutations\CreateMutation as BaseCreateMutation;
use Unite\UnisysApi\Models\Model;
use Unite\UnisysApi\Modules\Users\UserRepository;
use GraphQL;

class CreateMutation extends BaseCreateMutation
{
    protected $attributes = [
        'name' => 'createUser',
    ];

    public function repositoryClass()
    : string
    {
        return UserRepository::class;
    }

    public function type()
    {
        return GraphQL::type('User');
    }

    public function args()
    {
        return [
            'name'                  => [
                'type'  => Type::string(),
                'rules' => 'required|string|min:3|max:100',
            ],
            'surname'               => [
                'type'  => Type::string(),
                'rules' => 'string|max:100',
            ],
            'email'                 => [
                'type'  => Type::string(),
                'rules' => 'required|email|unique:users,email',
            ],
            'username'              => [
                'type'  => Type::string(),
                'rules' => 'required|regex:/^\S*$/u|min:4|max:20|unique:users',
            ],
            'password'              => [
                'type'  => Type::string(),
                'rules' => 'required|string|confirmed|min:6|max:30',
            ],
            'password_confirmation' => [
                'type'  => Type::string(),
                'rules' => 'required|string|min:6|max:30',
            ],
            'roles_id'              => [
                'type'  => Type::listOf(Type::int()),
                'rules' => 'array',
            ],
        ];
    }

    protected function afterCreate(Model $model, $root, $args)
    {
        if(isset($args['roles_id'])) {
            $model->roles()->sync($args['roles_id'] ?: []);
        }
    }
}
