<?php

namespace Unite\UnisysApi\Modules\Users\GraphQL\Mutations;

use GraphQL\Type\Definition\Type;
use Unite\UnisysApi\GraphQL\Mutations\UpdateMutation as BaseUpdateMutation;
use Illuminate\Database\Eloquent\Model;
use Unite\UnisysApi\Modules\Users\UserRepository;

class UpdateMutation extends BaseUpdateMutation
{
    protected $attributes = [
        'name' => 'updateUser',
    ];

    public function repositoryClass()
    : string
    {
        return UserRepository::class;
    }

    public function args()
    {
        return array_merge(parent::args(), [
            'name'                  => [
                'type'  => Type::string(),
                'rules' => 'string|min:3|max:100',
            ],
            'surname'               => [
                'type'  => Type::string(),
                'rules' => 'string|max:100',
            ],
            'email'                 => [
                'type' => Type::string(),
            ],
            'username'              => [
                'type' => Type::string(),
            ],
            'password'              => [
                'type'  => Type::string(),
                'rules' => 'string|confirmed|min:6|max:30',
            ],
            'password_confirmation' => [
                'type'  => Type::string(),
                'rules' => 'required_with:password|string|min:6|max:30',
            ],
            'active'                => [
                'type'  => Type::boolean(),
                'rules' => [
                    'boolean',
                ],
            ],
            'roles_ids'             => [
                'type'  => Type::listOf(Type::int()),
                'rules' => 'array',
            ],
        ]);
    }

    public function rules(array $args = [])
    {
        return [
            'email'    => [
                'email',
                'unique:users,email,' . $args['id'],
            ],
            'username' => [
                'regex:/^\S*$/u',
                'min:4',
                'max:50',
                'unique:users,username,' . $args['id'],
            ],
        ];
    }

    protected function afterUpdate(Model $model, $root, $args)
    {
        $model->roles()->sync($args['roles_ids'] ?? []);
    }
}
